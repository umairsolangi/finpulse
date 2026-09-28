<?php

namespace App\Console\Commands;

use App\Models\KnowledgeChunk;
use Illuminate\Console\Command;
use Smalot\PdfParser\Parser as PdfParser;
use Symfony\Component\Finder\Finder;

/**
 * IMPORTANT: Only import PDF, Markdown, and plain-text files that are owned
 * or properly licensed by the FinPulse project owner.
 * Do NOT import third-party course material without a valid licence.
 */
class KnowledgeImport extends Command
{
    protected $signature = 'knowledge:import
                            {path : Path to a folder containing .pdf, .md, and .txt files}
                            {--fresh : Delete ALL existing knowledge_chunks before importing}';

    protected $description = 'Import PDF, Markdown, and TXT files into the knowledge_chunks table for the AI assistant';

    /** Target chunk size in words (rough target). */
    private const TARGET_WORDS = 200;

    /** Hard upper limit in words before we force-split. */
    private const MAX_WORDS = 260;

    public function handle(): int
    {
        ini_set('memory_limit', '-1');

        $folderPath = $this->argument('path');

        if (! is_dir($folderPath)) {
            $this->error("Path does not exist or is not a directory: {$folderPath}");

            return self::FAILURE;
        }

        if ($this->option('fresh')) {
            KnowledgeChunk::truncate();
            $this->info('All existing knowledge chunks deleted (--fresh).');
        }

        $finder = (new Finder)
            ->files()
            ->in($folderPath)
            ->name(['*.pdf', '*.md', '*.txt'])
            ->sortByName();

        if (! $finder->hasResults()) {
            $this->warn('No .pdf, .md, or .txt files found in the given path.');

            return self::SUCCESS;
        }

        foreach ($finder as $file) {
            $this->processFile($file->getRealPath(), $file->getFilename());
        }

        $this->info('Import complete.');

        return self::SUCCESS;
    }

    // -------------------------------------------------------------------------
    // File-type dispatchers
    // -------------------------------------------------------------------------

    private function processFile(string $path, string $filename): void
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        match ($extension) {
            'pdf' => $this->processPdf($path, $filename),
            'md', 'txt' => $this->processText($path, $filename),
            default => $this->warn("Skipped unknown extension: {$filename}"),
        };
    }

    private function processPdf(string $path, string $filename): void
    {
        $this->line("Processing PDF: {$filename}");

        try {
            $parser = new PdfParser;
            $pdf = $parser->parseFile($path);
            $pages = $pdf->getPages();
        } catch (\Throwable $e) {
            $this->warn("  ✗ Could not parse {$filename}: {$e->getMessage()}");

            return;
        }

        if (empty($pages)) {
            $this->warn("  ✗ {$filename}: no pages found — skipping.");

            return;
        }

        // Delete old chunks for this file so re-running never duplicates
        KnowledgeChunk::where('source', $filename)->delete();

        $totalChunks = 0;

        foreach ($pages as $pageNumber => $page) {
            // Page numbers from smalot/pdfparser are 0-indexed; display as 1-indexed
            $humanPage = $pageNumber + 1;

            try {
                $rawText = $page->getText();
            } catch (\Throwable) {
                $rawText = '';
            }

            $cleanText = $this->cleanText($rawText);

            if (mb_strlen($cleanText) < 30) {
                // Too little text — this page is probably an image page; skip silently
                continue;
            }

            $chunks = $this->splitIntoChunks($cleanText);

            foreach ($chunks as $idx => $chunk) {
                $title = $this->deriveTitle($filename, $humanPage, $idx);
                KnowledgeChunk::create([
                    'source' => $filename,
                    'page' => $humanPage,
                    'title' => $title,
                    'content' => $chunk,
                ]);
                $totalChunks++;
            }

            // Free page memory explicitly between pages
            unset($page);
        }

        if ($totalChunks === 0) {
            $this->warn("  ✗ {$filename}: extracted no usable text (possibly a scanned/image PDF). Skipping.");
        } else {
            $this->line("  ✓ {$filename}: {$totalChunks} chunk(s) stored.");
        }
    }

    private function processText(string $path, string $filename): void
    {
        $this->line("Processing: {$filename}");

        $rawText = file_get_contents($path);

        if ($rawText === false) {
            $this->warn("  ✗ Could not read {$filename}");

            return;
        }

        // Delete old chunks for this file so re-running never duplicates
        KnowledgeChunk::where('source', $filename)->delete();

        $cleanText = $this->cleanText($rawText);

        if (mb_strlen($cleanText) < 30) {
            $this->warn("  ✗ {$filename}: file is essentially empty — skipping.");

            return;
        }

        $chunks = $this->splitIntoChunks($cleanText);
        $totalChunks = 0;

        foreach ($chunks as $idx => $chunk) {
            $title = $this->deriveTitle($filename, null, $idx);
            KnowledgeChunk::create([
                'source' => $filename,
                'page' => null,
                'title' => $title,
                'content' => $chunk,
            ]);
            $totalChunks++;
        }

        $this->line("  ✓ {$filename}: {$totalChunks} chunk(s) stored.");
    }

    // -------------------------------------------------------------------------
    // Text-cleaning helpers
    // -------------------------------------------------------------------------

    /**
     * Clean extracted text:
     *  - Remove control characters except newlines/tabs
     *  - Join words hyphenated across lines (e.g., "finan-\ncial" → "financial")
     *  - Collapse multiple blank lines into one paragraph break
     *  - Collapse runs of spaces/tabs within a line
     */
    private function cleanText(string $text): string
    {
        // Remove carriage returns
        $text = str_replace("\r", '', $text);

        // Remove non-printable control chars (keep \n, \t)
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);

        // Rejoin words broken with a hyphen at end-of-line
        $text = preg_replace('/-\n(\w)/', '$1', $text);

        // Collapse runs of spaces/tabs on a single line
        $text = preg_replace('/[ \t]+/', ' ', $text);

        // Trim each line
        $lines = explode("\n", $text);
        $lines = array_map('trim', $lines);
        $text = implode("\n", $lines);

        // Collapse 3+ blank lines to a single paragraph break
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    // -------------------------------------------------------------------------
    // Chunking
    // -------------------------------------------------------------------------

    /**
     * Split text into chunks of roughly TARGET_WORDS words.
     * Splits on paragraph boundaries first, then on sentence boundaries,
     * and never cuts mid-sentence.
     *
     * @return string[]
     */
    private function splitIntoChunks(string $text): array
    {
        // Split into paragraphs first
        $paragraphs = preg_split('/\n{2,}/', $text);
        $paragraphs = array_filter(array_map('trim', $paragraphs));

        $chunks = [];
        $buffer = '';
        $bufferWords = 0;

        foreach ($paragraphs as $para) {
            $paraWords = str_word_count($para);

            if ($bufferWords + $paraWords <= self::MAX_WORDS) {
                // Paragraph fits — add to buffer
                $buffer = $buffer === '' ? $para : "{$buffer}\n\n{$para}";
                $bufferWords += $paraWords;
            } else {
                // Flush current buffer
                if ($buffer !== '') {
                    $chunks[] = $buffer;
                    $buffer = '';
                    $bufferWords = 0;
                }

                // If the paragraph itself is too large, split by sentences
                if ($paraWords > self::MAX_WORDS) {
                    $sentences = $this->splitBySentence($para);
                    $senBuf = '';
                    $senWords = 0;

                    foreach ($sentences as $sentence) {
                        $sw = str_word_count($sentence);

                        if ($senWords + $sw <= self::MAX_WORDS) {
                            $senBuf = $senBuf === '' ? $sentence : "{$senBuf} {$sentence}";
                            $senWords += $sw;
                        } else {
                            if ($senBuf !== '') {
                                $chunks[] = $senBuf;
                            }
                            $senBuf = $sentence;
                            $senWords = $sw;
                        }
                    }

                    if ($senBuf !== '') {
                        $buffer = $senBuf;
                        $bufferWords = $senWords;
                    }
                } else {
                    $buffer = $para;
                    $bufferWords = $paraWords;
                }
            }

            // If buffer is at or above target, flush it
            if ($bufferWords >= self::TARGET_WORDS) {
                $chunks[] = $buffer;
                $buffer = '';
                $bufferWords = 0;
            }
        }

        if ($buffer !== '') {
            $chunks[] = $buffer;
        }

        return array_values(array_filter($chunks, fn ($c) => str_word_count($c) >= 10));
    }

    /**
     * Split a paragraph into individual sentences on ". ", "! ", "? ".
     *
     * @return string[]
     */
    private function splitBySentence(string $text): array
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_filter(array_map('trim', $sentences)));
    }

    // -------------------------------------------------------------------------
    // Title helper
    // -------------------------------------------------------------------------

    private function deriveTitle(string $filename, ?int $page, int $chunkIndex): string
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);

        if ($page !== null) {
            return "{$base} — Page {$page}".($chunkIndex > 0 ? ' (part '.($chunkIndex + 1).')' : '');
        }

        return $base.($chunkIndex > 0 ? ' (part '.($chunkIndex + 1).')' : '');
    }
}

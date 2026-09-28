<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $source The original file name (basename)
 * @property int|null $page PDF page number; null for .md / .txt files
 * @property string $title
 * @property string $content
 */
class KnowledgeChunk extends Model
{
    protected $fillable = ['source', 'page', 'title', 'content'];

    /**
     * Scope a query to search on title + content.
     *
     * On MySQL: uses FULLTEXT NATURAL LANGUAGE MODE for relevance ranking.
     * On SQLite (tests): falls back to a LIKE search so tests run without FULLTEXT support.
     */
    public function scopeSearch(Builder $query, string $term, int $limit = 4): Builder
    {
        if (DB::getDriverName() === 'mysql') {
            return $query
                ->selectRaw(
                    '*, MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE) AS relevance',
                    [$term]
                )
                ->whereRaw('MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE)', [$term])
                ->orderByDesc('relevance')
                ->limit($limit);
        }

        // SQLite fallback (used in tests): search each word as a separate LIKE term
        $words = array_filter(
            preg_split('/\s+/', $term),
            fn ($w) => strlen($w) > 3 // skip stop-words shorter than 4 chars
        );

        if (empty($words)) {
            $words = [$term];
        }

        return $query
            ->where(function (Builder $q) use ($words) {
                foreach ($words as $word) {
                    $like = '%'.$word.'%';
                    $q->orWhere('title', 'like', $like)
                        ->orWhere('content', 'like', $like);
                }
            })
            ->limit($limit);
    }
}

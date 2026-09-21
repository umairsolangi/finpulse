<?php

namespace Database\Seeders;

use App\Enums\ContentTier;
use App\Enums\CourseTopic;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseTopicSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first() ?? User::first();
        $tariq = User::where('email', 'tariq@example.com')->first() ?? $admin;
        $ayesha = User::where('email', 'ayesha@example.com')->first() ?? $admin;
        $usman = User::where('email', 'usman@example.com')->first() ?? $admin;
        $testUser = User::where('email', 'test@example.com')->first() ?? $admin;

        $bootcamp = Course::where('slug', 'psx-beginner-bootcamp')->first();
        if ($bootcamp) {
            $bootcamp->update([
                'topic' => CourseTopic::STOCKS,
                'published_at' => Carbon::now()->subDays(20),
            ]);
        }

        $valuation = Course::where('slug', 'advanced-equity-valuation')->first();
        if ($valuation) {
            $valuation->update([
                'topic' => CourseTopic::STOCKS,
                'published_at' => Carbon::now()->subDays(15),
            ]);
        }

        $tech = Course::updateOrCreate(['slug' => 'mastering-technical-analysis-psx'], [
            'title' => 'Mastering Technical Analysis & PSX Price Action',
            'description' => 'Learn key support and resistance zones, candlestick reversal patterns, RSI, and MACD indicators to time market entries.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::INTERMEDIATE,
            'topic' => CourseTopic::TECHNICAL_ANALYSIS,
            'published_at' => Carbon::now()->subDays(12),
            'created_by' => $tariq->id,
        ]);

        $funds = Course::updateOrCreate(['slug' => 'mutual-funds-money-market-allocation'], [
            'title' => 'Mutual Funds & Smart Money Market Allocation',
            'description' => 'Understand NAV calculations, equity vs fixed income funds, and maximize post-tax yields with voluntary pension schemes.',
            'tier' => ContentTier::FREE,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::BEGINNER,
            'topic' => CourseTopic::MUTUAL_FUNDS,
            'published_at' => Carbon::now()->subDays(8),
            'created_by' => $ayesha->id,
        ]);

        $basics = Course::updateOrCreate(['slug' => 'personal-finance-foundations'], [
            'title' => 'Personal Finance Foundations & Debt Management',
            'description' => 'Build a high-yield emergency buffer, optimize monthly cashflow, and establish disciplined long-term compounding habits.',
            'tier' => ContentTier::FREE,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::BEGINNER,
            'topic' => CourseTopic::BASICS,
            'published_at' => Carbon::now()->subDays(5),
            'created_by' => $usman->id,
        ]);

        $futures = Course::updateOrCreate(['slug' => 'futures-trading-hedging-pakistan'], [
            'title' => 'Futures Trading & Risk Hedging in Pakistan',
            'description' => 'Demystify deliverable futures contracts (DFCs), cash-settled futures, margin requirements, and short-term volatility management.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::ADVANCED,
            'topic' => CourseTopic::OPTIONS_DERIVATIVES,
            'published_at' => Carbon::now()->subDays(2),
            'created_by' => $tariq->id,
        ]);

        $islamic = Course::updateOrCreate(['slug' => 'islamic-investing-shariah-screening'], [
            'title' => 'Islamic Investing & Shariah Screening Principles',
            'description' => 'Understand KMI-30 screening criteria, debt-to-asset ratios, non-compliant income purification, and sovereign Sukuk certificates.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::INTERMEDIATE,
            'topic' => CourseTopic::ISLAMIC_FINANCE,
            'published_at' => Carbon::now()->subHours(12),
            'created_by' => $admin->id,
        ]);

        $techChapter = CourseChapter::firstOrCreate([
            'course_id' => $tech->id,
            'title' => 'Introduction to Candlestick Patterns',
        ], [
            'order' => 1,
        ]);

        $fundsChapter = CourseChapter::firstOrCreate([
            'course_id' => $funds->id,
            'title' => 'Understanding Net Asset Value (NAV)',
        ], [
            'order' => 1,
        ]);

        $basicsChapter = CourseChapter::firstOrCreate([
            'course_id' => $basics->id,
            'title' => 'Budgeting & Saving Rules',
        ], [
            'order' => 1,
        ]);

        $bootcampChapter = CourseChapter::where('course_id', $bootcamp?->id)->first();

        // Seed some CourseProgress so counts and Popular ordering are realistic
        if ($bootcamp && $bootcampChapter && $testUser) {
            CourseProgress::firstOrCreate([
                'user_id' => $testUser->id,
                'chapter_id' => $bootcampChapter->id,
            ], [
                'course_id' => $bootcamp->id,
                'completed_at' => now(),
            ]);
        }
        if ($bootcamp && $bootcampChapter && $tariq) {
            CourseProgress::firstOrCreate([
                'user_id' => $tariq->id,
                'chapter_id' => $bootcampChapter->id,
            ], [
                'course_id' => $bootcamp->id,
                'completed_at' => now(),
            ]);
        }
        if ($tech && $techChapter && $testUser) {
            CourseProgress::firstOrCreate([
                'user_id' => $testUser->id,
                'chapter_id' => $techChapter->id,
            ], [
                'course_id' => $tech->id,
                'completed_at' => now(),
            ]);
        }
        if ($tech && $techChapter && $ayesha) {
            CourseProgress::firstOrCreate([
                'user_id' => $ayesha->id,
                'chapter_id' => $techChapter->id,
            ], [
                'course_id' => $tech->id,
                'completed_at' => now(),
            ]);
        }
        if ($tech && $techChapter && $usman) {
            CourseProgress::firstOrCreate([
                'user_id' => $usman->id,
                'chapter_id' => $techChapter->id,
            ], [
                'course_id' => $tech->id,
                'completed_at' => now(),
            ]);
        }
        if ($funds && $fundsChapter && $usman) {
            CourseProgress::firstOrCreate([
                'user_id' => $usman->id,
                'chapter_id' => $fundsChapter->id,
            ], [
                'course_id' => $funds->id,
                'completed_at' => now(),
            ]);
        }
    }
}

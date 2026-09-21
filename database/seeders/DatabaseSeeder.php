<?php

namespace Database\Seeders;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\CourseTopic;
use App\Enums\Language;
use App\Enums\PostCategory;
use App\Enums\SkillLevel;
use App\Models\Comment;
use App\Models\ContentItem;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use App\Models\WeeklyActivityPoint;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            BadgesSeeder::class,
        ]);

        // 1. Create Test User
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'activity_score' => 45,
        ]);
        $testUser->assignRole('Free Member');

        // 2. Create Admin User
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'activity_score' => 120,
        ]);
        $adminUser->assignRole('Admin');

        // 3. Create Sample Community Members
        $members = collect([
            ['name' => 'Tariq Mahmood', 'email' => 'tariq@example.com', 'score' => 95],
            ['name' => 'Ayesha Khan', 'email' => 'ayesha@example.com', 'score' => 80],
            ['name' => 'Usman Ali', 'email' => 'usman@example.com', 'score' => 70],
            ['name' => 'Hamza Sheikh', 'email' => 'hamza@example.com', 'score' => 65],
            ['name' => 'Sara Ahmed', 'email' => 'sara@example.com', 'score' => 50],
            ['name' => 'Zaid Malik', 'email' => 'zaid@example.com', 'score' => 40],
            ['name' => 'Fatima Noor', 'email' => 'fatima@example.com', 'score' => 30],
        ])->map(function ($data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'activity_score' => $data['score'],
            ]);
            $user->assignRole('Free Member');

            return $user;
        });

        $allUsers = $members->concat([$testUser, $adminUser]);

        // 4. Seed Content Items for /learn Library
        $sampleContent = [
            [
                'title' => 'Understanding Price-to-Earnings (P/E) Ratios in PSX',
                'type' => ContentType::ARTICLE,
                'tier' => ContentTier::FREE,
                'skill_level' => SkillLevel::BEGINNER,
                'duration' => 12,
                'body' => 'The Price-to-Earnings (P/E) ratio is one of the most widely used valuation metrics for evaluating companies listed on the Pakistan Stock Exchange. Learn how to compare earnings yield with treasury bills and evaluate market sectors.',
            ],
            [
                'title' => 'Beginners Guide to Mutual Funds & Income Funds in Pakistan',
                'type' => ContentType::ARTICLE,
                'tier' => ContentTier::FREE,
                'skill_level' => SkillLevel::BEGINNER,
                'duration' => 15,
                'body' => 'Mutual funds allow retail investors to pool their capital for professional management. This guide covers money market funds, equity funds, and tax credit eligibility.',
            ],
            [
                'title' => 'How to Read Stock Candlestick Charts & Market Support Levels',
                'type' => ContentType::VIDEO,
                'type_val' => ContentType::VIDEO,
                'tier' => ContentTier::FREE,
                'skill_level' => SkillLevel::INTERMEDIATE,
                'duration' => 25,
                'body' => 'A step-by-step video breakdown explaining candlestick patterns, resistance levels, and volume indicators on KSE-100 index stocks.',
            ],
            [
                'title' => 'Demystifying the KSE-100 Index Weighting & Rebalancing',
                'type' => ContentType::ARTICLE,
                'tier' => ContentTier::FREE,
                'skill_level' => SkillLevel::INTERMEDIATE,
                'duration' => 18,
                'body' => 'Understand how market capitalization affects KSE-100 fluctuations and why top sectors like Commercial Banks and Fertilizer drive daily index movements.',
            ],
            [
                'title' => 'Building a Dividend Yield Portfolio with Blue Chip Stocks',
                'type' => ContentType::ARTICLE,
                'tier' => ContentTier::PAID,
                'skill_level' => SkillLevel::ADVANCED,
                'duration' => 30,
                'body' => 'An in-depth guide on constructing a passive income portfolio using high-payout dividend stocks, evaluating payout ratios, and managing sector risk.',
            ],
        ];

        foreach ($sampleContent as $item) {
            ContentItem::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'type' => $item['type'],
                'tier' => $item['tier'],
                'language' => Language::ENGLISH,
                'skill_level' => $item['skill_level'],
                'body' => $item['body'],
                'duration_minutes' => $item['duration'],
                'published_at' => now(),
                'created_by' => $adminUser->id,
            ]);
        }

        // 5. Seed Community Feed Posts, Comments & Reactions
        $samplePosts = [
            [
                'user' => $members[0],
                'category' => PostCategory::STOCKS,
                'body' => 'What are your thoughts on the recent commercial banking sector earnings results? The dividend yields are looking attractive for long-term investors.',
            ],
            [
                'user' => $members[1],
                'category' => PostCategory::MUTUAL_FUNDS,
                'body' => 'Just allocated 30% of my monthly savings into a low-risk money market fund. Great way to park emergency cash while yielding steady monthly returns!',
            ],
            [
                'user' => $members[2],
                'category' => PostCategory::BASICS,
                'body' => 'Tip of the day: Always keep 3 to 6 months of living expenses in an accessible liquid asset before putting money into volatile equity markets.',
            ],
            [
                'user' => $members[3],
                'category' => PostCategory::NEWS,
                'body' => 'Welcome to all the new members on FinPulse! Feel free to ask any beginner questions in the feed.',
            ],
        ];

        foreach ($samplePosts as $postData) {
            $post = Post::create([
                'user_id' => $postData['user']->id,
                'category' => $postData['category'],
                'body' => $postData['body'],
            ]);

            // Add sample comments
            Comment::create([
                'post_id' => $post->id,
                'user_id' => $testUser->id,
                'body' => 'Great point! Thanks for sharing this insight.',
            ]);

            Comment::create([
                'post_id' => $post->id,
                'user_id' => $adminUser->id,
                'body' => 'Agreed. Diversification across multiple asset classes is key.',
            ]);

            // Add sample reactions
            Reaction::create([
                'post_id' => $post->id,
                'user_id' => $members[4]->id,
            ]);

            Reaction::create([
                'post_id' => $post->id,
                'user_id' => $members[5]->id,
            ]);
        }

        // 6. Seed Weekly Activity Points for Leaderboard
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        foreach ($allUsers as $u) {
            if ($u->activity_score > 0) {
                WeeklyActivityPoint::create([
                    'user_id' => $u->id,
                    'week_start_date' => $currentWeekStart,
                    'points' => $u->activity_score,
                ]);
            }
        }

        // 7. Seed Sample Courses & Chapters for LMS Core
        $sampleItems = ContentItem::take(4)->get();

        $bootcampCourse = Course::create([
            'title' => 'Pakistan Stock Exchange (PSX) Beginner Bootcamp',
            'slug' => 'psx-beginner-bootcamp',
            'description' => 'A comprehensive introductory course on navigating the Pakistan Stock Exchange, opening a CDC sub-account, reading quotes, and executing your first trade with confidence.',
            'tier' => ContentTier::FREE,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::BEGINNER,
            'topic' => CourseTopic::STOCKS,
            'published_at' => Carbon::now()->subDays(20),
            'created_by' => $adminUser->id,
        ]);

        $chapter1 = CourseChapter::create([
            'course_id' => $bootcampCourse->id,
            'content_item_id' => $sampleItems[0]?->id,
            'title' => 'Understanding Capital Markets & What the PSX Does',
            'order' => 1,
        ]);

        $chapter2 = CourseChapter::create([
            'course_id' => $bootcampCourse->id,
            'content_item_id' => $sampleItems[1]?->id,
            'title' => 'Broker Selection, NCCPL, and CDC Account Setup',
            'order' => 2,
        ]);

        $chapter3 = CourseChapter::create([
            'course_id' => $bootcampCourse->id,
            'content_item_id' => $sampleItems[2]?->id,
            'title' => 'How to Place Buy and Sell Orders via Online Terminals',
            'order' => 3,
        ]);

        $chapter4 = CourseChapter::create([
            'course_id' => $bootcampCourse->id,
            'content_item_id' => $sampleItems[3]?->id,
            'title' => 'Risk Management and Capital Preservation Rules',
            'order' => 4,
        ]);

        // Seed initial progress for Test User on Bootcamp chapter 1
        CourseProgress::create([
            'user_id' => $testUser->id,
            'course_id' => $bootcampCourse->id,
            'chapter_id' => $chapter1->id,
            'completed_at' => now(),
        ]);

        // Seed a Paid Tier Course (Valuation)
        $paidCourse = Course::create([
            'title' => 'Advanced Equity Valuation & Sector Financial Modeling',
            'slug' => 'advanced-equity-valuation',
            'description' => 'Deep dive into DCF modeling, dividend discount methods, and financial statement analysis of KSE-100 listed firms.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::ADVANCED,
            'topic' => CourseTopic::STOCKS,
            'published_at' => Carbon::now()->subDays(15),
            'created_by' => $adminUser->id,
        ]);

        CourseChapter::create([
            'course_id' => $paidCourse->id,
            'title' => 'Financial Statement Normalization for High-Inflation Economies',
            'order' => 1,
        ]);

        CourseChapter::create([
            'course_id' => $paidCourse->id,
            'title' => 'Building a Discounted Cash Flow (DCF) Model',
            'order' => 2,
        ]);

        // Additional courses across topics for rich real-data carousel
        $techAnalysisCourse = Course::create([
            'title' => 'Mastering Technical Analysis & PSX Price Action',
            'slug' => 'mastering-technical-analysis-psx',
            'description' => 'Learn key support and resistance zones, candlestick reversal patterns, RSI, and MACD indicators to time market entries.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::INTERMEDIATE,
            'topic' => CourseTopic::TECHNICAL_ANALYSIS,
            'published_at' => Carbon::now()->subDays(12),
            'created_by' => $members[0]->id, // Tariq Mahmood
        ]);

        $mutualFundsCourse = Course::create([
            'title' => 'Mutual Funds & Smart Money Market Allocation',
            'slug' => 'mutual-funds-money-market-allocation',
            'description' => 'Understand NAV calculations, equity vs fixed income funds, and maximize post-tax yields with voluntary pension schemes.',
            'tier' => ContentTier::FREE,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::BEGINNER,
            'topic' => CourseTopic::MUTUAL_FUNDS,
            'published_at' => Carbon::now()->subDays(8),
            'created_by' => $members[1]->id, // Ayesha Khan
        ]);

        $basicsCourse = Course::create([
            'title' => 'Personal Finance Foundations & Debt Management',
            'slug' => 'personal-finance-foundations',
            'description' => 'Build a high-yield emergency buffer, optimize monthly cashflow, and establish disciplined long-term compounding habits.',
            'tier' => ContentTier::FREE,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::BEGINNER,
            'topic' => CourseTopic::BASICS,
            'published_at' => Carbon::now()->subDays(5),
            'created_by' => $members[2]->id, // Usman Ali
        ]);

        $futuresCourse = Course::create([
            'title' => 'Futures Trading & Risk Hedging in Pakistan',
            'slug' => 'futures-trading-hedging-pakistan',
            'description' => 'Demystify deliverable futures contracts (DFCs), cash-settled futures, margin requirements, and short-term volatility management.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::ADVANCED,
            'topic' => CourseTopic::OPTIONS_DERIVATIVES,
            'published_at' => Carbon::now()->subDays(2),
            'created_by' => $members[3]->id, // Hamza Sheikh
        ]);

        $islamicCourse = Course::create([
            'title' => 'Islamic Investing & Shariah Screening Principles',
            'slug' => 'islamic-investing-shariah-screening',
            'description' => 'Understand KMI-30 screening criteria, debt-to-asset ratios, non-compliant income purification, and sovereign Sukuk certificates.',
            'tier' => ContentTier::PAID,
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::INTERMEDIATE,
            'topic' => CourseTopic::ISLAMIC_FINANCE,
            'published_at' => Carbon::now()->subHours(12),
            'created_by' => $adminUser->id,
        ]);

        $techChapter = CourseChapter::create([
            'course_id' => $techAnalysisCourse->id,
            'title' => 'Candlestick Basics & Key Support Levels',
            'order' => 1,
        ]);

        $mutualFundsChapter = CourseChapter::create([
            'course_id' => $mutualFundsCourse->id,
            'title' => 'Mutual Funds Selection & Asset Allocation',
            'order' => 1,
        ]);

        $basicsChapter = CourseChapter::create([
            'course_id' => $basicsCourse->id,
            'title' => 'Emergency Funds and Budgeting',
            'order' => 1,
        ]);

        CourseChapter::create([
            'course_id' => $futuresCourse->id,
            'title' => 'Understanding PSX Deliverable Futures',
            'order' => 1,
        ]);

        CourseChapter::create([
            'course_id' => $islamicCourse->id,
            'title' => 'KMI-30 Index & Shariah Screens',
            'order' => 1,
        ]);

        // Seed diverse progress counts to test Popular tab ordering:
        // Bootcamp Course: 4 users
        foreach ([$testUser, $members[0], $members[1], $members[2]] as $u) {
            CourseProgress::firstOrCreate([
                'user_id' => $u->id,
                'chapter_id' => $chapter1->id,
            ], [
                'course_id' => $bootcampCourse->id,
                'completed_at' => now(),
            ]);
        }

        // Technical Analysis: 3 users
        foreach ([$testUser, $members[1], $members[3]] as $u) {
            CourseProgress::firstOrCreate([
                'user_id' => $u->id,
                'chapter_id' => $techChapter->id,
            ], [
                'course_id' => $techAnalysisCourse->id,
                'completed_at' => now(),
            ]);
        }

        // Mutual Funds: 2 users
        foreach ([$members[0], $members[2]] as $u) {
            CourseProgress::firstOrCreate([
                'user_id' => $u->id,
                'chapter_id' => $mutualFundsChapter->id,
            ], [
                'course_id' => $mutualFundsCourse->id,
                'completed_at' => now(),
            ]);
        }

        // Basics: 1 user
        CourseProgress::firstOrCreate([
            'user_id' => $testUser->id,
            'chapter_id' => $basicsChapter->id,
        ], [
            'course_id' => $basicsCourse->id,
            'completed_at' => now(),
        ]);

        // Futures & Islamic: 0 users (so enrollment count is hidden as requested)
    }
}

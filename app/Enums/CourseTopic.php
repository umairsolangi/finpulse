<?php

namespace App\Enums;

enum CourseTopic: string
{
    case STOCKS = 'stocks';
    case MUTUAL_FUNDS = 'mutual_funds';
    case TECHNICAL_ANALYSIS = 'technical_analysis';
    case BASICS = 'basics';
    case OPTIONS_DERIVATIVES = 'options_derivatives';
    case ISLAMIC_FINANCE = 'islamic_finance';

    public function label(): string
    {
        return match ($this) {
            self::STOCKS => 'Stocks & PSX',
            self::MUTUAL_FUNDS => 'Mutual Funds',
            self::TECHNICAL_ANALYSIS => 'Technical Analysis',
            self::BASICS => 'Basics',
            self::OPTIONS_DERIVATIVES => 'Futures & Derivatives',
            self::ISLAMIC_FINANCE => 'Islamic Investing',
        };
    }
}

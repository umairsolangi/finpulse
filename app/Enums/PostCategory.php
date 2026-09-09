<?php

namespace App\Enums;

enum PostCategory: string
{
    case STOCKS = 'stocks';
    case MUTUAL_FUNDS = 'mutual_funds';
    case BASICS = 'basics';
    case NEWS = 'news';
}

<?php

namespace App\Enums;

enum ContentType: string
{
    case VIDEO = 'video';
    case ARTICLE = 'article';
    case COURSE_CHAPTER = 'course_chapter';
}

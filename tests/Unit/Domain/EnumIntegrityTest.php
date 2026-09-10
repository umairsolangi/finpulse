<?php

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\PostCategory;
use App\Enums\SkillLevel;
use App\Models\ContentItem;

test('assigning non-backed enum values raises a ValueError or TypeError', function () {
    expect(fn () => ContentTier::from('invalid_tier'))
        ->toThrow(ValueError::class);

    expect(fn () => ContentType::from('invalid_type'))
        ->toThrow(ValueError::class);

    expect(fn () => Language::from('invalid_lang'))
        ->toThrow(ValueError::class);

    expect(fn () => SkillLevel::from('invalid_level'))
        ->toThrow(ValueError::class);

    expect(fn () => PostCategory::from('invalid_category'))
        ->toThrow(ValueError::class);
});

test('assigning invalid enum value directly to model attribute raises ValueError or TypeError', function () {
    $contentItem = new ContentItem;

    expect(fn () => $contentItem->tier = 'invalid_tier_string')
        ->toThrow(ValueError::class);
});

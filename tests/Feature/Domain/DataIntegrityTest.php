<?php

use App\Models\Badge;
use App\Models\Comment;
use App\Models\ContentItem;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseProgress;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\QueryException;

test('course hasMany course_chapters and course_chapter belongsTo content_item', function () {
    $course = Course::factory()->create();
    $contentItem = ContentItem::factory()->create();
    $chapter = CourseChapter::factory()->create([
        'course_id' => $course->id,
        'content_item_id' => $contentItem->id,
    ]);

    expect($course->chapters)->toHaveCount(1)
        ->and($course->chapters->first()->id)->toBe($chapter->id)
        ->and($chapter->contentItem->id)->toBe($contentItem->id);
});

test('deleting a post clears its comments via cascade deletion', function () {
    $post = Post::factory()->create();
    $comment1 = Comment::factory()->create(['post_id' => $post->id]);
    $comment2 = Comment::factory()->create(['post_id' => $post->id]);

    expect(Comment::where('post_id', $post->id)->count())->toBe(2);

    $post->delete();

    expect(Comment::where('post_id', $post->id)->count())->toBe(0)
        ->and(Comment::find($comment1->id))->toBeNull()
        ->and(Comment::find($comment2->id))->toBeNull();
});

test('user belongsToMany badge yields correct earned_at pivot data', function () {
    $user = User::factory()->create();
    $badge = Badge::factory()->create();
    $earnedAt = now()->subDays(2)->startOfSecond();

    $user->badges()->attach($badge->id, ['earned_at' => $earnedAt]);

    $retrievedBadge = $user->fresh()->badges->first();

    expect($retrievedBadge)->not->toBeNull()
        ->and($retrievedBadge->id)->toBe($badge->id)
        ->and($retrievedBadge->pivot->earned_at)->not->toBeNull();
});

test('unique composite key violation on course_progress when duplicating user_id and chapter_id', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id]);

    CourseProgress::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'chapter_id' => $chapter->id,
    ]);

    expect(function () use ($user, $course, $chapter) {
        CourseProgress::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'chapter_id' => $chapter->id,
            'completed_at' => now(),
        ]);
    })->toThrow(QueryException::class);
});

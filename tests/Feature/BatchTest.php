<?php

use App\Enums\ContentTier;
use App\Livewire\Admin\Batches\Index as AdminBatchesIndex;
use App\Livewire\Admin\Batches\Show as AdminBatchesShow;
use App\Livewire\Course\ChapterViewer;
use App\Models\Batch;
use App\Models\BatchEnrollment;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

// -----------------------------------------------------------------------
// ACCESS ENFORCEMENT TESTS
// -----------------------------------------------------------------------

test('a paid subscriber CANNOT view a batch-restricted course — batch gate overrides subscription', function () {
    $author = User::factory()->create();
    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => true,
        'created_by' => $author->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $paidUser = User::factory()->create();
    $paidUser->assignRole('Paid Subscriber');

    // Has an active subscription but NOT in any batch — must be blocked
    Livewire::actingAs($paidUser)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', false)
        ->assertViewHas('accessMessage', 'batch')
        ->assertSee('enrolled batch members');
});

test('a Free Member enrolled in an active batch CAN view the batch-restricted course', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => true,
        'created_by' => $admin->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $freeMember = User::factory()->create();
    $freeMember->assignRole('Free Member');

    $batch = Batch::factory()->active()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    BatchEnrollment::create([
        'batch_id' => $batch->id,
        'user_id' => $freeMember->id,
        'added_by' => $admin->id,
        'enrolled_at' => now(),
    ]);

    Livewire::actingAs($freeMember)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', true)
        ->assertViewHas('accessMessage', 'batch');
});

test('a user enrolled in a COMPLETED batch is blocked from a batch-restricted course', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => true,
        'created_by' => $admin->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $member = User::factory()->create();
    $member->assignRole('Free Member');

    $batch = Batch::factory()->completed()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    BatchEnrollment::create([
        'batch_id' => $batch->id,
        'user_id' => $member->id,
        'added_by' => $admin->id,
        'enrolled_at' => now(),
    ]);

    Livewire::actingAs($member)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', false);
});

test('a user enrolled in an UPCOMING batch is blocked from a batch-restricted course (active-only enforcement)', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => true,
        'created_by' => $admin->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $member = User::factory()->create();
    $member->assignRole('Free Member');

    $batch = Batch::factory()->upcoming()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    BatchEnrollment::create([
        'batch_id' => $batch->id,
        'user_id' => $member->id,
        'added_by' => $admin->id,
        'enrolled_at' => now(),
    ]);

    Livewire::actingAs($member)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', false);
});

test('a course with restricted_to_batches=false is completely unaffected — paid subscriber still gets normal access', function () {
    $author = User::factory()->create();
    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => false,
        'created_by' => $author->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $paidUser = User::factory()->create();
    $paidUser->assignRole('Paid Subscriber');

    Livewire::actingAs($paidUser)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', true)
        ->assertViewHas('accessMessage', 'tier');
});

test('a course with restricted_to_batches=false free member still sees tier gate as before', function () {
    $author = User::factory()->create();
    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => false,
        'created_by' => $author->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $freeMember = User::factory()->create();
    $freeMember->assignRole('Free Member');

    Livewire::actingAs($freeMember)
        ->test(ChapterViewer::class, ['slug' => $course->slug, 'chapterId' => $chapter->id])
        ->assertViewHas('canAccess', false)
        ->assertViewHas('accessMessage', 'tier');
});

// -----------------------------------------------------------------------
// PERMISSION TESTS
// -----------------------------------------------------------------------

test('only Admin can create a batch — Instructor gets 403', function () {
    $instructor = User::factory()->create();
    $instructor->assignRole('Instructor');

    $this->actingAs($instructor)
        ->get(route('admin.batches.index'))
        ->assertOk(); // Instructor can view batches listing

    // But attempting createBatch action must be forbidden
    Livewire::actingAs($instructor)
        ->test(AdminBatchesIndex::class)
        ->call('toggleCreateForm')
        ->assertForbidden();
});

test('Admin can access batch management and see create form', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    Livewire::actingAs($admin)
        ->test(AdminBatchesIndex::class)
        ->call('toggleCreateForm')
        ->assertSet('showCreateForm', true);
});

test('a Free Member cannot access the batch admin page', function () {
    $freeMember = User::factory()->create();
    $freeMember->assignRole('Free Member');

    $this->actingAs($freeMember)
        ->get(route('admin.batches.index'))
        ->assertForbidden();
});

test('a Paid Subscriber cannot access the batch admin page', function () {
    $paid = User::factory()->create();
    $paid->assignRole('Paid Subscriber');

    $this->actingAs($paid)
        ->get(route('admin.batches.index'))
        ->assertForbidden();
});

test('an Instructor can only manage students for batches of courses they created', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $instructor = User::factory()->create();
    $instructor->assignRole('Instructor');

    // Course created by someone else
    $otherAuthor = User::factory()->create();
    $course = Course::factory()->create(['created_by' => $otherAuthor->id]);
    $batch = Batch::factory()->active()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    $this->actingAs($instructor)
        ->get(route('admin.batches.show', $batch->id))
        ->assertForbidden();
});

test('an Instructor CAN manage students for their own course batch', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $instructor = User::factory()->create();
    $instructor->assignRole('Instructor');

    $course = Course::factory()->create(['created_by' => $instructor->id]);
    $batch = Batch::factory()->active()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    $this->actingAs($instructor)
        ->get(route('admin.batches.show', $batch->id))
        ->assertOk();
});

// -----------------------------------------------------------------------
// DATA INTEGRITY TESTS
// -----------------------------------------------------------------------

test('duplicate enrollment of the same user in the same batch is prevented', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'restricted_to_batches' => true,
        'created_by' => $admin->id,
    ]);
    $batch = Batch::factory()->active()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    $student = User::factory()->create();
    $student->assignRole('Free Member');

    // First enrollment
    BatchEnrollment::create([
        'batch_id' => $batch->id,
        'user_id' => $student->id,
        'added_by' => $admin->id,
        'enrolled_at' => now(),
    ]);

    // Second enrollment of same user in same batch via Livewire (should flash error, not throw)
    Livewire::actingAs($admin)
        ->test(AdminBatchesShow::class, ['id' => $batch->id])
        ->call('addStudent', $student->id)
        ->assertHasNoErrors();

    // DB constraint ensures only one record exists
    expect(
        BatchEnrollment::where('batch_id', $batch->id)->where('user_id', $student->id)->count()
    )->toBe(1);
});

test('Admin creating a batch auto-enables restricted_to_batches on the course', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'restricted_to_batches' => false,
        'created_by' => $admin->id,
    ]);

    Livewire::actingAs($admin)
        ->test(AdminBatchesIndex::class)
        ->set('name', 'Technical Analysis — Batch 1')
        ->set('courseId', $course->id)
        ->set('status', 'upcoming')
        ->call('createBatch')
        ->assertHasNoErrors();

    expect($course->fresh()->restricted_to_batches)->toBeTrue();
    expect(Batch::where('course_id', $course->id)->count())->toBe(1);
});

test('removing a student from a batch revokes their access to the batch-restricted course', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $course = Course::factory()->create([
        'tier' => ContentTier::PAID,
        'restricted_to_batches' => true,
        'created_by' => $admin->id,
    ]);
    $chapter = CourseChapter::factory()->create(['course_id' => $course->id, 'order' => 1]);

    $student = User::factory()->create();
    $student->assignRole('Free Member');

    $batch = Batch::factory()->active()->create([
        'course_id' => $course->id,
        'created_by' => $admin->id,
    ]);

    BatchEnrollment::create([
        'batch_id' => $batch->id,
        'user_id' => $student->id,
        'added_by' => $admin->id,
        'enrolled_at' => now(),
    ]);

    // Confirm can access
    expect($student->fresh()->hasActiveBatchAccessTo($course->id))->toBeTrue();

    // Remove from batch
    Livewire::actingAs($admin)
        ->test(AdminBatchesShow::class, ['id' => $batch->id])
        ->call('confirmRemove', $student->id)
        ->call('removeStudent');

    // Access is now revoked
    expect($student->fresh()->hasActiveBatchAccessTo($course->id))->toBeFalse();
});

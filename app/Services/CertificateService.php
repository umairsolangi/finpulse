<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\User;

class CertificateService
{
    public function issueIfEligible(User $user, Course $course): ?Certificate
    {
        return $this->checkAndIssueCertificate($user, $course);
    }

    public function checkAndIssueCertificate(User $user, Course $course): ?Certificate
    {
        $chapters = $course->chapters()->with('quiz')->get();
        if ($chapters->isEmpty()) {
            return null;
        }

        $completedChapterIds = CourseProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereNotNull('completed_at')
            ->pluck('chapter_id')
            ->all();

        foreach ($chapters as $chapter) {
            if (! in_array($chapter->id, $completedChapterIds)) {
                return null;
            }

            if ($chapter->quiz) {
                $hasPassedQuiz = $chapter->quiz->attempts()
                    ->where('user_id', $user->id)
                    ->where('passed', true)
                    ->exists();

                if (! $hasPassedQuiz) {
                    return null;
                }
            }
        }

        return Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'issued_at' => now(),
                'certificate_number' => Certificate::generateCertificateNumber(),
            ]
        );
    }
}

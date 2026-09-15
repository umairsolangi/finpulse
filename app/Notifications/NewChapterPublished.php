<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChapterPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Course $course,
        public CourseChapter $chapter
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('courses.chapter', [
            'slug' => $this->course->slug,
            'chapterId' => $this->chapter->id,
        ]);

        return (new MailMessage)
            ->subject('New Chapter Added: '.$this->chapter->title)
            ->greeting('Hello '.($notifiable->name ?? 'Learner').'!')
            ->line('A new chapter has just been published in your enrolled course: **'.$this->course->title.'**.')
            ->line('Chapter: '.$this->chapter->title)
            ->action('Start Learning', $url)
            ->line('Keep up your momentum and progress towards your certification!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'chapter_id' => $this->chapter->id,
            'chapter_title' => $this->chapter->title,
            'url' => route('courses.chapter', [
                'slug' => $this->course->slug,
                'chapterId' => $this->chapter->id,
            ]),
            'message' => 'New chapter "'.$this->chapter->title.'" added to '.$this->course->title,
            'type' => 'new_chapter',
        ];
    }
}

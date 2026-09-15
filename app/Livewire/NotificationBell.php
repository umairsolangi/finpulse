<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    public function toggleDropdown(): void
    {
        $this->open = ! $this->open;
    }

    public function closeDropdown(): void
    {
        $this->open = false;
    }

    public function markAsRead(string $notificationId): mixed
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        $notification = $user->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $url = $notification->data['url'] ?? null;
            if ($url) {
                return redirect()->to($url);
            }
        }

        return null;
    }

    public function markAllAsRead(): void
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }

    public function render()
    {
        $user = Auth::user();
        $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
        $recentNotifications = $user ? $user->notifications()->latest()->take(5)->get() : collect();

        return view('livewire.notification-bell', [
            'unreadCount' => $unreadCount,
            'notifications' => $recentNotifications,
        ]);
    }
}

<?php

namespace App\View\Components;

use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderBar extends Component
{
    public $unreadCount;
    public $notifications;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Fetch the unread notifications ordered by created_at descending
        $this->notifications = Notification::where('status', 'unread')
            ->orderBy('created_at', 'desc') // Order by created_at
            ->limit(5) // Limit to 5 notifications
            ->get();

        $this->unreadCount = $this->notifications->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-bar', [
            'unreadCount' => $this->unreadCount,
            'notifications' => $this->notifications,
        ]);
    }
}

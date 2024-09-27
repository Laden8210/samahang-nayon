<?php

namespace App\View\Components;

use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderBar extends Component
{
    /**
     * Create a new component instance.
     */

     public $unreadCount;
     public $notifications;
    public function __construct()
    {
        $this->notifications = Notification::where('status', 'unread')->get();
        $this->unreadCount = $this->notifications->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-bar');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Hostel;
use Auth;
use Livewire\Component;

class Notify extends Component
{
    public ?array $notifications = [];

    public function mount(): void
    {
        $this->getNotifications();
    }

    public function accept(int $hostel_id, int $user_id): void
    {
        $hostel = Hostel::find($hostel_id);
        $hostel->subscribers()->updateExistingPivot($user_id, ['active' => true]);
        $this->notifications = [];
        $this->getNotifications();
    }

    public function getNotifications(): void
    {
        $hostels = Hostel::where('owner_id', Auth::id())->get();
        foreach ($hostels as $hostel) {
            $this->notifications = array_merge($this->notifications, $hostel->subscribers()->get()->toArray());
        }
    }

    public function render()
    {
        return view(
            'livewire.notify',
            [
                'notifications' => $this->notifications,
            ]
        );
    }
}

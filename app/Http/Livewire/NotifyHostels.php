<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Hostel;
use Auth;
use Livewire\Component;

class NotifyHostels extends Component
{
    public int $hostelId = 0;
    public Hostel $hostel;
    public array $notifications = [];

    public function mount(): void
    {
        $this->hostelId = Auth::user()->hostels->first()->id;
        $this->hostel = Hostel::find($this->hostelId);
        $this->notifications = $this->hostel->subscribers()->get()->toArray();
    }

    public function changeHostel(): void
    {
        $this->hostel = Hostel::find($this->hostelId);
        $this->notifications = $this->hostel->subscribers()->get()->toArray();
    }

    public function accept(int $hostel_id, int $user_id): void
    {
        $hostel = Hostel::find($hostel_id);
        $hostel->subscribers()->updateExistingPivot($user_id, ['active' => true]);
        $this->notifications = $this->hostel->subscribers()->get()->toArray();
    }

    public function render()
    {
        $hostels = Auth::user()->hostels;
        // count notifications of each hostel
        $countNotifications = [];
        foreach ($hostels as $hostel) {
            $countNotifications[$hostel->id] = $hostel->subscribers()->where('active', false)->count();
        }

        return view('livewire.notify-hostels', ['hostels' => $hostels, 'countNotifications' => $countNotifications]);
    }
}

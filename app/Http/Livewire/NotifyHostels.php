<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Hostel;
use Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class NotifyHostels extends Component
{
    use WithPagination;
    public int $hostelId = 0;
    public Hostel $hostel;
    public array $notifications = [];

    public function mount(): void
    {
        $this->hostelId = Auth::user()->hostels->first()->id;
        $this->hostel = Hostel::find($this->hostelId);
    }

    public function changeHostel(): void
    {
        $this->hostel = Hostel::find($this->hostelId);
    }

    public function accept(int $hostel_id, int $user_id): void
    {
        $hostel = Hostel::find($hostel_id);
        $hostel->subscribers()->updateExistingPivot($user_id, ['active' => true]);
    }

    public function render(): View
    {
        $hostels = Auth::user()->hostels;
        $countNotifications = [];
        foreach ($hostels as $hostel) {
            $countNotifications[$hostel->id] = $hostel->subscribers()->where('active', false)->count();
        }

        $notify = $this->hostel->subscribers()->paginate(10);

        return view('livewire.notify-hostels', ['hostels' => $hostels, 'countNotifications' => $countNotifications, 'notify' => $notify]);
    }
}

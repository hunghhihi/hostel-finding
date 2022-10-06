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
        if (Hostel::where('owner_id', Auth::id())->exists()) {
            $this->hostel = Hostel::where('owner_id', Auth::id())->first();
            $this->hostelId = $this->hostel->id;
        } else {
            $this->hostelId = 0;
            $this->hostel = new Hostel();
        }
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
        $hostels = Hostel::where('owner_id', Auth::id())->get();
        $countNotifications = [];
        foreach ($hostels as $hostel) {
            $countNotifications[$hostel->id] = $hostel->subscribers()->wherePivot('active', false)->count();
        }
        $notify = $this->hostel->subscribers()->paginate(10);
        $this->notifications = $notify->toArray()['data'];

        return view('livewire.notify-hostels', [
            'hostels' => $hostels,
            'countNotifications' => $countNotifications,
            'notify' => $notify,
        ]);
    }
}

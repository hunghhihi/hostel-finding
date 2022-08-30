<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class UserHostelVisits extends Component
{
    public User $user;
    public int $selectedDays = 7;
    public int $visitCount = 0;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->selectedDays = 7;
        $this->updateStat();
    }

    public function updateStat(): void
    {
        $this->visitCount = 0;
        $hostels = Hostel::where('owner_id', $this->user->id)->get();
        foreach ($hostels as $hostel) {
            $this->visitCount += $hostel->visitLogs()->where('created_at', '>=', now()->subDays($this->selectedDays))->count();
        }
    }

    public function render(): View
    {
        return view('livewire.stats.user-hostel-visits');
    }
}

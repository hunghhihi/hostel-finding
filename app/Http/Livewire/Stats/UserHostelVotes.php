<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Models\User;
use App\Models\Vote;
use Illuminate\View\View;
use Livewire\Component;

class UserHostelVotes extends Component
{
    public User $user;
    public int $selectedDays = 7;
    public int $voteCount = 0;
    public float $voteScoreAvg = 0;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->selectedDays = 7;
        $this->updateStat();
    }

    public function updateStat(): void
    {
        // vote count of hostel in last 30 days
        $this->voteCount = (int) Vote::whereIn('hostel_id', $this->user->hostels->pluck('id'))
            ->where('created_at', '>=', now()->subDays($this->selectedDays))
            ->count()
        ;
        // vote score of hostel in last 30 days
        $this->voteScoreAvg = (float) Vote::whereIn('hostel_id', $this->user->hostels->pluck('id'))
            ->where('created_at', '>=', now()->subDays($this->selectedDays))
            ->average('score')
        ;
    }

    public function render(): View
    {
        return view('livewire.stats.user-hostel-votes');
    }
}

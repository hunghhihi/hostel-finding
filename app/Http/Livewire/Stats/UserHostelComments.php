<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Models\Comment;
use Auth;
use Illuminate\View\View;
use Livewire\Component;

class UserHostelComments extends Component
{
    public int $selectedDays = 7;
    public int $commentCount = 0;

    public function mount(): void
    {
        $this->selectedDays = 7;
        $this->updateStat();
    }

    public function updateStat(): void
    {
        $this->commentCount = Comment::whereIn('hostel_id', Auth::user()->hostels->pluck('id'))
            ->where('created_at', '>=', now()->subDays($this->selectedDays))
            ->count()
        ;
    }

    public function render(): View
    {
        return view('livewire.stats.user-hostel-comments');
    }
}

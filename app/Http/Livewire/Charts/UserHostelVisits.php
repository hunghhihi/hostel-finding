<?php

declare(strict_types=1);

namespace App\Http\Livewire\Charts;

use App\Models\Hostel;
use App\Models\User;
use App\Models\Visit;
use Auth;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Livewire\Component;

class UserHostelVisits extends Component
{
    public int $selectedDays = 30;
    public array $labels;
    public array $data;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        $hostels = Hostel::where('owner_id', Auth::user()->id)->get();
        $trend = Trend::query(
            Visit::whereIn('visitable_id', $hostels->pluck('id'))
                ->where('visitable_type', (new Hostel())->getMorphClass())
        )
            ->between(now()->subDays($this->selectedDays), now())
            ->perDay()
            ->count()
        ;
        $this->labels = $trend->map(function ($i) {
            $date = new Carbon($i->date);

            return $date->format('d/m');
        })->toArray();
        $this->data = $trend->map->aggregate->toArray();

        return view('livewire.charts.user-hostel-visits');
    }
}

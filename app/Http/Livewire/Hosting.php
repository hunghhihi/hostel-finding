<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Hosting extends Component
{
    use WithFileUploads;

    public string $title = '';
    public ?string $description = null;
    public $photos = [];
    public int $size = 0;
    public int $price = 0;
    public array $categoriesList = [];
    public array $amenitiesList = [];

    public function createHostel(): void
    {
        $hostel = Hostel::create([
            'title' => $this->title,
            'description' => $this->description,
            'size' => $this->size,
            'monthly_price' => $this->price,
            'address' => '',
            'latitude' => 11.11111111111113,
            'longitude' => 11.11111111111113,
            'owner_id' => auth()->id(),
        ]);
        $this->categoriesList = array_filter($this->categoriesList);
        $this->amenitiesList = array_filter($this->amenitiesList);
        $hostel->categories()->sync($this->categoriesList);
        $hostel->amenities()->sync($this->amenitiesList);
        foreach ($this->photos as $photo) {
            $hostel->addMedia($photo)->toMediaCollection();
        }
        $this->photos = [];
        $this->title = '';
        $this->description = '';
        $this->size = 0;
        $this->monthly_price = 0;
        $this->categoriesList = [];
        $this->amenitiesList = [];
    }

    public function render()
    {
        $categories = Category::all();
        $amenities = Amenity::all();

        return view('livewire.hosting', [
            'categories' => $categories,
            'amenities' => $amenities,
        ]);
    }
}

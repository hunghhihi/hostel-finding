<x-app-layout>
    @can('update', [App\Models\Hostel::class, $hostel])
        <livewire:edit :hostel="$hostel" />
    @endcan
</x-app-layout>

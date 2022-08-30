<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Thống kê
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-6 grid grid-cols-1 place-content-center gap-10 lg:grid-cols-3">
                <livewire:stats.user-hostel-votes />
                <livewire:stats.user-hostel-comments />
                <livewire:stats.user-hostel-visits />
            </div>
        </div>
    </div>
    <div>
    </div>
</x-app-layout>

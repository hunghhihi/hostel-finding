<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Thống kê
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
            <div>
                Đánh giá và thống kê các nhà trọ của bạn
            </div>
            <div class="mt-6 grid grid-cols-1 place-content-center gap-10 lg:grid-cols-3">
                <livewire:stats.user-hostel-votes :user="Auth::user()" />
                <livewire:stats.user-hostel-comments :user="Auth::user()" />
                <livewire:stats.user-hostel-visits :user="Auth::user()" />
            </div>

            <livewire:charts.user-hostel-visits :user="Auth::user()" />
        </div>

    </div>
    <div>
    </div>
</x-app-layout>

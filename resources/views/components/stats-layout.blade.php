@props(['name', 'stat'])

<div class="rounded-lg bg-white px-4 py-6 shadow-md">
    <div class="flex items-center justify-between">
        <h4 class="font-medium text-gray-500">{{ $name }}</h4>
        <select name="selectedDays" id="selectedDays" class="border bg-gray-100" wire:model="selectedDays"
            wire:change="updateStat">
            <option value="30">30 ngày</option>
            <option value="60">60 ngày</option>
            <option value="90">90 ngày</option>
        </select>
    </div>
    <div class="mt-4 text-3xl font-bold">{{ $stat }}</div>
</div>

<div class="rounded-lg bg-white px-4 py-6 shadow-md">
    <div class="flex items-center justify-between">
        <h4 class="font-medium text-gray-500">Lượt truy cập</h4>
        <select name="selectedDays" id="selectedDays" class="rounded-lg border-none bg-gray-50 shadow-sm"
            wire:model="selectedDays" wire:change="updateStat">
            <option value="7">7 ngày</option>
            <option value="30">30 ngày</option>
            <option value="60">60 ngày</option>
        </select>
    </div>
    <div class="mt-4 text-2xl font-semibold">{{ $visitCount }} lượt truy câp</div>
</div>

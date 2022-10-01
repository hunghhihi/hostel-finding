<div>
    @if (count($notifications) > 0)
        <ul class="divide-y divide-solid divide-gray-200 rounded-md border border-gray-200 shadow-sm">
            @foreach ($notifications as $item)
                @if ($item['pivot']['active'] == 0)
                    <li class="font-extrabold">
                        <div class="py-2">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <img class="h-10 w-10 rounded-full" src="{{ $item['profile_photo_url'] }}"
                                        alt="avatar">
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm text-gray-900">{{ $item['name'] }} muốn thuê nhà của
                                        bạn!
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">Liên hệ: {{ $item['phone_number'] }}</p>
                                </div>
                                <div>
                                    <button
                                        wire:click="accept({{ $item['pivot']['hostel_id'] }},{{ $item['pivot']['user_id'] }})"
                                        class="w-5">
                                        <x-polaris-major-mobile-accept />
                                    </button>
                                </div>
                            </div>
                        </div>

                    </li>
                @else
                    <li class="font-thin">
                        <div class="py-2">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <img class="h-10 w-10 rounded-full" src="{{ $item['profile_photo_url'] }}"
                                        alt="avatar">
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $item['name'] }} muốn thuê nhà của
                                        bạn!
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">Liên hệ: {{ $item['phone_number'] }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <div class="pt-5 text-center">
            <p class="text-gray-500">Không có thông báo nào</p>
        </div>
    @endif
</div>

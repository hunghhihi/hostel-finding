<div class="sm:py-10 lg:py-12">
    <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
        <select
            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            wire:model="hostelId"
            wire:change="changeHostel"
        >
            <option value="0">Chọn</option>
            @foreach ($hostels as $hostel)
                <option value="{{ $hostel->id }}">{{ $hostel->title }}
                    @if ($countNotifications[$hostel->id] > 0)
                        Đang có {{ $countNotifications[$hostel->id] }} tin chưa xem!
                    @endif
                </option>
            @endforeach
        </select>
        <div class="overflow-hidden bg-white shadow sm:rounded-md">
            @if (count($notifications) > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($notifications as $item)
                        @if ($item['pivot']['active'] == 0)
                            <li class="px-4 py-4 font-black sm:px-6">
                                <div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 pt-0.5">
                                            <img
                                                class="h-10 w-10 rounded-full"
                                                src="{{ $item['profile_photo_url'] }}"
                                                alt="avatar"
                                            >
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm text-gray-900">{{ $item['name'] }} muốn thuê nhà của bạn!
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">Liên hệ: {{ $item['phone_number'] }}
                                            </p>
                                        </div>
                                        <div>
                                            <button
                                                wire:click="accept({{ $item['pivot']['hostel_id'] }},{{ $item['pivot']['user_id'] }})"
                                                class="w-5"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full bg-blue-100 p-1.5 text-sm font-semibold text-blue-800 dark:bg-blue-200 dark:text-blue-800"
                                                >
                                                    <svg
                                                        aria-hidden="true"
                                                        class="h-3.5 w-3.5"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"
                                                        ></path>
                                                    </svg>
                                                    <span class="sr-only">Icon description</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="px-4 py-4 font-thin sm:px-6">
                                <div>
                                    <div class="flex">
                                        <div class="flex-shrink-0 pt-0.5">
                                            <img
                                                class="h-10 w-10 rounded-full"
                                                src="{{ $item['profile_photo_url'] }}"
                                                alt="avatar"
                                            >
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }} muốn thuê
                                                nhà
                                                của
                                                bạn!
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">Liên hệ: {{ $item['phone_number'] }}
                                            </p>
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
        @if (count($notifications) > 0)
            <div class="flex justify-center">
                {{ $notify->links() }}
            </div>
        @endif
    </div>
</div>

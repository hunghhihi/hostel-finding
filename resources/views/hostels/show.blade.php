<x-guest-layout>
    <div class="px-12">
        <div>
            Header
            <hr>
        </div>
        {{-- Title --}}
        <div class="flex-col items-center">
            <div>
                <h1 class="text-9xl font-bold">{{ $hostel->title }}</h1>
            </div>
            <div class="flex items-center">
                <div class="flex items-center font-bold">
                    {{ round($hostel->votes_avg_score * 5, 2) }}
                    <x-heroicon-s-star class="inline-block h-4" />
                    <x-bi-dot />
                    {{ $hostel->votes_count }} reviews
                </div>

                <div class="pl-9">
                    <div class="text-sm leading-5 text-gray-500">
                        <a href="#">{{ $hostel->address }}</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- media --}}
        <div
            class="relative my-6 grid h-96 grid-cols-1 grid-rows-1 gap-2 overflow-hidden rounded-md shadow-sm md:grid-cols-2 md:rounded-2xl">
            <div class="h-full bg-cover bg-center">
                {{ $hostel->getFirstMedia() }}
            </div>
            <div class="hidden h-full grid-cols-2 grid-rows-2 gap-2 md:grid">
                @foreach ($hostel->getMedia() as $index => $item)
                    @if ($index > 0 && $index < 5)
                        <div class="relative overflow-hidden bg-cover bg-center">
                            {{ $item }}
                        </div>
                    @endif
                    @if ($index == 4)
                        <div x-data="{ open: false }"
                            class="text-gray-500focus:outline-none absolute right-0 bottom-0 mb-2 mr-2 rounded-md bg-white">
                            <button x-ref="modal1_button" @click="open = true"
                                class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out">
                                <span>Show More</span>
                            </button>
                            <div x-cloak role="dialog" aria-labelledby="modal1_label" aria-modal="true" tabindex="0"
                                x-show="open" @click="open = false; $refs.modal1_button.focus()"
                                @click.away="open = false; $refs.modal1_button.focus()"
                                class="fixed top-0 left-0 flex h-screen w-full flex-col items-center justify-center overflow-auto">
                                @foreach ($hostel->getMedia() as $item)
                                    <div class="relative bg-center py-1">
                                        {{ $item }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- info --}}
        <div class="mt-7 flex">
            <div class="basis-3/4">
                {{-- owner --}}
                <div>
                    <span class="font-bold">
                        Chủ nhà : {{ $hostel->owner->name }}
                    </span>
                </div>
                {{-- categories --}}
                <div class="py-5">
                    @foreach ($hostel->categories as $category)
                        <div
                            class="leading-sm inline-flex items-center rounded-full bg-blue-200 px-3 py-1 text-xs font-bold uppercase text-blue-700">
                            <x-heroicon-o-tag />
                            {{ $category->name }}
                        </div>
                    @endforeach
                </div>
                {{-- amenities --}}
                <div>
                    <div>
                        Nơi này có những gì cho bạn
                    </div>
                    <div class="">
                        @foreach ($hostel->amenities as $amenity)
                            <div
                                class="leading-sm max-w-min inline-flex max-h-min items-center rounded-full bg-yellow-300 px-3 py-1 text-xs font-bold uppercase text-blue-700">
                                <x-heroicon-o-tag />
                                {{ $amenity->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- price --}}
            <div>
                <div class="mb-6 h-96 w-96 rounded-lg bg-white pt-3 shadow-lg shadow-black">
                    <div class="mx-9 text-xl font-bold">
                        Giá hàng tháng : {{ number_format($hostel->monthly_price, 0, '', '.') }} vnđ
                    </div>
                    <div class="my-5 mx-9">
                        <div>
                            Một số thông tin về nhà :
                        </div>
                        <div class="">
                            <div x-data="{ length: 600, more: false }" x-init="originalContent = $el.firstElementChild.textContent.trim()">
                                <span x-text="originalContent.slice(0, length)"
                                    class="leading-5 text-gray-500">{{ $hostel->description }}</span>
                                <div>
                                    <button x-show="!more" @click="more = true"
                                        x-text="originalContent.length > length ? 'Xem thêm' : ''"
                                        class="inline-block items-center justify-center px-3 py-1 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out">
                                    </button>
                                    <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                                        x-show="more" x-cloak>
                                        <!-- Modal inner -->
                                        <div class="max-w-3xl mx-auto rounded-lg bg-white px-6 py-4 text-left shadow-lg"
                                            @click.away="more = false"
                                            x-transition:enter="motion-safe:ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100">
                                            <!-- Title / Close-->
                                            <div class="flex items-center justify-between">
                                                <h5 class="max-w-none mr-3 text-lg font-bold text-black">Description
                                                </h5>
                                            </div>
                                            <!-- content -->
                                            <div x-text="originalContent" class="w-96">
                                            </div>
                                            <button
                                                class="modal-close my-7 rounded-lg bg-indigo-500 py-3 px-4 text-white hover:bg-indigo-400"
                                                @click="more = false">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div>
            @livewire('comment', ['hostel' => $hostel])
        </div>
        {{-- map --}}
    </div>

</x-guest-layout>

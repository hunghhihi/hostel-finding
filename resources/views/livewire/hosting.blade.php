<form wire:submit.prevent="createHostel" class="space-y-8 divide-y divide-gray-200 px-20">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div>
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Become a host</h3>
                <p class="max-w-2xl mt-1 text-sm text-gray-500">Chào mừng {{ Auth::user()->name }} trở lại</p>
            </div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Tiêu đề
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="max-w-lg flex rounded-md shadow-sm">
                            <input wire:model.defer='title' type="text" name="title" id="title"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div wire:ignore
                    class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Mô tả
                    </label>
                    <div wire:model.defer='description' class="mt-1 sm:col-span-2 sm:mt-0">
                        {{-- not receive description TODO --}}
                        <x-easy-mde name="about">
                        </x-easy-mde>
                    </div>
                </div>

                <div class="min sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Ảnh
                    </label>
                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <!-- File Input -->
                        <input type="file" wire:model.defer="photos" multiple>

                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>

                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Kích thước
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="max-w-lg flex rounded-md shadow-sm">
                            <input type="number" wire:model.defer='size' name="size""
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Giá
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="max-w-lg flex rounded-md shadow-sm">
                            <input type="number" wire:model.defer='price' name="price"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-y-6 divide-y divide-gray-200 pt-8 sm:space-y-5 sm:pt-10">
        <div class="space-y-6 divide-y divide-gray-200 sm:space-y-5">
            <div class="pt-6 sm:pt-5">
                <div role="group" aria-labelledby="label-email">
                    <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4">
                        <div>
                            <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                id="label-email">Các danh mục</div>
                        </div>
                        <div class="mt-4 sm:col-span-2 sm:mt-0">
                            <div class="max-w-lg space-y-4">
                                @foreach ($categories as $category)
                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="comments" name="comments" type="checkbox"
                                                value="{{ $category->id }}"
                                                wire:model.defer='categoriesList.{{ $category->id }}'
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="comments"
                                                class="font-medium text-gray-700">{{ $category->name }}</label>
                                            <p class="text-gray-500">{{ $category->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-6 sm:pt-5">
                <div role="group" aria-labelledby="label-notifications">
                    <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4">
                        <div>
                            <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                id="label-notifications">Các tiện nghi</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="max-w-lg">
                                <div class="mt-4 space-y-4">
                                    @foreach ($amenities as $amenity)
                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input id="comments" name="comments" type="checkbox"
                                                    value="{{ $amenity->id }}"
                                                    wire:model.defer='amenitiesList.{{ $amenity->id }}'
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments"
                                                    class="font-medium text-gray-700">{{ $amenity->name }}</label>
                                                <p class="text-gray-500">{{ $amenity->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        <div class="flex justify-end">
            <button type="button"
                class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
            <button wire:loading.attr='disabled' type="submit"
                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-gray-500">Save</button>
        </div>
    </div>
</form>

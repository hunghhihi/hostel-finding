<div class="pt-10">
    <div class="text-3xl">
        Bình luận
    </div>
    {{-- star --}}
    <div class="flex items-center font-bold">
        {{ round($hostel->votes_avg_score * 5, 2) }}
        <x-heroicon-s-star class="inline-block h-4" />
        <x-bi-dot />
        <div class="my-4 inline-block text-base leading-6 text-gray-900">
            {{ $hostel->votes_count }} đánh giá
        </div>
        <x-bi-dot />
        {{ $hostel->comments_count }} comments
    </div>
    @auth
        @can('create', [App\Models\Vote::class, $hostel])
            <div>
                <div x-data="{
                    rating: 0,
                    hoverRating: 0,
                    ratings: [{ 'amount': 1, 'label': 'Terrible' }, { 'amount': 2, 'label': 'Bad' }, { 'amount': 3, 'label': 'Okay' }, { 'amount': 4, 'label': 'Good' }, { 'amount': 5, 'label': 'Great' }],
                    rate(amount) {
                        if (this.rating == amount) {
                            this.rating = 0;
                        } else this.rating = amount;
                    },
                    currentLabel() {
                        let r = this.rating;
                        if (this.hoverRating != this.rating) r = this.hoverRating;
                        let i = this.ratings.findIndex(e => e.amount == r);
                        if (i >= 0) { return this.ratings[i].label; } else { return '' };
                    },
                    currentRate() {
                        let r = this.rating;
                        if (this.hoverRating != this.rating) r = this.hoverRating;
                        let i = this.ratings.findIndex(e => e.amount == r);
                        if (i >= 0) { return this.ratings[i].amount; } else { return '' };
                    }
                }" class="flex h-36 w-72 flex-col items-center space-y-2 rounded">
                    <div class="flex space-x-0 bg-gray-100">
                        <template x-for="(star, index) in ratings" :key="index">
                            <button @click="rate(star.amount)" @mouseover="hoverRating = star.amount"
                                @mouseleave="hoverRating = rating" aria-hidden="true" :title="star.label"
                                class="focus:shadow-outline m-0 w-12 cursor-pointer rounded-sm fill-current p-1 text-gray-400 focus:outline-none"
                                :class="{
                                    'text-gray-600': hoverRating >= star.amount,
                                    'text-yellow-400': rating >= star
                                        .amount && hoverRating >= star.amount
                                }">
                                <svg class="w-15 transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>

                        </template>
                    </div>
                    <div class="p-2">
                        <template x-if="rating || hoverRating">
                            <p x-text="currentLabel()"></p>
                        </template>
                        <template x-if="!rating && !hoverRating">
                            <p>Please Rate!</p>
                        </template>
                        <template x-if="rating">
                            <button x-on:click="$wire.createVote(currentRate())"
                                class="focus:shadow-outline rounded bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700 focus:outline-none">
                                Gửi đánh giá
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        @else
            <div class="pb-5 text-sm font-semibold text-success-500">
                Bạn đã đánh giá bài viết này với {{ $hostel->votes->where('owner_id', auth()->id())->first()->score * 5 }}
                <x-heroicon-s-star class="inline-block h-5" />
            </div>
        @endcan

        {{-- comment --}}
        @if ($comments->count() > 0)
            <div class="grid grid-cols-2">
                @foreach ($comments as $index => $comment)
                    @if ($comment->parent_id == null)
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <x-avatar :search="$comment->owner->email" :src="$comment->owner->profile_photo_url" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium leading-5 text-gray-900">
                                        {{ $comment->owner->name }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div x-data="{ reply: false }" class="my-4 ml-4 pl-9 text-base leading-6 text-gray-900">
                                <div class="w-96">
                                    {{ $comment->content }}
                                </div>
                                <button @click="reply = !reply" class="text-sm leading-5 text-gray-500">
                                    Phản hồi
                                </button>
                                <div x-show="reply">
                                    <div class="mt-1">
                                        <form wire:submit.prevent="replyComment({{ $comment->id }})" class="flex">
                                            @csrf
                                            <input type="text" name="reply" id="reply" wire:model.defer="reply"
                                                class="block w-full rounded-full border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                placeholder="Write a reply...">
                                            <button type="submit"
                                                class="focus:shadow-outline-indigo active:shadow-outline-indigo flex-shrink-0 rounded-full border-indigo-500 bg-indigo-500 px-4 py-2 text-sm font-medium leading-5 text-white hover:border-indigo-400 hover:bg-indigo-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 active:border-indigo-700 active:bg-indigo-600">
                                                <x-uiw-loading wire:loading class="h-5 w-5 animate-spin" />
                                                Gửi phản hồi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-12">
                                @if ($comment->children->count() > 0)
                                    @foreach ($comment->children as $child)
                                        <div class="my-4 ml-4 pl-9 text-base leading-6 text-gray-900">
                                            <div class="font-bold">
                                                Reply to {{ $child->owner->name }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500">
                                                {{ $child->created_at->diffForHumans() }}
                                            </div>
                                            <div class="overflow-hidden pl-5">
                                                {{ $child->content }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div>
                {{ $comments->links() }}
            </div>
        @endif
        <div class="mt-1">
            <form wire:submit.prevent="createComment" class="flex">
                @csrf
                <input type="text" name="comment" id="comment" wire:model.defer="comment"
                    class="block w-1/2 rounded-xl border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Write a comment...">
                <button type="submit"
                    class="focus:shadow-outline-indigo active:shadow-outline-indigo flex-shrink-0 rounded-full border-indigo-500 bg-indigo-500 px-4 py-2 text-sm font-medium leading-5 text-white hover:border-indigo-400 hover:bg-indigo-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 active:border-indigo-700 active:bg-indigo-600">
                    <x-uiw-loading wire:loading class="h-5 w-5 animate-spin" />
                    Gửi bình luận
                </button>
            </form>
        </div>
    @else
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-indigo-500 hover:text-indigo-700">
                Đăng nhập để bình luận
            </a>
        </div>
    @endauth
    {{-- end comment --}}
</div>

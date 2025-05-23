<div class=" w-full ">
    <div class="border-r-2 border-black h-[8rem]  absolute">
        <div class="h-2 w-2 rounded-full bg-black absolute -left-1"></div>
    </div>
    <div class="ml-2 flex gap-4">
        <div>

            <div class="h-10 ml-2 w-10 rounded-full bg-white"></div>
        </div>
        <div>
            <h2 class="text-sm text-ourblue font-bold">{{ $review->user->username }}</h2>
            <div class="flex gap-2  items-center">
                <img src="{{ asset('storage/' . $review->buku->cover) }}" alt="{{ $review->buku->judul }}"
                    class="max-w-full h-14 object-cover mt-2 rounded-lg">
                <span class="text-xs">{{ $review->review }}</span>
            </div>
        </div>
    </div>
</div>
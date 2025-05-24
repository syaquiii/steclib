<div class="group relative hover:scale-110  transition-transform duration-300 hover:rotate-3 ">
    <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}"
        class="w-full aspect-[2/3] object-cover rounded-md mb-2">

    <h3 class="font-bold text-ourblue text-sm truncate group-hover:text-blue-500 transition-colors duration-300">
        {{ $buku->judul }}
    </h3>

    <!-- Efek glow dengan pseudo-element -->
    <div class="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity duration-300 rounded-md">
    </div>
</div>
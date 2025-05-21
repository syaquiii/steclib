<div class="flex gap-10">
    <div class="w-1/4">
        <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" alt="{{ $peminjaman->buku->judul }}"
            class="w-full h-full object-cover rounded-md mb-2 shadow-md">
    </div>
    <div class="w-2/4">
        <h4 class="font-fraunces text-ourblue font-bold mb-2 text-xl">{{ $peminjaman->buku->judul }}</h4>
        <p class="text-xs font-fraunces text-brown-custom mb-4">{{ $peminjaman->buku->tagline }}</p>

        <div class="text-sm text-gray-600 mb-4 font-fraunces">
            <p><strong>Tanggal Pinjam:</strong>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
            <p><strong>Wajib Kembali:</strong>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_wajib_kembali)->format('d M Y') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('books.show', $peminjaman->isbn) }}">
                <button
                    class="flex items-center gap-2 bg-ourblue text-white px-4 py-2 rounded-lg hover:scale-105 hover:bg-blue-950 transition-all shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 20h9M12 4h9M4 4h.01M4 20h.01M4 12h16" />
                    </svg>
                    Beri Review
                </button>
            </a>

            <form action="{{ route('peminjaman.return', $peminjaman->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menyelesaikan bacaan ini?')">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:scale-105 hover:bg-green-800 transition-all shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Selesai Baca
                </button>
            </form>
        </div>
    </div>
</div>
<footer class="w-full bg-[#635147] text-[#F6F4F1] py-10">
  <div class="w-11/12 md:w-5/6 mx-auto flex gap-8">

    <!-- Brand dan Deskripsi -->
    <div class="w-3/5 pr-4  font-fraunces">
      <h1 class="text-4xl font-bold text-[#F6F4F1] mb-4">Steclib.</h1>
      <p class="text-sm">
        StecLib is your go-to place for exploring a wide collection of novels—from timeless classics to today's bestsellers. Discover, read, and enjoy stories that inspire.
      </p>
    </div>

    <!-- Kontak -->
    <div class="text-right  font-fraunces">
      <h2 class="text-xl font-bold mb-2">Contact Us</h2>
      <p class="mb-1 text-sm">
        <i class="fa-solid fa-phone mr-2"></i> +62 xxx-xxxx-xxxx
      </p>
      <p class="mb-1 text-sm">
        <i class="fa-solid fa-envelope mr-2"></i> steculibrary@gmail.com
      </p>
    </div>

    <!-- Navigasi -->
    <div class="flex flex-col gap-2 font-bold">
        <a href="{{ route('page.home') }}" class="hover:text-white transition-colors duration-300">HOME</a>
        <a href="{{ route('books.daftar') }}" class="hover:text-white transition-colors duration-300">DAFTAR BUKU</a>
        <a href="{{ route('peminjaman.index') }}" class="hover:text-white transition-colors duration-300">DAFTAR PINJAM</a>
        <a href="{{ route('wishlists.index') }}" class="hover:text-white transition-colors duration-300">WISHLIST</a>
    </div>

  </div>

  <!-- Copyright -->
  <div class="text-center text-sm mt-10 text-[#F6F4F1]">
    &copy; 2025 StecLib. All rights reserved.
  </div>
</footer>
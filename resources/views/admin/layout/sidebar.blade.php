<div class="h-screen w-1/5 fixed flex rounded-r-2xl shadow-2xl flex-col items-center py-16 bg-[#F6F4F1]">
    <div class="text-[#1F305E] font-fraunces italic">
        <h2 class="text-5xl font-bold">Steclib</h2>
        <span>Admin</span>
    </div>
    <ul class="mt-12 text-[#805B4E] w-full">
        <a href="{{ route('admin.dashboard') }}"
            class="{{ Request::routeIs('admin.dashboard') ? 'bg-[#1F305E] text-white' : '' }} hover:bg-[#1F305E] hover:text-white transition-all px-8 py-4 flex justify-between text-xl gap-4 items-center">
            <i class="fa-solid fa-house"></i>
            <li class="nav-item w-full">Dashboard</li>
        </a>
        <a href="{{ route('admin.penerbit.index') }}"
            class="{{ Request::routeIs('admin.penerbit.index') ? 'bg-[#1F305E] text-white' : '' }} hover:bg-[#1F305E] hover:text-white transition-all px-8 py-4 flex justify-between text-xl gap-4 items-center">
            <i class="fa-solid fa-person"></i>
            <li class="nav-item w-full">Manajemen Penerbit</li>
        </a>
        <a href="{{ route('admin.user.index') }}"
            class="{{ Request::routeIs('admin.user.index') ? 'bg-[#1F305E] text-white' : '' }} hover:bg-[#1F305E] hover:text-white transition-all px-8 py-4 flex justify-between text-xl gap-4 items-center">
            <i class="fa-solid fa-person"></i>
            <li class="nav-item w-full">Manajemen Anggota</li>
        </a>
    </ul>
    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="w-full mt-auto">
        @csrf
        <button type="submit"
            class="w-full bg-red-500 text-white hover:bg-red-600 transition-all px-32 py-4 flex justify-center text-xl gap-4 items-center">
            <i class="fa-solid fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
</div>
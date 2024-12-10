<style>
    .dropdown:focus-within .dropdown-menu {
        opacity: 1;
        transform: translate(0) scale(1);
        visibility: visible;
    }
</style>

<div class="w-full h-14 flex justify-between items-center">
    <div class="flex flex-row justify-center items-center gap-5">
        <a class="relative flex items-center justify-center h-14 w-52" href="#">
            <img src="{{ asset('img/logo/logo.png') }}" alt="logo" class="absolute w-full h-full object-cover">
        </a>
    </div>

    <div class="h-14 flex flex-row justify-center items-center gap-5 mr-4">
        {{-- profile icon --}}
        <div class=" flex flex-col justify-center">
            <div class="flex items-center justify-center">
                <div class=" relative inline-block text-left dropdown">
                    <span class="rounded-md shadow-sm"><button
                            class="inline-block rounded-full px-3.5 py-2 bg-blue-500 hover:bg-blue-600 text-sm text-white transition duration-200"
                            type="button" aria-haspopup="true" aria-expanded="true"
                            aria-controls="headlessui-menu-items-117">
                            S
                        </button></span>
                    <div
                        class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                            aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                            <div class="px-4 py-3">
                                <p class="text-sm leading-5">Signed in as</p>
                                <p class="text-sm font-medium leading-5 text-gray-900 truncate">tom@example.com</p>
                            </div>
                            <div class="py-1">
                                <a href="javascript:void(0)" tabindex="0"
                                    class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                    role="menuitem">Account settings</a>
                                <a href="javascript:void(0)" tabindex="1"
                                    class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                    role="menuitem">Support</a>
                            </div>
                            <div class="py-1">
                                <a href="javascript:void(0)" tabindex="3"
                                    class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                    role="menuitem">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Burger menu icon --}}
        <div  class="h-14 flex items-center justify-center md:hidden">
            <i id="burger" class="fa fa-bars text-green-400 text-2xl cursor-pointer"></i>
            <i id="cross" class="fa fa-times text-green-400 text-2xl cursor-pointer hidden"></i>
        </div>
    </div>

</div>

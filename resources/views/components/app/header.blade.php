<style>
    .dropdown:focus-within .dropdown-menu {
        opacity: 1;
        transform: translate(0) scale(1);
        visibility: visible;
    }
</style>
<header class="bg-white shadow fixed top-0 z-50 w-full">
    <nav class="relative px-4 py-4 flex justify-between items-center bg-white">
        <a class="relative flex items-center justify-center h-12 w-52" href="/">
            {{-- <img src="{{ asset('img/logo/logo.png') }}" alt="logo" class="absolute w-full h-full object-cover"> --}}
            <div class="text-2xl  font-bold bg-gradient-to-r from-purple-400  to-pink-400 bg-clip-text text-transparent">
                Ship Booking
            </div>
        </a>

        <ul
            class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
            <li><a href="/"
                    class="text-sm font-bold {{ request()->is('/') ? 'text-blue-600' : 'text-gray-400 hover:text-gray-500' }}">Home</a>
            </li>
            <li class="text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </li>
            <li><a href="/find-destination"
                    class="text-sm font-bold {{ request()->is('find-destination') ? 'text-blue-600' : 'text-gray-400 hover:text-gray-500' }}">Destination</a>
            </li>
            <li class="text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                    class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </li>
            <li><a href="/about"
                    class="text-sm font-bold {{ request()->is('about') ? 'text-blue-600' : 'text-gray-400 hover:text-gray-500' }}">About
                    Us</a></li>
            <li class="text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                    class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </li>
            <li><a href="/contact"
                    class="text-sm font-bold {{ request()->is('contact') ? 'text-blue-600' : 'text-gray-400 hover:text-gray-500' }}"
                    href="#">Contact</a></li>
        </ul>
        <div class="flex flex-row justify-center items-center space-x-3">
            @if (session('user_name'))
                {{-- profile icon --}}
                <div class="flex items-center justify-center">
                    <div class=" relative inline-block text-left dropdown">
                        <span class="rounded-md shadow-sm"><button
                                class="inline-block rounded-full px-3.5 py-2 bg-blue-500 hover:bg-blue-600 text-sm text-white transition duration-200"
                                type="button" aria-haspopup="true" aria-expanded="true"
                                aria-controls="headlessui-menu-items-117">
                                {{ session('user_name') }}
                            </button></span>
                        <div
                            class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                            <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117"
                                role="menu">
                                <div class="py-1">
                                    @if (session('user_role') == 'admin')
                                        <a href="{{ url('/dashboard/admin') }}" tabindex="0"
                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                            role="menuitem">Dashboard</a>
                                    @elseif (session('user_role') == 'manager')
                                        <a href="{{ url('/dashboard/manager') }}" tabindex="0"
                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                            role="menuitem">Dashboard</a>
                                    @else
                                        <a href="{{ url('/dashboard/user') }}" tabindex="0"
                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                            role="menuitem">Dashboard</a>
                                    @endif
                                </div>
                                <div class="py-1">
                                    <a href="{{ url('/api/logout') }}" tabindex="3"
                                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                        role="menuitem">Log out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a class="hidden lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200"
                    href="{{ url('/login') }}">Log In</a>
            @endif
            <div class="lg:hidden">
                <button class="navbar-burger block lg:hidden flex items-center text-blue-600 p-3">
                    <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Mobile menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <div class="navbar-menu relative z-50 hidden">
        <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
        <nav
            class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
            <div class="flex items-center mb-8">
                <a href={{ url('/') }} class="relative flex items-center justify-center h-12 w-full"
                    href="#">
                    {{-- <img src="{{ asset('img/logo/logo.png') }}" alt="logo"
                        class="absolute w-full h-full object-cover"> --}}
                    <div
                        class="text-2xl  font-bold bg-gradient-to-r from-purple-400  to-pink-400 bg-clip-text text-transparent">
                        Ship Booking
                    </div>
                </a>
                <button class="navbar-close">
                    <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div>
                <ul>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded"
                            href="#">Home</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded"
                            href="#">About Us</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded"
                            href="#">Services</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded"
                            href="#">Pricing</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded"
                            href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="mt-auto">
                <div class="pt-6">
                    <a href="{{ url('/login') }}"
                        class="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl">Sign
                        in</a>
                    <a href="{{ url('/register') }}"
                        class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl">Sign
                        Up</a>
                </div>
                <p class="my-4 text-xs text-center text-gray-400">
                    <span>Copyright © 2024</span>
                </p>
            </div>
        </nav>
    </div>
</header>

<script>
    // Burger menus
    document.addEventListener('DOMContentLoaded', function() {
        // open
        const burger = document.querySelectorAll('.navbar-burger');
        const menu = document.querySelectorAll('.navbar-menu');

        if (burger.length && menu.length) {
            for (var i = 0; i < burger.length; i++) {
                burger[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        // close
        const close = document.querySelectorAll('.navbar-close');
        const backdrop = document.querySelectorAll('.navbar-backdrop');

        if (close.length) {
            for (var i = 0; i < close.length; i++) {
                close[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        if (backdrop.length) {
            for (var i = 0; i < backdrop.length; i++) {
                backdrop[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }
    });
</script>

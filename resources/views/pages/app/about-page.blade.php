@extends('layouts.app_layout')
@section('content')
    <main class="profile-page">
        <section class="relative block h-[500px]">
            <div class="absolute top-0 w-full h-full bg-center bg-cover"
                style="
                background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80');
            ">
                <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-[70px]"
                style="transform: translateZ(0px)">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                    version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </section>

        <section class="relative py-16 bg-blueGray-200">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                <div class="relative">
                                    <img alt="..." src="{{ asset('img/cruise_ship.jpg') }}"
                                        class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-[150px]">
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                                <div class="py-6 px-3 mt-32 sm:mt-0">
                                    <button
                                        class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150"
                                        type="button">
                                        Connect
                                    </button>
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">580+</span>
                                        <span class="text-sm text-blueGray-400">Employees</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">150+</span>
                                        <span class="text-sm text-blueGray-400">Routes</span>
                                    </div>
                                    <div class="lg:mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">20+</span>
                                        <span class="text-sm text-blueGray-400">Ships</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-8">
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700">
                                Ship Booking Ltd
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400"></i>
                                Dhaka, Bangladesh
                            </div>

                        </div>
                        <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                        Welcome aboard! At BD Ship Booking Ltd, we are passionate about providing an
                                        unforgettable cruising experience that takes you to some of the most beautiful
                                        destinations across the globe. Our mission is to create memories that last a
                                        lifetime by delivering exceptional service, world-class amenities, and exciting
                                        adventures on the high seas.
                                    </p>
                                    <h1 class="text-green-900 font-bold text-xl my-4">Our Story</h1>
                                    <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                        Founded with a love for travel and exploration, BD Ship Booking Ltd was established began with the vision of offering luxurious, yet affordable cruises to people who share the same love for the ocean. Over the years, we’ve grown from a small cruise operation into one of the most recognized names in the cruise industry, thanks to our commitment to excellence and customer satisfaction.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- team --}}
        <div id="team" class="section relative pt-20 pb-8 md:pt-16 bg-white dark:bg-gray-800">
            <div class="container xl:max-w-6xl mx-auto px-4">
                <!-- section header -->
                <header class="text-center mx-auto mb-12">
                    <h2 class="text-2xl leading-normal mb-2 font-bold text-gray-800 dark:text-gray-100">
                        <span class="font-light">Our</span> Team
                    </h2>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0px" y="0px" viewBox="0 0 100 60" style="margin: 0 auto;height: 35px;" xml:space="preserve">
                        <circle cx="50.1" cy="30.4" r="5" class="stroke-primary"
                            style="fill: transparent;stroke-width: 2;stroke-miterlimit: 10;"></circle>
                        <line x1="55.1" y1="30.4" x2="100" y2="30.4" class="stroke-primary"
                            style="stroke-width: 2;stroke-miterlimit: 10;"></line>
                        <line x1="45.1" y1="30.4" x2="0" y2="30.4" class="stroke-primary"
                            style="stroke-width: 2;stroke-miterlimit: 10;"></line>
                    </svg>
                </header>
                <!-- end section header -->
                <!-- row -->
                <div class="flex flex-wrap flex-row -mx-4 justify-center">
                    <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/4 xl:px-6">
                        <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 hover-grayscale-0 wow fadeInUp"
                            data-wow-duration="1s"
                            style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                            <!-- team block -->
                            <div class="relative overflow-hidden px-6">
                                <img src="https://tailone.tailwindtemplate.net/src/img/dummy/avatar1.png"
                                    class="max-w-full h-auto mx-auto rounded-full bg-gray-50 grayscale" alt="title image">
                            </div>
                            <div class="pt-6 text-center">
                                <p class="text-lg leading-normal font-bold mb-1">Joe Antonio</p>
                                <p class="text-gray-500 leading-relaxed font-light">Founder CEO</p>
                                <!-- social icon -->
                                <div class="mt-2 mb-5 space-x-2">
                                    <a class="hover:text-blue-700" aria-label="Twitter link" href="#">
                                        <!-- <i class="fab fa-twitter text-twitter"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M496,109.5a201.8,201.8,0,0,1-56.55,15.3,97.51,97.51,0,0,0,43.33-53.6,197.74,197.74,0,0,1-62.56,23.5A99.14,99.14,0,0,0,348.31,64c-54.42,0-98.46,43.4-98.46,96.9a93.21,93.21,0,0,0,2.54,22.1,280.7,280.7,0,0,1-203-101.3A95.69,95.69,0,0,0,36,130.4C36,164,53.53,193.7,80,211.1A97.5,97.5,0,0,1,35.22,199v1.2c0,47,34,86.1,79,95a100.76,100.76,0,0,1-25.94,3.4,94.38,94.38,0,0,1-18.51-1.8c12.51,38.5,48.92,66.5,92.05,67.3A199.59,199.59,0,0,1,39.5,405.6,203,203,0,0,1,16,404.2,278.68,278.68,0,0,0,166.74,448c181.36,0,280.44-147.7,280.44-275.8,0-4.2-.11-8.4-.31-12.5A198.48,198.48,0,0,0,496,109.5Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Facebook link" href="#">
                                        <!-- <i class="fab fa-facebook text-facebook"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M455.27,32H56.73A24.74,24.74,0,0,0,32,56.73V455.27A24.74,24.74,0,0,0,56.73,480H256V304H202.45V240H256V189c0-57.86,40.13-89.36,91.82-89.36,24.73,0,51.33,1.86,57.51,2.68v60.43H364.15c-28.12,0-33.48,13.3-33.48,32.9V240h67l-8.75,64H330.67V480h124.6A24.74,24.74,0,0,0,480,455.27V56.73A24.74,24.74,0,0,0,455.27,32Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Instagram link" href="#">
                                        <!-- <i class="fab fa-instagram text-instagram"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M349.33,69.33a93.62,93.62,0,0,1,93.34,93.34V349.33a93.62,93.62,0,0,1-93.34,93.34H162.67a93.62,93.62,0,0,1-93.34-93.34V162.67a93.62,93.62,0,0,1,93.34-93.34H349.33m0-37.33H162.67C90.8,32,32,90.8,32,162.67V349.33C32,421.2,90.8,480,162.67,480H349.33C421.2,480,480,421.2,480,349.33V162.67C480,90.8,421.2,32,349.33,32Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M377.33,162.67a28,28,0,1,1,28-28A27.94,27.94,0,0,1,377.33,162.67Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M256,181.33A74.67,74.67,0,1,1,181.33,256,74.75,74.75,0,0,1,256,181.33M256,144A112,112,0,1,0,368,256,112,112,0,0,0,256,144Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Linkedin link" href="#">
                                        <!-- <i class="fab fa-linkedin text-linkedin"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end team block -->
                    </div>
                    <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/4 xl:px-6">
                        <!-- team block -->
                        <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 hover-grayscale-0 wow fadeInUp"
                            data-wow-duration="1s" data-wow-delay=".1s"
                            style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
                            <div class="relative overflow-hidden px-6">
                                <img src="https://tailone.tailwindtemplate.net/src/img/dummy/avatar3.png"
                                    class="max-w-full h-auto mx-auto rounded-full bg-gray-50 grayscale" alt="title image">
                            </div>
                            <div class="pt-6 text-center">
                                <p class="text-lg leading-normal font-bold mb-1">Sarah Daeva</p>
                                <p class="text-gray-500 leading-relaxed font-light">Marketing</p>
                                <!-- social icon -->
                                <div class="mt-2 mb-5 space-x-2">
                                    <a class="hover:text-blue-700" aria-label="Twitter link" href="#">
                                        <!-- <i class="fab fa-twitter text-twitter"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M496,109.5a201.8,201.8,0,0,1-56.55,15.3,97.51,97.51,0,0,0,43.33-53.6,197.74,197.74,0,0,1-62.56,23.5A99.14,99.14,0,0,0,348.31,64c-54.42,0-98.46,43.4-98.46,96.9a93.21,93.21,0,0,0,2.54,22.1,280.7,280.7,0,0,1-203-101.3A95.69,95.69,0,0,0,36,130.4C36,164,53.53,193.7,80,211.1A97.5,97.5,0,0,1,35.22,199v1.2c0,47,34,86.1,79,95a100.76,100.76,0,0,1-25.94,3.4,94.38,94.38,0,0,1-18.51-1.8c12.51,38.5,48.92,66.5,92.05,67.3A199.59,199.59,0,0,1,39.5,405.6,203,203,0,0,1,16,404.2,278.68,278.68,0,0,0,166.74,448c181.36,0,280.44-147.7,280.44-275.8,0-4.2-.11-8.4-.31-12.5A198.48,198.48,0,0,0,496,109.5Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Facebook link" href="#">
                                        <!-- <i class="fab fa-facebook text-facebook"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M455.27,32H56.73A24.74,24.74,0,0,0,32,56.73V455.27A24.74,24.74,0,0,0,56.73,480H256V304H202.45V240H256V189c0-57.86,40.13-89.36,91.82-89.36,24.73,0,51.33,1.86,57.51,2.68v60.43H364.15c-28.12,0-33.48,13.3-33.48,32.9V240h67l-8.75,64H330.67V480h124.6A24.74,24.74,0,0,0,480,455.27V56.73A24.74,24.74,0,0,0,455.27,32Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Instagram link" href="#">
                                        <!-- <i class="fab fa-instagram text-instagram"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M349.33,69.33a93.62,93.62,0,0,1,93.34,93.34V349.33a93.62,93.62,0,0,1-93.34,93.34H162.67a93.62,93.62,0,0,1-93.34-93.34V162.67a93.62,93.62,0,0,1,93.34-93.34H349.33m0-37.33H162.67C90.8,32,32,90.8,32,162.67V349.33C32,421.2,90.8,480,162.67,480H349.33C421.2,480,480,421.2,480,349.33V162.67C480,90.8,421.2,32,349.33,32Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M377.33,162.67a28,28,0,1,1,28-28A27.94,27.94,0,0,1,377.33,162.67Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M256,181.33A74.67,74.67,0,1,1,181.33,256,74.75,74.75,0,0,1,256,181.33M256,144A112,112,0,1,0,368,256,112,112,0,0,0,256,144Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Linkedin link" href="#">
                                        <!-- <i class="fab fa-linkedin text-linkedin"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end team block -->
                    </div>
                    <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/4 xl:px-6">
                        <!-- team block -->
                        <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 hover-grayscale-0 wow fadeInUp"
                            data-wow-duration="1s" data-wow-delay=".3s"
                            style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <div class="relative overflow-hidden px-6">
                                <img src="https://tailone.tailwindtemplate.net/src/img/dummy/avatar2.png"
                                    class="max-w-full h-auto mx-auto rounded-full bg-gray-50 grayscale" alt="title image">
                            </div>
                            <div class="pt-6 text-center">
                                <p class="text-lg leading-normal font-bold mb-1">Daniel Emo</p>
                                <p class="text-gray-500 leading-relaxed font-light">Sales manager</p>
                                <!-- social icon -->
                                <div class="mt-2 mb-5 space-x-2">
                                    <a class="hover:text-blue-700" aria-label="Twitter link" href="#">
                                        <!-- <i class="fab fa-twitter text-twitter"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M496,109.5a201.8,201.8,0,0,1-56.55,15.3,97.51,97.51,0,0,0,43.33-53.6,197.74,197.74,0,0,1-62.56,23.5A99.14,99.14,0,0,0,348.31,64c-54.42,0-98.46,43.4-98.46,96.9a93.21,93.21,0,0,0,2.54,22.1,280.7,280.7,0,0,1-203-101.3A95.69,95.69,0,0,0,36,130.4C36,164,53.53,193.7,80,211.1A97.5,97.5,0,0,1,35.22,199v1.2c0,47,34,86.1,79,95a100.76,100.76,0,0,1-25.94,3.4,94.38,94.38,0,0,1-18.51-1.8c12.51,38.5,48.92,66.5,92.05,67.3A199.59,199.59,0,0,1,39.5,405.6,203,203,0,0,1,16,404.2,278.68,278.68,0,0,0,166.74,448c181.36,0,280.44-147.7,280.44-275.8,0-4.2-.11-8.4-.31-12.5A198.48,198.48,0,0,0,496,109.5Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Facebook link" href="#">
                                        <!-- <i class="fab fa-facebook text-facebook"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M455.27,32H56.73A24.74,24.74,0,0,0,32,56.73V455.27A24.74,24.74,0,0,0,56.73,480H256V304H202.45V240H256V189c0-57.86,40.13-89.36,91.82-89.36,24.73,0,51.33,1.86,57.51,2.68v60.43H364.15c-28.12,0-33.48,13.3-33.48,32.9V240h67l-8.75,64H330.67V480h124.6A24.74,24.74,0,0,0,480,455.27V56.73A24.74,24.74,0,0,0,455.27,32Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Instagram link" href="#">
                                        <!-- <i class="fab fa-instagram text-instagram"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M349.33,69.33a93.62,93.62,0,0,1,93.34,93.34V349.33a93.62,93.62,0,0,1-93.34,93.34H162.67a93.62,93.62,0,0,1-93.34-93.34V162.67a93.62,93.62,0,0,1,93.34-93.34H349.33m0-37.33H162.67C90.8,32,32,90.8,32,162.67V349.33C32,421.2,90.8,480,162.67,480H349.33C421.2,480,480,421.2,480,349.33V162.67C480,90.8,421.2,32,349.33,32Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M377.33,162.67a28,28,0,1,1,28-28A27.94,27.94,0,0,1,377.33,162.67Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M256,181.33A74.67,74.67,0,1,1,181.33,256,74.75,74.75,0,0,1,256,181.33M256,144A112,112,0,1,0,368,256,112,112,0,0,0,256,144Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Linkedin link" href="#">
                                        <!-- <i class="fab fa-linkedin text-linkedin"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end team block -->
                    </div>
                    <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/4 xl:px-6">
                        <!-- team block -->
                        <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 hover-grayscale-0 wow fadeInUp"
                            data-wow-duration="1s" data-wow-delay=".5s"
                            style="visibility: visible; animation-duration: 1s; animation-delay: 0.5s; animation-name: fadeInUp;">
                            <div class="relative overflow-hidden px-6">
                                <img src="https://tailone.tailwindtemplate.net/src/img/dummy/avatar4.png"
                                    class="max-w-full h-auto mx-auto rounded-full bg-gray-50 grayscale" alt="title image">
                            </div>
                            <div class="pt-6 text-center">
                                <p class="text-lg leading-normal font-bold mb-1">Toni Lana</p>
                                <p class="text-gray-500 leading-relaxed font-light">UI/UX Designer</p>
                                <!-- social icon -->
                                <div class="mt-2 mb-5 space-x-2">
                                    <a class="hover:text-blue-700" aria-label="Twitter link" href="#">
                                        <!-- <i class="fab fa-twitter text-twitter"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M496,109.5a201.8,201.8,0,0,1-56.55,15.3,97.51,97.51,0,0,0,43.33-53.6,197.74,197.74,0,0,1-62.56,23.5A99.14,99.14,0,0,0,348.31,64c-54.42,0-98.46,43.4-98.46,96.9a93.21,93.21,0,0,0,2.54,22.1,280.7,280.7,0,0,1-203-101.3A95.69,95.69,0,0,0,36,130.4C36,164,53.53,193.7,80,211.1A97.5,97.5,0,0,1,35.22,199v1.2c0,47,34,86.1,79,95a100.76,100.76,0,0,1-25.94,3.4,94.38,94.38,0,0,1-18.51-1.8c12.51,38.5,48.92,66.5,92.05,67.3A199.59,199.59,0,0,1,39.5,405.6,203,203,0,0,1,16,404.2,278.68,278.68,0,0,0,166.74,448c181.36,0,280.44-147.7,280.44-275.8,0-4.2-.11-8.4-.31-12.5A198.48,198.48,0,0,0,496,109.5Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Facebook link" href="#">
                                        <!-- <i class="fab fa-facebook text-facebook"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M455.27,32H56.73A24.74,24.74,0,0,0,32,56.73V455.27A24.74,24.74,0,0,0,56.73,480H256V304H202.45V240H256V189c0-57.86,40.13-89.36,91.82-89.36,24.73,0,51.33,1.86,57.51,2.68v60.43H364.15c-28.12,0-33.48,13.3-33.48,32.9V240h67l-8.75,64H330.67V480h124.6A24.74,24.74,0,0,0,480,455.27V56.73A24.74,24.74,0,0,0,455.27,32Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Instagram link" href="#">
                                        <!-- <i class="fab fa-instagram text-instagram"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M349.33,69.33a93.62,93.62,0,0,1,93.34,93.34V349.33a93.62,93.62,0,0,1-93.34,93.34H162.67a93.62,93.62,0,0,1-93.34-93.34V162.67a93.62,93.62,0,0,1,93.34-93.34H349.33m0-37.33H162.67C90.8,32,32,90.8,32,162.67V349.33C32,421.2,90.8,480,162.67,480H349.33C421.2,480,480,421.2,480,349.33V162.67C480,90.8,421.2,32,349.33,32Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M377.33,162.67a28,28,0,1,1,28-28A27.94,27.94,0,0,1,377.33,162.67Z">
                                            </path>
                                            <path fill="currentColor"
                                                d="M256,181.33A74.67,74.67,0,1,1,181.33,256,74.75,74.75,0,0,1,256,181.33M256,144A112,112,0,1,0,368,256,112,112,0,0,0,256,144Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a class="hover:text-blue-700" aria-label="Linkedin link" href="#">
                                        <!-- <i class="fab fa-linkedin text-linkedin"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="1rem"
                                            height="1rem" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end team block -->
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>

    </main>
@endsection

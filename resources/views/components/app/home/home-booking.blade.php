
<div class="w-full bg-white px-2 py-5 ">

    <h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text">Let's Book A Seat !</h1>

    <div class="w-full flex flex-col lg:flex-row items-start justify-center gap-10 my-5">
        {{-- booking form --}}
        <div class="w-full lg:w-[60%] flex items-center justify-center">
            <div class="mx-auto w-full">
                <form>
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Departure From
                                </label>
                                <input type="text" name="departure" id="fName" placeholder="eg. Dhaka"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="lName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Arrival To
                                </label>
                                <input type="text" name="lName" id="lName" placeholder="eg. Barisal"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="guest" class="mb-3 block text-base font-medium text-[#07074D]">
                            How many guest are you bringing?
                        </label>
                        <input type="number" name="guest" id="guest" placeholder="5" min="0"
                            class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Date
                                </label>
                                <input type="date" name="date" id="date"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="time" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Time
                                </label>
                                <input type="time" name="time" id="time"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="#_"
                            class=" rounded px-5 py-2.5 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                            <span
                                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <span class="relative">Search</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        {{-- available bookings --}}
        <div class="w-full lg:w-[40%] delay-150 ease-in-out p-0 lg:pr-2">
            <h2 class="text-left text-2xl font-bold text-[#07074D]">Available Bookings</h2>
            {{-- item --}}
            <div class="group flex flex-col items-start justify-between border-b border-[#e0e0e0] py-5 cursor-pointer mb-3">
                <h1 class="group-hover:underline text-left text-xl font-bold text-[#07074D]">Name</h1>
                <h3 class="text-left text-base font-bold text-[#07074D]">Dhaka To Barisal</h3>
                <div class="flex flex-row justify-between items-start  w-full mb-2">
                    <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Date :</span> 5/11/24</p>
                    <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Departure At :</span> 5.00 PM
                    </p>
                </div>

                <div class="flex flex-wrap justify-center md:justify-between items-center text-center w-full text-lg text-[#07074D] font-semibold bg-green-400 px-4 py-2 rounded-md gap-5 md:gap-0">
                    <div class="p-2">
                        <p class="font-bold">Deck Seats</p>
                        <p class="text-xs font-bold">(40)</p>
                        <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                    </div>
                    <div class="h-20 w-1 border-l border-[#e0e0e0] hidden md:block"></div>
                    <div class="p-2">
                        <p class="font-bold">Economy Class</p>
                        <p class="text-xs font-bold">(40)</p>
                        <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                    </div>
                    <div class="h-20 w-1 border-l border-[#e0e0e0] hidden md:block"></div>
                    <div class="p-2">
                        <p class="font-bold">Business Class</p>
                        <p class="text-xs font-bold">(40)</p>
                        <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                    </div>

                </div>
            </div>
                 {{-- item --}}
                 <div class="group flex flex-col items-start justify-between border-b border-[#e0e0e0] py-5 cursor-pointer mb-3">
                    <h1 class="group-hover:underline text-left text-xl font-bold text-[#07074D]">Name</h1>
                    <h3 class="text-left text-base font-bold text-[#07074D]">Dhaka To Barisal</h3>
                    <div class="flex flex-row justify-between items-start  w-full mb-2">
                        <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Date :</span> 5/11/24</p>
                        <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Departure At :</span> 5.00 PM
                        </p>
                    </div>
    
                    <div class="flex flex-wrap justify-center md:justify-between items-center text-center w-full text-lg text-[#07074D] font-semibold bg-green-400 px-4 py-2 rounded-md gap-5 md:gap-0">
                        <div class="p-2">
                            <p class="font-bold">Deck Seats</p>
                            <p class="text-xs font-bold">(40)</p>
                            <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                        </div>
                        <div class="h-20 w-1 border-l border-[#e0e0e0] hidden md:block"></div>
                        <div class="p-2">
                            <p class="font-bold">Economy Class</p>
                            <p class="text-xs font-bold">(40)</p>
                            <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                        </div>
                        <div class="h-20 w-1 border-l border-[#e0e0e0] hidden md:block"></div>
                        <div class="p-2">
                            <p class="font-bold">Business Class</p>
                            <p class="text-xs font-bold">(40)</p>
                            <p class="flex flex-row justify-center items-center">500<sub>tk</sub><span class="text-xs">(per)</span></p>
                        </div>
    
                    </div>
                </div>
        </div>
    </div>

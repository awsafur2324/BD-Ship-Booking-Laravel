<div class="w-full ">
    <h1 class="text-4xl font-bold text-center text-[#38c768] mt-10">Assign Ship</h1>
    <div class="mx-auto w-36 border-b-2 border-[#7D7D7D] mb-10 mt-2"></div>

    {{-- form --}}
    <div class="mx-auto w-full ">
        <form>
            {{-- Ship Details Form --}}
            <h1 class="text-2xl font-bold text-[#07074D] my-5">Ship Details</h1>
            @include('components.dashboard.ship-assign.shipDetails-form')
            {{-- Refund Details Form --}}
            <h1 class="text-2xl font-bold text-[#07074D] my-5">Refund Details</h1>
            @include('components.dashboard.ship-assign.refundPolicy-form')
            {{-- Assign Ship Form --}}
            <div class="">
                <hr class="border-dashed border-[#000000] my-5">
                <h1 class="text-2xl font-bold text-[#07074D] my-5">Day 1</h1>
                {{-- Route Map --}}
                <div>
                    <h1 class="text-xl font-bold text-[#07074D] my-5">
                        <i class="fas fa-route"></i>
                        Ship Route
                    </h1>
                    @include('components.dashboard.ship-assign.shipRoute-form')
                </div>
                {{-- Sear Map --}}
                <div>
                    <h1 class="text-xl font-bold text-[#07074D] my-5">
                        <i class="fas fa-chair"></i>
                        Seat Map
                    </h1>
                    @include('components.dashboard.ship-assign.shipSeat-map')
                </div>
                <hr class="border-dashed border-[#000000] my-5">
            </div>

            {{-- next 10 days will being same  --}}
            <div id="next_10_days"
                class="w-full p-5 bg-gray-100 flex flex-col justify-center items-center text-[#07074D]">
                <h2 class="text-lg font-bold">Is next 9 days are same as this day?</h2>
                <div class="flex justify-center items-center gap-5 mt-5 text-base">
                    <button id="yes"
                        class="px-5 py-2 bg-gray-200 rounded-md hover:bg-green-500 hover:text-white">Yes</button>
                    <button id="no"
                        class="px-5 py-2 bg-gray-200 rounded-md hover:bg-green-500 hover:text-white">No</button>
                </div>
            </div>
            {{-- Add another day --}}
            <div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
                {{-- Add another day button --}}
                <div id="add_another_day"
                    class="hidden cursor-pointer relative inline-flex items-center px-20 py-2 overflow-hidden text-base font-medium text-indigo-600 border-2 border-indigo-600 rounded-md hover:text-white group hover:bg-gray-50">
                    <span
                        class="absolute left-0 block w-full h-0 transition-all bg-indigo-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
                    <span
                        class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="relative">Add Day 2</span>
                </div>
                {{-- Submit button --}}
                <div id="btn_submit" class="hidden">
                    <p class="text-base font-semibold mb-5">The next 9 days are same as this day.</p>
                    <button
                        class="rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                        <span
                            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
                        <span class="relative">Assign Ship</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('document').ready(function() {

        $('#yes').click(function() {
            $('#btn_submit').removeClass('hidden');
            $('#next_10_days').addClass('hidden');
        })
        $('#no').click(function() {
            $('#add_another_day').removeClass('hidden');
            $('#next_10_days').addClass('hidden');
        })
    });
</script>

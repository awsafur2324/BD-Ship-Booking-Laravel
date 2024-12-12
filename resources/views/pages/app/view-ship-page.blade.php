@extends('layouts.app_layout')
@section('content')
    <div class="">
        {{-- ship details --}}
        <div class="w-full p-5 bg-gray-100">
            <h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text">Let's Choose A Seat !</h1>
        </div>

        <div class="px-3 my-5">
            <div class="flex w-full flex-row justify-between items-center">
                <div class="flex flex-row gap-2 justify-center items-center">
                    <i class="fas fa-ship text-4xl text-[#07074D]"></i>
                    <div class="">
                        <h2 class="text-lg md:text-2xl font-bold text-[#07074D]">
                            Ship Name
                        </h2>
                        <p class="text-xs inter md:text-sm text-[#03071299] font-normal">
                            Coach : Sundorban Express
                        </p>
                    </div>
                </div>
                <!-- seat count -->
                <div class="inter text-sm font-medium">
                    <button onclick="openModal('modelConfirm')"
                        class=" p-3 flex flex-row justify-center gap-1 text-[#1DD100] bg-[#1dd10026] rounded-lg text-sm">
                        Refund Policy
                    </button>
                </div>
            </div>
            <!-- route info -->
            <div
                class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                <p class="text-[#03071299]">Departure Route</p>
                <p class="text-[#030712]">Dhaka</p>
            </div>
            <div
                class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                <p class="text-[#03071299]">Departure Time</p>
                <p class="text-[#030712]">11-11-2022 9:00 PM</p>
            </div>
            <div
                class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                <p class="text-[#03071299]">Arrival Route 1</p>
                <p class="text-[#030712] flex flex-col justify-center items-end gap-1"><span>Sylhet</span><span>11-11-2022
                        11:00 PM</span></p>
            </div>
            @php
                // this data come from the home page then call the data in here
                $categories = [
                    ['id' => 1, 'name' => 'Economy'],
                    ['id' => 2, 'name' => 'Business'],
                    ['id' => 3, 'name' => 'First Class'],
                ];
                $seats = [
                    1 => ['A1', 'A2', 'A3'],
                    2 => ['B1', 'B2', 'B3'],
                    3 => ['C1', 'C2', 'C3'],
                ];
            @endphp

            {{-- Tabs --}}
            <div
                class="flex text-lg items-center -mx-4 space-x-2 overflow-x-auto overflow-y-hidden sm:justify-center flex-nowrap bg-gray-100 text-gray-800">
                @foreach ($categories as $category)
                    <a href="#tab{{ $category['id'] }}"
                        class="tab-link flex items-center flex-shrink-0 px-5 py-2 border-b-4 text-gray-600"
                        data-tab="{{ $category['id'] }}">
                        {{ $category['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Tab Content
            <div class="tab-content">
                @foreach ($categories as $category)
                    <div id="tab{{ $category['id'] }}" class="tab-pane hidden">
                        <h3 class="text-lg font-bold text-gray-800">Seats for {{ $category['name'] }}</h3>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            @foreach ($seats[$category['id']] as $seat)
                                <div class="p-4 bg-white border rounded shadow">
                                    <p class="text-sm text-gray-600">Seat: {{ $seat }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div> --}}






            <!-- ticket counter -->
            <div class="main flex flex-col md:flex-row justify-between items-start">
                <div class="tab-content">
                    @foreach ($categories as $category)
                        <div id="tab{{ $category['id'] }}"
                            class="tab-pane hidden right-boder pb-6 pr-0 mb-6 md:pb-0 md:pr-6 w-full md:w-[60%]">
                            <h1 class="text-lg text-[#030712] font-semibold">Select Your {{ $category['name'] }} Seat</h1>
                            <h1 class="text-lg text-[#030712] font-semibold">Per Seat Price : BDT 1000</h1>
                            <div class="flex flex-row justify-between items-center my-5">
                                <div class="text-sm text-[#0307127f] flex flex-row items-center justify-center gap-1">
                                    <img src="images/seat-gray.png" alt="" />Available
                                </div>
                                <div class="text-sm text-[#1DD100] flex flex-row items-center justify-center gap-1">
                                    <img src="images/seat-green.png" alt="" />Selected
                                </div>
                            </div>
                            <!-- seat -->
                            <div class="flex flex-col justify-center items-start">
                                @foreach ($seats[$category['id']] as $seat)
                                    <div class="flex flex-wrap justify-between items-start my-2 w-full">
                                        <div class="seat">{{ $seat }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /part1 -->
                <div class="part2 w-full md:w-[40%] pl-0 md:pl-6">
                    <h1 class="text-lg text-[#030712] font-semibold">Confirm Ticket</h1>
                    <div class="p-2 inter">
                        <table id="listTable" class="w-full text-left">
                            <tr class="border border-dashed border-b-[#03071233]">
                                <th>
                                    seat
                                    <span id="totalSelectedSeat"
                                        class="text-xs text-white bg-[#1DD100] px-1 rounded-sm">0</span>
                                </th>
                                <th>Class</th>
                                <th class="text-right">Price</th>
                            </tr>
                            <!-- dynamic tr added here-->
                        </table>
                        <hr class="mt-2" />
                        <div class="flex flex-row justify-between">
                            <h1 class="text-[#030712] text-sm font-semibold py-2">
                                Total Price
                            </h1>
                            <p class="text-[#030712] text-sm font-semibold py-2">
                                BDT <span id="totalPrice">000</span>
                            </p>
                        </div>
                        <div class="">
                            <div id="discountDiv" class="hidden flex flex-row justify-between">
                                <p class="text-[#030712] text-sm font-semibold py-2">
                                    Discount (<span id="parentage">0</span>%)
                                </p>
                                <p class="text-[#030712] text-sm font-semibold py-2">
                                    BDT <span id="discountMoney">000</span>
                                </p>
                            </div>
                            <div id="cuuponDiv" class="relative flex flex-row justify-between gap-0 pt-4">
                                <input disabled id="couponinp" type="text"
                                    class="text-sm w-full font-medium text-[#00030aad] border border-[#03071266] p-2 focus:outline-none"
                                    placeholder="Have any copupon?" />
                                <button onclick="applyClick()" id="disApply"
                                    class="btn text-white bg-[#1DD100] text-sm rounded-none border border-[#1DD100]">
                                    Apply
                                </button>

                                <div id="availableCoupun"
                                    class="absolute w-full top-[100%] p-2 border-2 shadow-lg z-30 bg-slate-300 hidden">
                                    <p class="text-[#00030aad] text-sm p-2 cursor-pointer">
                                        NEW15
                                    </p>
                                    <p class="text-[#00030aad] text-sm p-2 cursor-pointer">
                                        Couple 20
                                    </p>
                                </div>
                            </div>
                            <label id="cupponTip" class="block text-left text-[#00000097] text-xs">Select 4 Seats for
                                excellent discount</label>
                            <div class="flex flex-row justify-between mt-3">
                                <h1 class="text-[#030712] text-sm font-semibold py-2">
                                    Grand Total
                                </h1>
                                <p class="text-[#030712] text-sm font-semibold py-2">
                                    BDT <span id="grandTotal">000</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <form class="text-[#030712] text-sm font-semibold inter mt-5">
                        <label>Passenger Name</label>
                        <input
                            class="w-full p-4 mb-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                            type="text" placeholder="Enter your name" />

                        <label>Phone Number<span class="text-red-500">*</span></label>

                        <input id="phone"
                            class="w-full p-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                            type="number" placeholder="Enter your phone number" />
                        <label id="phoneToolTip" class="block text-right text-[#00000097] text-xs">Enter 11 digit active
                            number</label>

                        <label class="mt-4 block">Email ID</label>
                        <input
                            class="w-full p-4 mb-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                            type="email" placeholder="Enter your email id" />
                    </form>
                    <button disabled id="next"
                        class="btn w-full text-white bg-[#1DD100] text-lg font-extrabold rounded-xl">
                        Next
                    </button>
                    <div class="flex flex-row justify-center gap-2 md:gap-5 mt-3">
                        <p class="underline text-xs text-[#03071299]">
                            Terms and Conditions
                        </p>
                        <p class="underline text-xs text-[#03071299]">
                            Cancellation Policy
                        </p>
                    </div>
                </div>
            </div>



        </div>
    </div>

    {{-- model Refund Policy --}}
    <div id="modelConfirm"
        class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <div class="flex flex-col p-5 rounded-lg shadow bg-white">
                <div class="flex justify-end p-2">
                    <button onclick="closeModal('modelConfirm')" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex">
                    <div class="ml-3">
                        <h2 class="font-bold text-gray-800">Refund Policy</h2>
                        <div class="mt-2 text-sm text-gray-600 leading-relaxed font-semibold flex flex-col gap-2">
                            <span> 1. Full Refund before 10 days of departure</span>
                            <span> 2. Half Refund before 5 days of departure</span>
                            <span> 3. No Refund after 5 days of departure</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center mt-3">

                    <button onclick="closeModal('modelConfirm')"
                        class="px-4 py-2 ml-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Tab functionality
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const tabId = this.dataset.tab;

                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.add('hidden'));

                // Show selected tab pane
                document.getElementById('tab' + tabId).classList.remove('hidden');

                // Update active tab
                document.querySelectorAll('.tab-link').forEach(link => link.classList.remove(
                    'text-gray-900', 'border-violet-600'));
                this.classList.add('text-gray-900', 'border-violet-600');
            });
        });

        // Show first tab by default
        document.querySelector('.tab-link').click();
    </script>
@endsection

<div class="">
    {{-- ship details --}}
    <div class="w-full p-5 bg-gray-100">
        <h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text">Let's Choose A Seat !</h1>
    </div>

    <div class="px-3 my-5">
        @foreach ($shipDetails as $ship)
            <div class="flex w-full flex-row justify-between items-center">
                <div class="flex flex-row gap-2 justify-center items-center">
                    <i class="fas fa-ship text-4xl text-[#07074D]"></i>
                    <div class="">
                        <h2 class="text-lg md:text-2xl font-bold text-[#07074D]">
                            {{ $ship['ship_name'] }}
                        </h2>
                        <p class="text-xs inter md:text-sm text-[#03071299] font-normal">
                            Coach : {{ $ship['couch_no'] }}
                        </p>
                    </div>
                </div>
                <!-- seat count -->
                <div class="inter text-sm font-medium">
                    <div
                        class=" p-3 flex flex-row justify-center gap-1 text-[#1DD100] bg-[#1dd10026] rounded-lg text-sm">
                        Register IMO : {{ $ship['ship_register_no'] }}
                    </div>
                </div>
            </div>
            <!-- route info -->
            <div
                class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                <p class="text-[#03071299]">Departure Route</p>
                <p class="text-[#030712]">{{ $ship['departure_point'] }}</p>
            </div>
            @php

                $formattedDate = date('d-m-Y', strtotime($ship['departure_date']));
                $departure_time = date('h:i A', strtotime($ship['departure_time']));
            @endphp

            <div
                class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                <p class="text-[#03071299]">Departure Time</p>
                <p class="text-[#030712]">{{ $formattedDate }} {{ $departure_time }}</p>
            </div>
            @foreach ($ship['arrival_points'] as $arrival_point)
                @php
                    $arrival_date = date('d-m-Y', strtotime($arrival_point['arrival_date']));
                    $arrival_time = date('h:i A', strtotime($arrival_point['arrival_time']));
                @endphp
                <div
                    class="text-sm font-semibold flex flex-row justify-between items-center border border-dashed border-b-[#03071233] p-4">
                    <p class="text-[#03071299]">Arrival Route {{ $loop->iteration }}</p>
                    <p class="text-[#030712] flex flex-col justify-center items-end gap-1">
                        <span>{{ $arrival_point['arrival_point'] }}</span>
                        <span>{{ $arrival_date }}
                            {{ $arrival_time }}</span>
                    </p>
                </div>
            @endforeach
            {{-- Tabs --}}
            <div
                class="flex text-lg items-center -mx-4 space-x-2 overflow-x-auto overflow-y-hidden sm:justify-center flex-nowrap bg-gray-100 text-gray-800">
                @foreach ($ship['seats'] as $seat)
                    <a href="#tab{{ $loop->iteration }}"
                        class="tab-link flex items-center flex-shrink-0 px-5 py-2 border-b-4 text-gray-600"
                        data-tab="{{ $loop->iteration }}"">
                        {{ $seat['category'] }}
                    </a>
                @endforeach

            </div>

            <!-- ticket counter -->
            <div class="main flex flex-col md:flex-row justify-between items-start my-5">
                <div class="tab-content w-full md:w-[60%]">
                    @foreach ($ship['seats'] as $seat)
                    <div id="tab{{ $loop->iteration }}" class="tab-pane hidden right-boder pb-6 pr-0 mb-6 md:pb-0 md:pr-6 w-full">
                        <div class="flex flex-wrap justify-between items-start my-2 w-full">
                            <h1 class="text-lg text-[#272c39] font-semibold">Select {{ $seat['category'] }} Seat</h1>
                            <h1 class="text-right font-serif text-lg text-[#0a161a] font-semibold">
                                {{ $seat['seat_price'] }}<sup>Per</sup> BDT
                            </h1>
                        </div>
                        <div class="flex flex-row justify-between items-center my-5">
                            <div class="text-base text-[#0307127f] flex flex-row items-center justify-center gap-1">
                                <i class="fas fa-chair"></i>Available
                            </div>
                            <div class="text-base text-[#1DD100] flex flex-row items-center justify-center gap-1">
                                <i class="fas fa-chair"></i>Selected
                            </div>
                            <div class="text-base text-[#FF0000] flex flex-row items-center justify-center gap-1">
                                <i class="fas fa-chair"></i>Booked
                            </div>
                        </div>
                        @php
                            $row = $seat['seat_in_rows'];
                            $col = $seat['seat_in_columns'];
                            $seat_tag = $seat['seat_tag'];
                        @endphp
                        <div class="flex flex-col justify-center items-center w-full">
                            @for ($i = 1; $i <= $row; $i++)
                                <div class="flex flex-row gap-2 justify-between items-center my-2 w-full">
                                    @for ($j = 1; $j <= $col; $j++)
                                        @php
                                            $seat_no = ($i - 1) * $col + $j;
                                            $seat_id = $seat_tag . '-' . $seat_no;
                                            $isBooked = in_array($seat_id, $bookedSeats);
                                        @endphp
                                        <button 
                                            id="{{ $seat_id }}" 
                                            value="{{ $seat_id }}"
                                            data-price="{{ $seat['seat_price'] }}"
                                            data-category="{{ $seat['category'] }}"
                                            onclick="selectSeat('{{ $seat_id }}', '{{ $user['id'] }}', {{ $ship['id'] }}, '{{ $ship['departure_id'] }}', '{{ $seat['seatMap_id'] }}')"
                                            class="seat w-full mx-1 p-2 border text-center {{ $isBooked ? 'bg-red-400 cursor-not-allowed' : ' bg-gray-200 border-gray-400 active_seat' }}"
                                            {{ $isBooked ? 'disabled' : '' }}>
                                            {{ $seat_id }}
                                        </button>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
                </div>
        @endforeach
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
                <div id="discount_container" class="hidden">
                    <div id="discountDiv" class=" flex flex-row justify-between">
                        <p class="text-[#030712] text-sm font-semibold py-2">
                            Discount (<span id="parentage">0</span>%)
                        </p>
                        <p class="text-[#030712] text-sm font-semibold py-2">
                            BDT <span id="discountMoney">000</span>
                        </p>
                    </div>
                    <div id="cuuponDiv" class="relative flex flex-row justify-between gap-0 pt-4">
                        <input {{ isset($discountOffers) ? '' : 'disabled' }} id="couponinp" type="text"
                            class="text-sm w-full font-medium text-[#00030aad] border border-[#03071266] p-2 focus:outline-none"
                            placeholder="Have any copupon?" />
                        <button onclick="applyClick({{ json_encode($discountOffers) }})" id="disApply"
                            class="btn text-white bg-[#1DD100] p-2 text-sm rounded-none border border-[#1DD100]">
                            Apply
                        </button>

                        <div id="availableCoupun"
                            class="absolute w-full top-[100%] p-2 border-2 shadow-lg z-30 bg-slate-300 hidden">
                            @foreach ($discountOffers as $coupon)
                                <div data-id="{{ $coupon['coupon_code'] }}"
                                    class="coupon w-full text-[#00030aad] text-sm p-2 cursor-pointer flex flex-row justify-between items-center">
                                    <p class="text-left pr-5">
                                        {{ $coupon['coupon_code'] }}
                                    </p>
                                    <p class="flex-grow text-center text-[#00030aad] flex justify-center items-center">
                                        <span
                                            class="inline-block w-full border-t border-dashed border-[#00030aad]"></span>
                                    </p>
                                    <p class="text-right pl-5">
                                        ({{ $coupon['discount_percentage'] }}%)
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ isset($discountOffers) ? 'click on apply after choose all of your seat.' : '<label id="cupponTip" class="block text-left text-[#00000097] text-xs">You have no coupon</label>' }}
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
            <div class="text-[#030712] text-sm font-semibold inter mt-5">
                <label>Passenger Name</label>
                <input id="name" value="{{ isset($user['name']) ? $user['name'] : '' }}"
                    {{ isset($user['name']) ? 'readonly' : '' }}
                    class="w-full p-4 mb-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                    type="text" placeholder="Enter your name" />

                <label>Phone Number<span class="text-red-500">*</span></label>

                <input id="phone" value="{{ isset($user['phone']) ? $user['phone'] : '' }}"
                    {{ isset($user['name']) ? 'readonly' : '' }}
                    class="w-full p-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                    type="number" placeholder="Enter your phone number" />

                <label class="mt-4 block">Email ID</label>
                <input id="email" value="{{ isset($user['email']) ? $user['email'] : '' }}"
                    {{ isset($user['name']) ? 'readonly' : '' }}
                    class="w-full p-4 mb-4 border border-[#03071219] text-sm font-medium rounded-md mt-2 focus:outline-none"
                    type="email" placeholder="Enter your email id" />

                <p class="text-sm text-gray-700 py-4 px-2">if you want to change the details Then update your profile
                </p>
            </div>
            <button id="next" onclick="submitForm()"
                class="p-3 cursor-pointer w-full text-white bg-[#1DD100] hover:bg-[#a7d8a0] text-lg font-extrabold rounded-xl">
                Next
            </button>
            <div class="flex flex-row justify-center gap-2 md:gap-5 mt-3">
                <p onclick="openModalModelConfirm()" class="cursor-pointer underline text-xs text-[#03071299]">
                    Refund & Cancellation Policy
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Show modal on click of refund policy
    function openModalModelConfirm() {
        $("#modelConfirm").removeClass('hidden');
    }
    // Hide modal
    function closeModal() {
        $('#modelConfirm').addClass('hidden'); // Alternative method to hide modal
    }

    // Show available coupons on input click
    $('#couponinp').click(function() {
        $('#availableCoupun').removeClass('hidden');
    });

    // Close coupon dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#cuuponDiv').length) {
            $('#availableCoupun').addClass('hidden');
        }
    });

    // Update input field when a coupon is selected
    $('.coupon').on('click', function() {
        const selectedCoupon = $(this).data('id'); // Get the selected coupon code
        $('#couponinp').val(selectedCoupon); // Set it in the input field
        $('#availableCoupun').addClass('hidden'); // Hide the coupon dropdown
    });

    // Apply coupon on button click
    let discount = {
        discount_id: 0,
        discount_percentage: 0,
    };
    window.applyClick = function(offers) {
        const couponCode = $("#couponinp").val();
        if (couponCode == '') {
            $("#parentage").text(0);
            discount = {
                discount_id: 0,
                discount_percentage: 0,
            };
            showdiscount();
        }
        offers.map((offer) => {
            if (offer.coupon_code == couponCode) {
                $("#parentage").text(offer.discount_percentage);
                discount = {
                    discount_id: offer.id,
                    discount_percentage: offer.discount_percentage,
                };
                showdiscount();
            }
        })
    };

    function showdiscount() {
        const totalPrice = parseFloat($("#totalPrice").text()) || 0;
        const discount_percentage = parseFloat($("#parentage").text()) || 0;
        const discountMoney = (totalPrice * discount_percentage) / 100;
        $("#discountMoney").text(discountMoney.toFixed(2));
        updateGrandTotal();
    }

    // Initialize an object to store selected seat details
    let selectedSeats = {};
    let shipDetails_id = 0;
    let departurePoints_id = 0;
    function selectSeat(seat_id, user_id, ship_id, departure_id, Seat_map_id) {
        const seat = $('#' + seat_id);
        const seat_price = parseFloat(seat.data('price')) || 0;
        const seat_category = seat.data('category');

        if (seat.hasClass('selected')) {
            // Deselect seat
            seat.removeClass('selected').removeClass('bg-green-300').addClass('bg-gray-200');
            updateSelectedSeats(seat_id, seat_price, seat_category, user_id, ship_id, departure_id, Seat_map_id, false);
        } else {
            // Select seat
            seat.addClass('selected').addClass('bg-green-300').removeClass('bg-gray-200');
            updateSelectedSeats(seat_id, seat_price, seat_category, user_id, ship_id, departure_id, Seat_map_id, true);
        }
    }

    // Function to update the selected seat list
    function updateSelectedSeats(seat_id, seat_price, seat_category, user_id, ship_id, departure_id, Seat_map_id,
        isSelected) {
        const seatCountElem = $('#totalSelectedSeat');
        const totalPriceElem = $('#totalPrice');
        let totalSeats = Object.keys(selectedSeats).length;
        let totalPrice = Object.values(selectedSeats).reduce((sum, seat) => sum + seat.seat_price, 0);

        shipDetails_id = ship_id;
        departurePoints_id = departure_id;

        if (isSelected) {
            // Add seat to the selectedSeats object
            selectedSeats[seat_id] = {
                seat_tag: seat_id,
                seat_price: seat_price,
                seat_category: seat_category,
                user_id: user_id,
                shipDetails_id: ship_id,
                departurePoints_id: departure_id,
                Seat_map_id: Seat_map_id
            };

            // Add seat details to the table
            $('#listTable').append(`
                <tr id="seat-${seat_id}" class="selected_seat">
                    <td>${seat_id}</td>
                    <td>${seat_category}</td>
                    <td class="text-right">${seat_price.toFixed(2)} BDT</td>
                </tr>
            `);
        } else {
            // Remove seat from the selectedSeats object
            delete selectedSeats[seat_id];

            // Remove seat details from the table
            $(`#seat-${seat_id}`).remove();
        }

        // Discounts logic
        const totalSelectedSeat = $(".selected_seat").length;
        if (totalSelectedSeat > 0) {
            // un hide discount container
            $('#discount_container').removeClass('hidden');
        } else {
            // hide discount container
            $('#discount_container').addClass('hidden');
        }

        // Update seat count and price based on the updated selectedSeats object
        totalSeats = Object.keys(selectedSeats).length;
        totalPrice = Object.values(selectedSeats).reduce((sum, seat) => sum + seat.seat_price, 0);

        seatCountElem.text(totalSeats);
        totalPriceElem.text(totalPrice.toFixed(2));

        showdiscount();
        // Update the grand total
        updateGrandTotal();

    }

    // Function to update grand total (if applicable)
    function updateGrandTotal() {
        // Update the grand total logic (if additional calculations are needed)
        const grandTotalElem = $('#grandTotal'); // Example: Update the grand total element
        const totalPrice = parseFloat($('#totalPrice').text()) || 0;

        // Assuming you have taxes or additional charges
        const discount_percentage = parseFloat($("#parentage").text()) || 0;
        const discount = (totalPrice * discount_percentage) / 100;
        const grandTotal = totalPrice - discount;
        grandTotalElem.text(grandTotal.toFixed(2));
    }

    // Submit form when all seats are selected
    async function submitForm() {
        //check Any filled input field
        if ($('#name').val() == '' || $('#phone').val() == '' || $('#email').val() == '') {
            errorToast('Please fill all required fields');
            return false;
        }
        //check Any selected seat

        if (Object.keys(selectedSeats).length == 0) {
            errorToast('Please select at least one seat');
            return false;
        }

        // Submit the form
        showLoader();
        const res = await axios.post('/booking-invoice', {
            selectedSeats: selectedSeats,
            discount: discount,
            shipDetails_id: shipDetails_id,
            departurePoints_id: departurePoints_id
        });
        hideLoader();
        if (res.data.status == 'success') {
            successToast(res.data.message);
            window.location.href = `${res.data.data.paymentMethod.GatewayPageURL}`;

        } else {
            errorToast(res.data.message);
        }
    }
</script>

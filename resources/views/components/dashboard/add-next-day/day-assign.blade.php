
<div id="assign-ship-form" class="">
    <h1 class="text-lg sm:text-3xl font-bold text-[#07074D] text-center mt-5">Ship Assign For Another Day</h1>
    <div class="mx-auto w-36 border-b-2 border-[#7D7D7D] mb-10 mt-2"></div>

    <div class="relative w-full flex justify-center items-center">
        <button id="btn_view" class="absolute right-0 top-0 bg-green-600 px-5 py-2 rounded-md font-medium text-white">
            View already assigned dates
        </button>
    </div>

    {{-- ship route --}}
    <h1 class="text-xl font-bold text-[#07074D] my-5">
        <i class="fas fa-route"></i>
        Ship Route
    </h1>
    @include('components.dashboard.add-next-day.add-day-route')

    {{-- ship seat map --}}
    @include('components.dashboard.add-next-day.add-day-shipSeat-map')

    {{-- ship seat price --}}
    @include('components.dashboard.add-next-day.add-day-ship-price')

    {{-- button --}}
    <div class="w-full p-5 bg-gray-100 flex justify-center items-center">
        <button id="btn_submit" data-id="{{ $ship_id }}"
            class="hidden relative px-12 py-3 overflow-hidden font-medium text-green-800 bg-gray-100 border border-gray-200 rounded-md shadow-inner group">
            <span
                class="absolute top-0 left-0 w-0 h-0 transition-all duration-200 border-t-2 border-green-600 group-hover:w-full ease"></span>
            <span
                class="absolute bottom-0 right-0 w-0 h-0 transition-all duration-200 border-b-2 border-green-600 group-hover:w-full ease"></span>
            <span
                class="absolute top-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-green-400 group-hover:h-full ease"></span>
            <span
                class="absolute bottom-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-green-400 group-hover:h-full ease"></span>
            <span
                class="absolute inset-0 w-full h-full duration-300 delay-300 bg-green-500 opacity-0 group-hover:opacity-100"></span>
            <span
                class="relative transition-colors duration-300 delay-200 group-hover:text-white ease text-lg">Assign</span>
        </button>
    </div>
</div>

{{-- modal for already assigned dates --}}
<div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
    <div id="closeModel" class="absolute top-5 right-5 px-1.5 cursor-pointer text-red-600 bg-white rounded-full">
        &times;</div>
    <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-full p-5">
        <h1 class="p-5 text-center text-lg">View All days which is already assigned to this ship from today?</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full pt-3 table-auto border-collapse " id="tableData">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">No</th>
                        <th class="border border-gray-200 px-4 py-2">Departure Place</th>
                        <th class="border border-gray-200 px-4 py-2">Departure Date</th>
                    </tr>
                </thead>
                <tbody id="tableList" class="bg-white"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#btn_view").on('click', function() {
            $('#modelConfirm').removeClass('hidden');
        })

        // Event delegation for close button
        $('#closeModel').on('click', function() {
            $('#modelConfirm').addClass('hidden');
        });

        // Load data for already assigned dates
        loadData();

        async function loadData() {
            try {
                const res = await axios.post('/api/get-available-dates', {
                    ship_id: $('#btn_submit').data('id')
                });

                let tableList = $("#tableList");
                let tableData = $("#tableData");

                // Destroy DataTable if it already exists
                if ($.fn.DataTable.isDataTable('#tableData')) {
                    tableData.DataTable().destroy();
                }
                tableList.empty();

                let data = res.data;

                if (data.length === 0) {
                    tableList.append(`
                <tr>
                    <td colspan="3" class="text-center text-gray-500">No data available. You can select any dates.</td>
                </tr>
            `);
                    return;
                }

                data.forEach((ship, index) => {
                    let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${ship.departure_point}</td>
                    <td>${ship.formatted_departure_date}</td>
                </tr>
            `;
                    tableList.append(row);
                });

                // Initialize DataTable
                new DataTable('#tableData', {
                    responsive: true,
                    autoWidth: false,
                    order: [
                        [0, 'desc']
                    ],
                    lengthMenu: [5, 10, 15, 20],
                    paging: true,
                    searching: true,
                    language: {
                        paginate: {
                            next: 'Next →',
                            previous: '← Previous',
                        },
                        search: 'Search:',
                        lengthMenu: 'Show _MENU_ entries',
                        zeroRecords: 'No matching records found',
                    },
                });
            } catch (error) {
                console.error("Error loading data:", error);
            }
        }



        //------------------ Button click event for submit
        $('#btn_submit').click(async function() {
            try {
                let ship_id = $(this).data('id');
                // ----------------------------------------Ship Route Data
                let shipRoute = [];
                shipRoute.push({
                    departure_from: $('#departure_from').val(),
                    departure_date: $('#departure_date').val(),
                    departure_time: $('#departure_time').val(),
                });

                // Iterate through each 'add-route-class' section
                $('.add-route-class').each(function() {
                    const arrival_at = $(this).find('input[name="arrival_at"]').val();
                    const arrival_date = $(this).find('input[name="arrival_date"]').val();
                    const arrival_time = $(this).find('input[name="arrival_time"]').val();

                    shipRoute.push({
                        arrival_at,
                        arrival_date,
                        arrival_time,
                    });
                });

                // ------------------------------------seat map data
                let seatMap = [];
                // Iterate through each refund-policy section
                $('.seat-map-class').each(function() {
                    const seat_category = $(this).find('input[name="seat_category"]').val();
                    const seat_row = $(this).find('input[name="seat_row"]').val();
                    const seat_column = $(this).find('input[name="seat_column"]').val();
                    const seat_tag = $(this).find('input[name="seat_tag"]').val();

                    seatMap.push({
                        seat_category,
                        seat_row,
                        seat_column,
                        seat_tag,

                    });
                });

                //-------------------------------seat price data
                const seatPrices = []; // Initialize array to store data
                // Loop through each route and collect data
                $('#seat-price-container > div > div').each(function() {
                    const routeElement = $(this);

                    // Collect seat prices for this route
                    routeElement.find('input[name^="seat_price"]').each(function() {
                        const input = $(this);
                        const seat_category = input.attr('name').split('_')
                            .pop(); // Extract seat category from name
                        const nameParts = input.attr('name').split('_');
                        const arrival_at = nameParts[nameParts.length - 2];

                        const seat_price = input.val(); // Get seat price value

                        // Add to array
                        seatPrices.push({
                            arrival_at: arrival_at,
                            seat_category: seat_category,
                            seat_price: seat_price
                        });
                    });
                });


                // Check for empty fields
                const requiredPrice = [
                    ...seatPrices.map(price => Object.values(price))
                ].flat();
                const hasEmptyFields = requiredPrice.some(field => !field);

                if (hasEmptyFields) {
                    errorToast("Please fill in all required fields.");
                    return; // Stop execution if there are empty fields
                }

                // Send data to server
                const data = {
                    ship_id,
                    shipRoute,
                    seatMap,
                    seatPrices,
                };
                // console.log("data:", data);
                showLoader(); //--check config.js file
                let res = await axios.post("/api/addNextDay", data);
                hideLoader() //--check config.js file
                console.log("data:", res);
                if (res.data.status == 'success') {
                    successToast(res.data.message);
                    setTimeout(() => {
                        $('#assign-ship-form').find('input , select').val('');
                    }, 1000);
                } else {
                    errorToast(res.data.message);
                }

            } catch (error) {
                console.error(error);
                // Handle the error appropriately, e.g., display an error message to the user
            }
        });
    });
</script>

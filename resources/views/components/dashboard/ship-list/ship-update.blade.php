<div class="">
    @if ($updateType == 'details')
        <h1 class="text-center text-2xl p-5 font-semibold capitalize">Update {{ $updateType }}</h1>
        @include('components.dashboard.ship-list.ship-update-details', ['data' => $data])
    @elseif ($updateType == 'policy')
        <h1 class="text-center text-2xl p-5 font-semibold capitalize">Update {{ $updateType }}</h1>
        @include('components.dashboard.ship-list.ship-update-refund', ['data' => $data])
    @elseif ($updateType == 'date_base')
        <h1 class="text-center text-2xl p-5 font-semibold capitalize">Choose a departure date for updater!</h1>
        <div class="w-full p-4">
            <div class="max-w-md mx-auto flex justify-center items-center">
                <input type="date" name="departure_date" id="departure_date" required
                    class="w-full rounded-l-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                <button type="submit" onclick="search({{ $ship_id }})"
                    class="w-16 rounded-r-md border border-[#6A64F1] bg-[#6A64F1] py-3 px-6 text-base font-medium text-white hover:bg-[#554BDC] focus:border-[#554BDC] focus:shadow-md">
                    <i class="fa fa-search "></i>
                </button>
            </div>
        </div>
    @else
        <div class="alert alert-danger">Invalid update type</div>
    @endif
</div>

{{-- model --}}
<div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
    <div id="closeModel" class="absolute top-5 right-5 px-1.5 cursor-pointer text-red-600 bg-white rounded-full">
        &times;</div>
    <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-md">
        <h1 class="p-5 text-center text-lg">Choose a departure date what's you want to update!</h1>
        <div id="modelBody"
            class="flex flex-wrap p-5 w-full rounded-lg shadow bg-white gap-3  font-semibold text-center">
            {{-- Dynamic content will be added here --}}
        </div>
    </div>
</div>
</div>


<script>
    $(document).ready(function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is zero-indexed
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        // Set minimum date for all date inputs
        $('#departure_date').attr('min', minDate);

        window.search = async function(ship_id) {
            showLoader();
            let date = $('#departure_date').val(); // Correct variable name
            if (!date) {
                hideLoader();
                errorToast('Please select a date');
                return;
            }

            const res = await axios.post('/api/departure-date', {
                'ship_id': ship_id,
                'date': date,
            })

            if (res.data && res.data.length > 0) {
                const modalBody = $('#modelBody');
                modalBody.empty(); // Clear existing content

                res.data.forEach(item => {
                    // Combine departure_date and departure_time into a valid ISO format
                    let dateTimeString =
                        `${item.departure_date.split(' ')[0]}T${item.departure_time}:00`;

                    let departureDateTime = new Date(dateTimeString);

                    // Validate parsed date-time
                    if (isNaN(departureDateTime.getTime())) {
                        console.error('Invalid date or time value:', item);
                        return; // Skip invalid items
                    }

                    let formattedDate = new Intl.DateTimeFormat('en-GB', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }).format(departureDateTime);

                    let formattedTime = new Intl.DateTimeFormat('en-GB', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }).format(departureDateTime);

                    modalBody.append(`
                        <div data-item-id="${item.id}" data-ship-id="${ship_id}" class="updateModel py-2 bg-green-500 w-full rounded cursor-pointer flex flex-col justify-start items-center">
                            <p>Departure Point: <span class="font-bold">${item.departure_point}</span></p>
                            <p>Date: ${formattedDate} ${formattedTime}</p>
                        </div>
                    `);
                });

                hideLoader();
                $('#modelConfirm').removeClass('hidden'); // Show the modal
            } else {
                hideLoader();
                errorToast('No data available for the selected date');
            }
        };

        //close modal
        $('#closeModel').click(function() {
            $('#modelConfirm').addClass('hidden');
        });

        $(document).on('click', '.updateModel', async function() {
            const itemId = $(this).data('item-id');
            const shipId = $(this).data('ship-id');

            try {
                window.location.href = (`/dashboard/ship-list/${shipId}/date_base/${itemId}`);

            } catch (error) {
                console.error('Error in API call:', error);
                errorToast('An error occurred while processing the request');
            }
        });
    });
</script>

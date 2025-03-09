<div class="container mx-auto px-2">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="shadow-lg p-5 bg-white rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex-1">
                        <h4 class="text-black text-center font-bold text-2xl">My Booking</h4>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full pt-3 table-auto border-collapse " id="tableData">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">No</th>
                                <th class="border border-gray-200 px-4 py-2">Ship Name</th>
                                <th class="border border-gray-200 px-4 py-2">Couch No</th>
                                <th class="border border-gray-200 px-4 py-2">Seats</th>
                                <th class="border border-gray-200 px-4 py-2">Departure</th>
                                <th class="border border-gray-200 px-4 py-2">Date & Time</th>
                                <th class="border border-gray-200 px-4 py-2">Status</th>
                                <th class="border border-gray-200 px-4 py-2">Total Price</th>
                                <th class="border border-gray-200 px-4 py-2">Refund</th>
                            </tr>
                        </thead>
                        <tbody id="tableList" class="bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div id="modelConfirm"
        class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <div id="closeModel" class="absolute top-5 right-5 px-1.5 cursor-pointer text-red-600 bg-white rounded-full">
            &times;</div>
        <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <h1 id="refundID" class="hidden"></h1>
            <h1 id="invoiceID" class="hidden"></h1>
            <h1 id="refundStatus" class="p-5 text-center text-lg font-semibold"></h1>
            <div class="flex flex-wrap p-5 w-full rounded-lg shadow bg-white gap-3  font-semibold text-center">
                <label for="refundReason" class="mb-1 block text-base font-semibold text-[#07074D]">
                    What is the reason for Refund: <span class="text-red-500">*</span>
                </label>
                <input type="text" name="refundReason" id="refundReason" required placeholder="Reason for refund"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                <button id="refundBtn" class="bg-red-500 text-white rounded-md mt-4 p-2 w-full">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        loadData();

        async function loadData() {
            try {
                const res = await axios.get('/api/my-bookings');
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
                        <tr class="w-full" colspan="9">
                            <td colspan="9" class="text-center font-bold text-red-500">Please Buy Some Ticket</td>
                        </tr>
                    `);
                    return;
                }

                data.forEach((booking, index) => {
                    // Format departure date and time
                    const formatDate = (dateString) => {
                        const options = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        return new Date(dateString).toLocaleDateString('en-US', options);
                    };

                    const formatTime = (timeString) => {
                        const [hour, minute] = timeString.split(':');
                        const period = hour >= 12 ? 'PM' : 'AM';
                        const formattedHour = ((hour % 12) || 12).toString().padStart(2, '0');
                        return `${formattedHour}:${minute} ${period}`;
                    };

                    let seats = booking.all_seats.join(', ');
                    let status = booking.status === 'Upcoming' ?
                        `<span class="text-green-500 font-bold">Upcoming</span>` :
                        `<span class="text-gray-500 font-bold">Passout</span>`;
                    let refundButton = booking.can_refund ?
                        `<button data-id="${booking.id}" class="refund-button bg-red-500 text-white px-4 py-2 rounded-md">Refund</button>` :
                        `<button class="bg-gray-300 text-gray-500 px-4 py-2 rounded-md" disabled>Refund</button>`;

                    let row = `
                        <tr>
                            <td class="border border-gray-200 px-4 py-2">${index + 1}</td>
                            <td class="border border-gray-200 px-4 py-2">${booking.ship_name}</td>
                            <td class="border border-gray-200 px-4 py-2">${booking.couch_no}</td>
                            <td class="border border-gray-200 px-4 py-2">${seats}</td>
                            <td class="border border-gray-200 px-4 py-2">${booking.place}</td>
                            <td class="border border-gray-200 px-4 py-2 text-nowrap">${formatDate(booking.date)} <br> ${formatTime(booking.time)}</td>
                            <td class="border border-gray-200 px-4 py-2 ${status.includes('Upcoming') ? 'text-green-500' : 'text-gray-500'}">${status}</td>
                            <td class="border border-gray-200 px-4 py-2">${booking.total_price}</td>
                            <td class="border border-gray-200 px-4 py-2 flex flex-col justify-center items-center gap-2">
                                <button onclick=downloadTicket(${booking.id}) class="bg-green-500 text-white px-4 py-2 rounded-md text-sm">Download</button>
                                ${refundButton}
                            </td>
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

                // Add click event listener for refund buttons
                tableList.on('click', '.refund-button', async function() {
                    let invoiceID = $(this).data('id');

                    // Refund time check
                    const refundCheck = await axios.get(
                        `/api/booking/refund-check/${invoiceID}`);

                    const refundStatus = refundCheck.data.refund_status;
                    const refundID = refundCheck.data.refund_id;
                    // Add a class for refund type (for style adjustments if needed)
                    if (refundStatus === 'Full' || refundStatus === 'Half') {
                        // Show the modal with refund status
                        $('#modelConfirm').removeClass('hidden');
                        $('#refundReason').val(''); // Reset the input field
                        $('#refundID').val(refundID);
                        $('#invoiceID').val(invoiceID);

                        // Display the refund status in the modal header
                        $('#refundStatus').text(
                            `You are eligible for "${refundStatus}  Refund "`);
                    } else {
                        errorToast('You are not eligible for any refund.');
                    }

                });

                // Close the modal when the close button is clicked
                $('#closeModel').on('click', function() {
                    $('#modelConfirm').addClass('hidden');
                });

                // Handle refund submission
                $('#refundBtn').on('click', async function() {
                    const reason = $('#refundReason').val();
                    const refundID = $('#refundID').val();
                    if (!reason) {
                        alert('Please enter a reason for the refund.');
                        return;
                    }

                    // Call the refund API
                    const invoiceID = $('#invoiceID').val();
                    const res = await axios.post(`/api/booking/refund_request`, {
                        reason: reason,
                        invoice_id: invoiceID,
                        refundID: refundID,
                    });

                    // Handle success
                    if (res.data.status == true) {
                        successToast(res.data.massage);
                        $('#modelConfirm').addClass('hidden');

                    } else {
                        errorToast(res.data.massage);
                    }
                });

            } catch (error) {
                console.error("Error loading data:", error);
            }
        }
        // Function to handle ticket download
        window.downloadTicket = function(bookingId) {
            const url = `/booking/download-ticket/${bookingId}`;
            window.open(url, '_blank');
        }
    });
</script>

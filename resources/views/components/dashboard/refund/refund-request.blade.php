<div class="container mx-auto px-2">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="shadow-lg p-5 bg-white rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex-1">
                        <h4 class="text-black text-center font-bold text-2xl">Refund Request</h4>
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
                                <th class="border border-gray-200 px-4 py-2">Departure Info</th>
                                <th class="border border-gray-200 px-4 py-2">Reason</th>
                                <th class="border border-gray-200 px-4 py-2">Price</th>
                                <th class="border border-gray-200 px-4 py-2">Refund Type</th>
                                <th class="border border-gray-200 px-4 py-2">Refund Price</th>
                                <th class="border border-gray-200 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList" class="bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        loadData();

        async function loadData() {
            try {
                const res = await axios.get('/api/Manager-RefundRequests');
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
                            <td colspan="9" class="text-center font-bold text-red-500">No Refund Requests Found</td>
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



                    // Append rows dynamically
                    let row = `
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">${index + 1}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.ship_name}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.couch_no}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.all_seats.join(', ')}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            <span>${booking.place}</span><br>
                            <span>${formatDate(booking.date)}</span> <br>
                            <span>${formatTime(booking.time)}</span>
                        </td>
                        <td class="border border-gray-200 px-4 py-2">${booking.reason}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.total_price}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.refund_category}</td>
                        <td class="border border-gray-200 px-4 py-2">${booking.refund_price ?? 'N/A'}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            <button class="bg-blue-500 text-white rounded-md px-2 py-1" 
                                    onclick="acceptRefund(${booking.refund_id}, ${booking.id} , ${booking.refund_price ?? 0} , '${booking.reason}')">
                                Accept
                            </button>
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


            } catch (error) {
                console.error("Error loading data:", error);
            }
        }

        window.acceptRefund = async function(refund_id, invoice_id, refund_amount, reason) {
            try {
                // Trigger the POST request to API
                const res = await axios.post('/api/AcceptRefund', {
                    refund_id: refund_id,
                    invoice_id: invoice_id,
                    refund_amount: refund_amount,
                    reason: reason,
                });

                // Check the response from the backend
                if (res.data.success === true) {
                    successToast(res.data.message);
                    loadData(); // reload your data
                } else {
                    errorToast(res.data.message);
                }
            } catch (error) {
                // Log the error if something goes wrong
                errorToast("An error occurred while processing the refund.");
            }
        }
    });
</script>

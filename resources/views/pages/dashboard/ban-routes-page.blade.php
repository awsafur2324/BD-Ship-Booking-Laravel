@extends('layouts.dashboard_layout')
@section('content')
    <div class="container mx-auto px-2">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <div class="shadow-lg p-5 bg-white rounded-lg">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex-1">
                            <h4 class="text-black text-center font-bold text-2xl">My Ships</h4>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full pt-3 table-auto border-collapse " id="tableData">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">No</th>
                                    <th class="border border-gray-200 px-4 py-2">Ship Name</th>
                                    <th class="border border-gray-200 px-4 py-2">Register No</th>
                                    <th class="border border-gray-200 px-4 py-2">Couch No</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Departure place</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Departure Date</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Departure Time</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Action</th>
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
                    const res = await axios.get('/api/getBanShipList');
                    let tableList = $("#tableList");
                    let tableData = $("#tableData");

                    // Destroy DataTable if it already exists
                    if ($.fn.DataTable.isDataTable('#tableData')) {
                        tableData.DataTable().destroy();
                    }
                    tableList.empty();

                    // Access the departure_points array from the response
                    let data = res.data.departure_points;

                    if (!data || data.length === 0) {
                        tableList.append(`
                    <tr>
                        <td colspan="8" class="text-center text-gray-500">There is no ship</td>
                    </tr>
                     `);
                        return;
                    }

                    data.forEach((ship, index) => {
                        // Reformat departure_date and departure_time
                        let formattedDate = new Date(ship.departure_date).toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        }); // Output: 5, Jan, 2025

                        let formattedTime = new Date(`1970-01-01T${ship.departure_time}Z`)
                            .toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            }); // Output: 02:30 PM

                        let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${ship.ship_name}</td>
                    <td>${ship.ship_register_no}</td>
                    <td>${ship.couch_no}</td>
                    <td>${ship.departure_point}</td>
                    <td>${formattedDate}</td>
                    <td>${formattedTime}</td>
                    <td>
                        <button data-id="${ship.id}" class="updateBtn px-4 py-2 text-sm text-white border bg-green-500 border-green-500 rounded-md hover:bg-white hover:text-green-500 hover:font-bold">
                            Active
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

            // Event delegation for delete button
            $('#tableList').on('click', '.updateBtn', async function() {
                let ship_id = $(this).data('id');
                try {
                    showLoader();
                    const res = await axios.post('/api/ban-ship-activate', {
                        ship_id: ship_id,
                    });
                    hideLoader();
                    if (res.data.success) {
                        successToast("Route Active successfully");
                    } else {
                        errorToast("Error while activating route");
                    }
                    loadData();
                } catch (error) {
                    console.error("Error activating route:", error);
                    hideLoader();
                    errorToast("Error while activating route");
                }
            });
        });
    </script>
@endsection

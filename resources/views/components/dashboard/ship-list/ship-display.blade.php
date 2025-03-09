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
                                <th class="border border-gray-200 px-4 py-2 text-center">Any Update</th>
                                <th class="border border-gray-200 px-4 py-2 text-center">Delete</th>
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
            <h1 class="p-5 text-center text-lg">Whats You want to update?</h1>
            <div class="flex flex-wrap p-5 w-full rounded-lg shadow bg-white gap-3  font-semibold text-center">
                <div id="details" class="updateModel py-2 bg-green-500 w-full rounded cursor-pointer">Ship Details
                </div>
                <div id="policy" class="updateModel py-2 bg-green-500 w-full rounded cursor-pointer">Ship Refund
                    Policy</div>
                <div id="date_base" class="updateModel py-2 bg-green-500 w-full rounded cursor-pointer">Ship Date Base
                    Update</div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        loadData();

        async function loadData() {
            try {
                const res = await axios.get('/api/getShipList');
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
                        <td colspan="6" class="text-center text-gray-500">Please add a new ship</td>
                    </tr>
                `);
                    return;
                }

                data.forEach((ship, index) => {
                    let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ship.ship_name}</td>
                        <td>${ship.ship_register_no}</td>
                        <td>${ship.couch_no}</td>
                        <td>
                            <button data-id="${ship.id}" class="updateBtn px-4 py-2 text-sm text-white border bg-green-500 border-green-500 rounded-md hover:bg-white hover:text-green-500 hover:font-bold">
                                Update
                            </button>
                        </td>
                        <td>
                            <button data-id="${ship.id}" class="deleteBtn px-4 py-2 text-sm text-white border bg-red-500 border-red-500 rounded-md hover:bg-white hover:text-red-500 hover:font-bold">
                                Delete
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
        $('#tableList').on('click', '.deleteBtn', async function() {
            let ship_id = $(this).data('id');
            
            try {
                showLoader();
                const res = await axios.post('/api/deleteShip', {
                    ship_id: ship_id
                });
                hideLoader();
                loadData();
                successToast(res.data.message);
            } catch (error) {
                errorToast("Something went wrong");
            }
        });

        // Event delegation for delete button
        $('#tableList').on('click', '.updateBtn', async function() {
            let ship_id = $(this).data('id');
            $('#modelConfirm').removeClass('hidden').data('shipId', ship_id);
        });
        // Update Model Event
        $('#modelConfirm').on('click', '.updateModel', function() {
            let ship_id = $('#modelConfirm').data('shipId');
            let updateType = $(this).attr('id');
            $('#modelConfirm').addClass('hidden');
            window.location.href = `/dashboard/ship-list/${ship_id}/${updateType}`;
        });
        // Event delegation for close button
        $('#closeModel').on('click', function() {
            $('#modelConfirm').addClass('hidden');
        });
    });
</script>

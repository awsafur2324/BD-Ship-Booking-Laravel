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
                            <th class="border border-gray-200 px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList" class="bg-white"></tbody>
                </table>
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
                                Add Day
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
            window.location.href = `/dashboard/add-day/${ship_id}`;
        });
    });
</script>
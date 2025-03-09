<div class="container mx-auto px-2">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="shadow-lg p-5 bg-white rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex-1">
                        <h4 class="text-black text-center font-bold text-2xl">Discount Manager</h4>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full pt-3 table-auto border-collapse" id="tableData">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">No</th>
                                <th class="border border-gray-200 px-4 py-2">Image</th>
                                <th class="border border-gray-200 px-4 py-2">Title</th>
                                <th class="border border-gray-200 px-4 py-2">Coupon Code</th>
                                <th class="border border-gray-200 px-4 py-2">Start Date</th>
                                <th class="border border-gray-200 px-4 py-2">Finish Date</th>
                                <th class="border border-gray-200 px-4 py-2">Percentage</th>
                                <th class="border border-gray-200 px-4 py-2">Status</th>
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
                const res = await axios.get('/api/discount-list');
                const tableList = $("#tableList");
                const tableData = $("#tableData");

                // Destroy DataTable if it already exists
                if ($.fn.DataTable.isDataTable('#tableData')) {
                    tableData.DataTable().destroy();
                }
                tableList.empty();

                const responseData = res.data;
                if (!responseData.success || !Array.isArray(responseData.data) || responseData.data
                    .length === 0) {
                    tableList.append(`
                    <tr>
                        <td colspan="9" class="text-center font-bold text-red-500">No Added Discounts Found</td>
                    </tr>
                `);
                    return;
                }

                const data = responseData.data;

                data.forEach((discount, index) => {
                    const formatDate = (dateString) => {
                        const options = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        return new Date(dateString).toLocaleDateString('en-US', options);
                    };

                    const row = `
                    <tr>
                        <td class="border border-gray-200 px-4 py-2 text-center">${index + 1}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">
                            <img src="${discount.discountImg || '/default-image.jpg'}" alt="Discount Image" class="h-12 w-12 rounded-md object-cover">
                        </td>
                        <td class="border border-gray-200 px-4 py-2">${discount.discount_title}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">${discount.coupon_code}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">${formatDate(discount.startDate)}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">${formatDate(discount.finishDate)}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">${discount.discount_percentage}%</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">${discount.discount_status}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center ${discount.discount_status === 'active'? 'flex flex-wrap justify-center items-center gap-2' : ''}">
                            <button 
                                class="text-white bg-blue-500 px-3 py-1 rounded hover:bg-blue-600 edit-discount" 
                                data-id="${discount.id}">Edit</button>
                            ${discount.discount_status === 'active' ? 
                                `<button 
                                    class="text-white bg-red-500 px-3 py-1 rounded hover:bg-red-600 ml-2 inactive-discount" 
                                    data-id="${discount.id}">Inactive</button>` : ''}
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
                        [0, 'asc']
                    ],
                    lengthMenu: [5, 10, 15, 20],
                    paging: true,
                    searching: true,
                    language: {
                        paginate: {
                            next: 'Next →',
                            previous: '← Previous'
                        },
                        search: 'Search:',
                        lengthMenu: 'Show _MENU_ entries',
                        zeroRecords: 'No matching records found',
                    },
                });

                // Add event listeners for Edit and Inactive buttons
                $(".edit-discount").on("click", function() {
                    const id = $(this).data("id");
                    handleEditDiscount(id);
                });

                $(".inactive-discount").on("click", function() {
                    const id = $(this).data("id");
                    handleInactiveDiscount(id);
                });
            } catch (error) {
                console.error("Error loading data:", error);
            }
        }

        // Handle Edit Discount
        async function handleEditDiscount(id) {
            try {
                // Redirect to an edit page or open a modal (customize as needed)
                window.location.href = `/discount/edit/${id}`;
            } catch (error) {
                console.error("Error editing discount:", error);
            }
        }

        // Handle Inactive Discount
        async function handleInactiveDiscount(id) {
            try {
                
                const res = await axios.post('/api/discount/inactive', {
                    id
                });
                if (res.data.success) {
                    successToast("Discount marked as inactive successfully!");
                    loadData(); // Reload table
                } else {
                    errorToast("Failed to mark discount as inactive!");
                }
            } catch (error) {
                console.error("Error marking discount as inactive:", error);
            }
        }
    });
</script>

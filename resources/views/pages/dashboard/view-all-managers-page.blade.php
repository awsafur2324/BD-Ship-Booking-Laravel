@extends('layouts.dashboard_layout')
@section('content')
    <div class="">
        <div class="container mx-auto px-2 ">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <div class="shadow-lg p-5 bg-white rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex-1">
                                <h4 class="text-black text-center font-bold text-2xl">View All Manager</h4>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full pt-3 table-auto border-collapse " id="tableData">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">No</th>
                                        <th class="border border-gray-200 px-4 py-2">Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Phone no</th>
                                        <th class="border border-gray-200 px-4 py-2">Role</th>
                                        <th class="border border-gray-200 px-4 py-2">Email Status</th>
                                        <th class="border border-gray-200 px-4 py-2 text-center">Status</th>
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
    </div>
    <script>
        $(document).ready(function () {
            loadData();
    
            async function loadData() {
                try {
                    const res = await axios.get('/api/view-all-managers');
      
                    let tableList = $("#tableList");
                    let tableData = $("#tableData");
    
                    // Destroy DataTable if it already exists
                    if ($.fn.DataTable.isDataTable('#tableData')) {
                        tableData.DataTable().destroy();
                    }
                    tableList.empty();
    
                    let data = res.data.data;
                    if (data.length === 0) {
                        tableList.append(`
                            <tr>
                                <td colspan="6" class="text-center text-gray-500">No data found</td>
                            </tr>
                        `);
                        return;
                    }
    
                    data.forEach((user, index) => {
                        let row = `
                            <tr data-user-id="${user.id}">
                                 <td class="border border-gray-200 px-4 py-2">${index + 1}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.name}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.phone}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.role}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.email_verified === "true" ? 'Verified' : 'Not Verified'}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.manager_status}</td>
                                 <td class="border border-gray-200 px-4 py-2">
                                    ${
                                        user.manager_status === 'active'
                                            ? `<button data-id="${user.id}" class="inactive-btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Inactive
                                               </button>`
                                            : `<button data-id="${user.id}" class="active-btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                active
                                               </button>`
                                    }
                                </td>
                            </tr>
                        `;
                        tableList.append(row);
                    });
    
                    // Initialize DataTable
                    new DataTable('#tableData', {
                        responsive: true,
                        autoWidth: false,
                        order: [[0, 'desc']],
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
    
                    // Attach click event to Request buttons
                    $(".inactive-btn").on("click", async function () {
                  
                        try {
                            const userId = $(this).data("id");
                            const response = await axios.post('/api/rejectManagerRequest',{
                                user_id: userId,
                            });
                            if (response.data.success) {
                                successToast('Remove from manager list successfully!');
                                loadData(); // Reload the table
                            } else {
                                errorToast('Failed to send the request. Try again.');
                            }
                        } catch (error) {
                            errorToast('An error occurred. Please try again.');
                        }
                    });
                    $(".active-btn").on("click", async function () {
                  
                        try {
                            const userId = $(this).data("id");
                            const response = await axios.post('/api/acceptManagerRequest',{
                                user_id: userId,
                            });
                            if (response.data.success) {
                                successToast('Added to manager list successfully!');
                                loadData(); // Reload the table
                            } else {
                                errorToast('Failed to send the request. Try again.');
                            }
                        } catch (error) {
                            errorToast('An error occurred. Please try again.');
                        }
                    });
                } catch (error) {
                    console.error("Error loading data:", error);
                }
            }
        });
    </script>
@endsection

<div class="mt-10">
    <h1 id="ship_id" class="hidden">{{ $data->id }}</h1>
    <div class="-mx-3 flex flex-wrap ">
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="ship_name" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Ship Name
                </label>
                <input type="text" name="ship_name" id="ship_name" value="{{ $data->ship_name ?? '' }}"
                    placeholder="E.g. Sundorban Express" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="couch_no" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Couch No
                </label>
                <input type="text" name="couch_no" id="couch_no" value="{{ $data->couch_no ?? '' }}"
                    placeholder="E.g. SE-1234" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3">
            <div class="mb-5">
                <label for="ship_register_no" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Ship Register No (IMO)
                </label>
                <input type="text" name="ship_register_no" id="ship_register_no"
                    value="{{ $data->ship_register_no ?? '' }}" placeholder="E.g. Dha-1234567" required readonly
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="manager_name" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Ship Manager Name
                </label>
                <input type="text" name="manager_name" id="manager_name" value="{{ $data->ship_manager_name ?? '' }}"
                    placeholder="Enter manager name" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="manager_number" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Ship Manager Number
                </label>
                <input type="tel" name="manager_number" id="manager_number"
                    value="{{ $data->ship_manager_number ?? '' }}" placeholder="E.g. 01644453394" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
    </div>
    <div class="w-full mt-10 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
        {{-- Submit button --}}
        <button type="submit" id="btn_submit"
            class="rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
            <span
                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
            <span class="relative">Update Details</span>
        </button>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#btn_submit').click(async function(event) {
        event.preventDefault();  // Prevent form submission to handle validation

        // Check if any required field is empty
        let isValid = true;
        $('input[required]').each(function() {
            if ($(this).val() === "") {
                isValid = false;
                $(this).addClass('border-red-500');  // Highlight the empty fields
                $(this).after('<p class="text-red-500 text-sm">This field is required.</p>');  // Show error message
            } else {
                $(this).removeClass('border-red-500');  // Remove highlight if field is filled
                $(this).next('p').remove();  // Remove the error message
            }
        });

        // If any field is empty, prevent form submission
        if (!isValid) {
            errorToast("Please fill all required fields.");
            return;  // Stop form submission if validation fails
        }

        // Collect the form data
        const formData = new FormData();
        formData.append('ship_id', $('#ship_id').text().trim());
        formData.append('ship_name', $('#ship_name').val());
        formData.append('couch_no', $('#couch_no').val());
        formData.append('ship_register_no', $('#ship_register_no').val());  // Read-only, may not be changed
        formData.append('manager_name', $('#manager_name').val());
        formData.append('manager_number', $('#manager_number').val());

        try {
            // Send the form data to the backend
            const res = await axios.post('/api/update-ship-details', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',  // Important for file uploads
                },
            });

            if (res.data.success) {
                successToast('Ship details updated successfully!');
                setTimeout(() => {
                    window.location.href = '/dashboard/ship-list';
                }, 1000);
            } else {
                errorToast('Failed to update ship details.');
            }
        } catch (error) {
            errorToast('An error occurred. Please try again.');
            console.error(error);
        }
    });
});

</script>

<div class="">
    <h1 class="text-lg sm:text-3xl font-bold text-[#07074D] text-center mt-5">Discount Form</h1>
    <div class="mx-auto w-36 border-b-2 border-[#7D7D7D] mb-10 mt-2"></div>

    {{-- form --}}
    <div id="discount-form" class="">
        <div class="-mx-3 flex flex-wrap ">
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="discount_title" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Discount Title<sup>*</sup>
                    </label>
                    <input type="text" name="discount_title" id="discount_title"
                        placeholder="E.g. Eid Offers 20% off on all flights"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="coupon_code" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Coupon Code<sup>*</sup>
                    </label>
                    <input type="text" name="coupon_code" id="coupon_code" placeholder="E.g. Eid20"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="start_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Start Date<sup>*</sup>
                    </label>
                    <input type="date" name="start_date" id="start_date" placeholder="E.g. Dhaka"
                        class="w-full date-input rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="finish_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Finish Date<sup>*</sup>
                    </label>
                    <input type="date" name="finish_date" id="finish_date" placeholder="E.g. Dhaka"
                        class="w-full date-input rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="discount_percentage" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Discount Percentage<sup>*</sup>
                    </label>
                    <input type="number" name="discount_percentage" id="discount_percentage" placeholder="E.g. 20"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <div class="mb-5">
                    <label for="discount_img" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Discount Background Image<sup>*</sup>
                    </label>
                    <input type="file" name="discount_img" id="discount_img" accept="image/*"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3">
                <div class="mb-5">
                    <label for="discount_description" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Discount Description
                    </label>
                    <textarea name="discount_description" id="discount_description"
                        placeholder="E.g. Get 20% off on all flights on 2022-01-01 to 2022-12-31"
                        class="w-full h-40 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- button --}}
<div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
    <button id="add_discount_btn"
        class="rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
        <span
            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
        <span class="relative">Add Discount</span>
    </button>
</div>

<script>
    $(document).ready(function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is zero-indexed
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        // Set minimum date for all date inputs
        $('.date-input').attr('min', minDate);

        // Add event listener to add discount button
        $('#add_discount_btn').on('click', async function(event) {
            event.preventDefault(); // Prevent form submission

            // Collect form data
            const formData = new FormData();
            formData.append('discount_title', $('#discount_title').val().trim());
            formData.append('coupon_code', $('#coupon_code').val().trim());
            formData.append('startDate', $('#start_date').val().trim());
            formData.append('finishDate', $('#finish_date').val().trim());
            formData.append('discount_percentage', $('#discount_percentage').val().trim());
            formData.append('discount_img', $('#discount_img')[0].files[0]); // Append the file
            formData.append('discount_description', $('#discount_description').val().trim());

            // Validation checks
            if (!formData.get('discount_title')) {
                errorToast('Please enter a discount title.');
                return;
            }
            if (!formData.get('coupon_code')) {
                errorToast('Please enter a discount code.');
                return;
            }
            if (!formData.get('startDate')) {
                errorToast('Please enter a discount Start Date.');
                return;
            }
            if (!formData.get('finishDate')) {
                errorToast('Please enter a discount Finish Date.');
                return;
            }
            if (!formData.get('discount_percentage')) {
                errorToast('Please enter a discount percentage.');
                return;
            }

            // check the start date is before the finish date
            const startDate = new Date(formData.get('startDate'));
            const finishDate = new Date(formData.get('finishDate'));
            if (startDate > finishDate) {
                errorToast('Start date must be before finish date.');
                return;
            }

            // Send data to server
            showLoader();
            try {
                const res = await axios.post('/api/discount', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                hideLoader();
                // Handle response
                if (res.data.success) {
                    successToast(res.data.message || 'Discount added successfully.');
                    setTimeout(() => {
                        $('#discount-form input, #discount-form textarea').val('');
                    }, 1000);
                } else {
                    errorToast(res.data.message || 'Failed to add discount.');
                }
            } catch (error) {
                hideLoader();
                errorToast('An error occurred. Please try again.');
                console.log(error);
            }
        });
    });
</script>

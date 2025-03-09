<div class="">
    <div id="refund-policy" class="refund-policy-class -mx-3 flex flex-wrap ">
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="refund_category" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Select a Refund Policy
                </label>
                <select name="refund_category" id="refund_category" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option value="Full">Full Refund</option>
                    <option value="Half">Half Refund</option>
                </select>
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="refund_time" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Enter Refund Days
                    <span class="text-xs text-[#6A64F1]">(Before the ship Departure time)</span>
                </label>
                <input type="number" name="refund_time" id="refund_time" placeholder="Enter the number of days(e.g. 2)" required
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
    </div>
</div>
{{-- Add another refund button  --}}
<button id="add-refund-policy"
    class="relative items-center justify-start inline-block px-8 py-3 overflow-hidden font-medium transition-all bg-blue-600 rounded-md hover:bg-white group">
    <span
        class="absolute inset-0 border-0 group-hover:border-[25px] ease-linear duration-100 transition-all border-white rounded-md"></span>
    <span
        class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-blue-600">
        Add Another Refund Policy +</span>
</button>

{{-- <button id="submit" type="submit">Submit</button> --}}

<script>
    let refundCount = 1; // Tracks the number of refund sections
    const refundPolicy = $('#refund-policy');

    $('#add-refund-policy').on('click', function(e) {
        e.preventDefault();
        if (refundCount < 2) {
            const newRefund = refundPolicy.clone(); // Clone the refund section

            // Update IDs and reset input/select values
            newRefund.find('select[name="refund_category"]').attr('id', `refund_category_${refundCount}`).val(
                '');
            newRefund.find('input[name="refund_time"]').attr('id', `refund_time_${refundCount}`).val('');

            // Update the cloned section's class for easier identification
            newRefund.removeAttr('id').addClass(`refund-policy-${refundCount}`);

            refundPolicy.parent().append(newRefund); // Append the cloned section
            refundCount++;
        } else {
            errorToast("Refund policy limit reached");
        }
    });

    function getRefundPolicyData() {
        const formData = [];
        let hasDuplicates = false;

        // Iterate through each refund-policy section
        $('.refund-policy-class').each(function() {
            const refund_category = $(this).find('select[name="refund_category"]').val();
            const refund_time = $(this).find('input[name="refund_time"]').val();

            if (formData.some(data => data.refund_category === refund_category || data.refund_time ===
                    refund_time)) {
                hasDuplicates = true; // Duplicate refund policy detected
            }

            formData.push({
                refund_category: refund_category,
                refund_time: refund_time,
            });
        });

        if (hasDuplicates) {
            errorToast("There are duplicate refund policies. Please change one.");
        } else {
            return formData;
        }
    };
</script>

<div id="refund-policies-container">
    @if (!empty($data))
        @foreach ($data as $index => $policy)
            <div id="refund-policy-{{ $index }}" class="refund-policy-class relative -mx-3 flex flex-wrap">
                <!-- Hidden Inputs -->
                <input type="hidden" name="policy_ids[]" value="{{ $policy['id'] }}">

                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="refund_category_{{ $index }}"
                            class="mb-3 block text-base font-semibold text-[#07074D]">
                            Select a Refund Policy
                        </label>
                        <select name="refund_category[]" id="refund_category_{{ $index }}" required
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md">
                            <option value="Full" {{ $policy['refund_category'] == 'Full' ? 'selected' : '' }}>Full
                                Refund</option>
                            <option value="Half" {{ $policy['refund_category'] == 'Half' ? 'selected' : '' }}>Half
                                Refund</option>
                        </select>
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="refund_time_{{ $index }}"
                            class="mb-3 block text-base font-semibold text-[#07074D]">
                            Enter Refund Days
                            <span class="text-xs text-[#6A64F1]">(Before the ship Departure time)</span>
                        </label>
                        <input type="number" name="refund_time[]" id="refund_time_{{ $index }}" required
                            placeholder="Enter the number of days(e.g. 2)" value="{{ $policy['refund_time'] }}"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <!-- Empty state with one refund policy -->
        <div id="refund-policy-0" class="refund-policy-class relative -mx-3 flex flex-wrap">
            <input type="hidden" name="policy_ids[]" value="">
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="refund_category_0" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Select a Refund Policy
                    </label>
                    <select name="refund_category[]" id="refund_category_0" required
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="Full">Full Refund</option>
                        <option value="Half">Half Refund</option>
                    </select>
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="refund_time_0" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Enter Refund Days
                        <span class="text-xs text-[#6A64F1]">(Before the ship Departure time)</span>
                    </label>
                    <input type="number" name="refund_time[]" id="refund_time_0" required
                        placeholder="Enter the number of days(e.g. 2)"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Add another refund policy button -->
<button id="add-refund-policy"
    class="relative inline-block px-8 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
    Add Another Refund Policy +
</button>

<div class="mt-10 flex justify-center">
    <button type="submit" id="btn_submit" class="px-10 py-3 bg-green-500 text-white rounded-md hover:bg-green-600">
        Update Refund Policies
    </button>
</div>

<script>
    $(document).ready(function() {
        let refundCount = $(".refund-policy-class").length;
        const path = window.location.pathname;
        // Split the path by slashes
        const segments = path.split('/');
        // Extract the shipDetails_id (it's the 3rd segment in this example)
        const shipDetailsId = segments[segments.length - 2];

        // Add a new refund policy
        $('#add-refund-policy').on('click', function(e) {
            e.preventDefault();
            const newIndex = refundCount;

            const newRefundHTML = `
                <div id="refund-policy-${newIndex}" class="refund-policy-class relative -mx-3 flex flex-wrap">
                    <input type="hidden" name="policy_ids[]" value="">

                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="refund_category_${newIndex}" class="mb-3 block text-base font-semibold text-[#07074D]">
                                Select a Refund Policy
                            </label>
                            <select name="refund_category[]" id="refund_category_${newIndex}" required
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="Full">Full Refund</option>
                                <option value="Half">Half Refund</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="refund_time_${newIndex}" class="mb-3 block text-base font-semibold text-[#07074D]">
                                Enter Refund Days
                                <span class="text-xs text-[#6A64F1]">(Before the ship Departure time)</span>
                            </label>
                            <input type="number" name="refund_time[]" id="refund_time_${newIndex}" required
                                placeholder="Enter the number of days(e.g. 2)"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                </div>
            `;

            $('#refund-policies-container').append(newRefundHTML);
            refundCount++;
        });

        // Handle form submission
        $('#btn_submit').on('click', async function(e) {
            e.preventDefault();

            const refundPolicies = [];
            let duplicateFound = false;

            $(".refund-policy-class").each(function() {
                const id = $(this).find("input[name='policy_ids[]']").val();
                const refundCategory = $(this).find("select[name='refund_category[]']").val();
                const refundTime = $(this).find("input[name='refund_time[]']").val();

                // Check for duplicates based on refund category and refund time
                if (refundPolicies.some(policy => policy.refundCategory === refundCategory ||
                        policy.refundTime === refundTime)) {
                    duplicateFound = true;
                    $(this).addClass('bg-red-100'); // Highlight the duplicate section
                } else {
                    refundPolicies.push({
                        id,
                        refundCategory,
                        refundTime,
                        shipDetailsId
                    });
                }
            });

            if (duplicateFound) {
                errorToast("Duplicate refund policies detected! Please check the fields.");
                return; // Prevent form submission
            }

            const res = await axios.post('/api/refund-policies/update', {
                refundPolicies
            });
       
            if (res.data.success) {
                successToast("Refund policies updated successfully!");
                setTimeout(() => {
                    window.location.href = `/dashboard/ship-list`;
                }, 1000);
            } else {
                errorToast("Failed to update refund policies!");
            }
        });
    });
</script>

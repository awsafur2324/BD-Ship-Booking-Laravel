<h1 class="text-4xl font-bold text-center text-[#38c768] mt-10">Profile Manager</h1>
<div class="mx-auto w-36 border-b-2 border-[#7D7D7D] mb-10"></div>
<div class="w-full flex items-center justify-center px-2">
    <div class="mx-auto w-full">
        <div id="form">
            <div class="-mx-3 flex flex-wrap">
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                            Full Name
                        </label>
                        <input type="text" name="name" value="{{ $user->name }}" id="name"
                            placeholder="Full Name"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ $user->email }}" disabled id="email"
                            placeholder="Enter your email"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
            </div>
            <div class="-mx-3 flex flex-wrap">
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">
                            Phone Number
                        </label>
                        <input type="text" name="phone" id="phone" placeholder="Enter your phone number"
                            value="{{ $user->phone }}"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                            Gender
                        </label>
                        <select name="gender" id="gender"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5 pt-3">
                <label class="mb-5 block text-base font-medium text-[#07074D] ">
                    Address Details
                </label>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3">
                        <div class="mb-5">
                            <input type="text" name="address" id="address" placeholder="Enter Full Address number"
                                value="{{ $user->address }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <input type="text" name="city" id="city" placeholder="Enter city"
                                value="{{ $user->city }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <input type="text" name="country" id="country" placeholder="Enter Country"
                                value="{{ $user->country }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">
                    Update Profile Picture
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
            @if ($user->image_Url)
                <div class="mb-5">
                    <img src="{{ $user->image_Url }}" alt="" class="w-52 h-52 object-cover rounded-full">
                </div>
            @endif
            <div>
                <button id="form-submit"
                    class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                    Confirm Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // On form submit
        $("#form-submit").on("click", async function(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            showLoader();
            // Collect the form data
            var formData = new FormData();
            formData.append("name", $("#name").val());
            formData.append("email", $("#email").val());
            formData.append("phone", $("#phone").val());
            formData.append("gender", $("#gender").val());
            formData.append("address", $("#address").val());
            formData.append("city", $("#city").val());
            formData.append("country", $("#country").val());
            formData.append("image", $("#image")[0].files[0]);

            try {
                const res = await axios.post('/api/updateProfile', formData);

                if (res.data.message) {
                    successToast(res.data.message);
                    hideLoader();
                    setTimeout(() => {
                        window.location.href = "/dashboard/profile";
                    }, 1000);
                }
            } catch (error) {
                errorToast(error.response?.data?.message || 'An error occurred. Please try again.');
            }

        });
    });
</script>

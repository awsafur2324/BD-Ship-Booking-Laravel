<div class="w-full h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-200 w-96 h-auto rounded-lg pt-8 pb-8 px-8 flex flex-col items-center">
        <label class="font-light text-3xl mb-4">Forget <span class="font-bold">Password</span></label>
        <input type="email" id="email" class="w-full h-12 rounded-lg px-4 text-base focus:ring-blue-600 mb-4"
            placeholder="Email" />
        <button onclick="submitForgetPass()"
            class="w-full h-12 rounded-lg bg-blue-600 text-gray-200 uppercase font-semibold hover:bg-blue-700 transition mb-4">Send</button>

    </div>
</div>

<script>
    async function submitForgetPass() {
        const email = $('#email').val();
        if (email.length === 0) {
            errorToast("Email is required");
        } else {
            showLoader(); //--check config.js file
            const response = await axios.post('/api/forgotPassword', {
                email: email
            });
            hideLoader();
            if (response.data.status == 'success') {
                successToast(response.data.message);
                setTimeout(function() {
                    // After log in redirect to current page where it's redirect to log in page
                    window.location.href = "/forgotPassword-otpVerify";
                }, 1000)
            } else {
                errorToast(response.data.message);
            }
        }
    }
</script>

<div class="w-full h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-200 w-96 h-auto rounded-lg pt-8 pb-8 px-8 flex flex-col items-center">
        <label class="font-light text-3xl mb-4">Verify <span class="font-bold">OTP</span></label>
        <input type="text" id="otp" class="w-full h-12 rounded-lg px-4 text-base focus:ring-blue-600 mb-4"
            placeholder="Enter 4 digit code" />
        <button onclick="submitOTP()"
            class="w-full h-12 rounded-lg bg-blue-600 text-gray-200 uppercase font-semibold hover:bg-blue-700 transition mb-4">Verify</button>
        <p class="text-left mb-4 w-full text-black text-base ">If otp not sent then <a
                href="{{ url('/forgotPassword') }}" class="text-blue-600">Click Here</a></p>
    </div>
</div>

<script>
    async function submitOTP() {
        const otp = $('#otp').val();

        if (otp.length!= 4) {
            errorToast('Please enter 4 digit code');
            return;
        }
        else{
            showLoader();
            const res = await axios.post('/api/forgotPasswordOtp', {
                otp: otp
            });
            hideLoader();
            if (res.data.status =='success') {
                successToast('OTP verified successfully');
                setTimeout(() => {
                    window.location.href = '/resetPassword';
                }, 1000);
            }
            else {
                errorToast(res.data.message);
            }
        }
    }
</script>

<div class="w-full h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-200 w-96 h-auto rounded-lg pt-8 pb-8 px-8 flex flex-col items-center">
        <label class="font-light text-4xl mb-4"><span class="font-bold">Register Form</span></label>
        <input type="text" id="name" class="w-full h-12 rounded-lg px-4 text-sm focus:ring-blue-600 mb-4"
            placeholder="Full Name" />
        <input type="email" id="email" class="w-full h-12 rounded-lg px-4 text-sm focus:ring-blue-600 mb-4"
            placeholder="Email" />
        <input type="tel" id="phone" class="w-full h-12 rounded-lg px-4 text-sm focus:ring-blue-600 mb-4"
            placeholder="Phone" />

        <div class="relative w-full">
            <input id="password" type="password" class="w-full h-12 rounded-lg px-4 text-sm focus:ring-blue-600 mb-4"
                placeholder="Password" />
            <div
                class="flex absolute text-gray-400 right-0 -top-2 h-full w-12 items-center justify-center text-sm cursor-pointer">
                <i id="show-password" class="fas fa-eye "></i>
                <i id="hide-password" class="fas fa-eye-slash hidden"></i>
            </div>
        </div>
        <button type="submit" onclick="register()"
            class="w-full h-12 rounded-lg bg-blue-600 text-gray-200 uppercase font-semibold hover:bg-blue-700 transition mb-4">Sign
            Up</button>
        <div class="">Already have an account? Then <a href="{{ url('/login') }}" class="text-blue-600">Log in</a>
        </div>
    </div>
</div>

<script>
    $('#show-password').click(function() {
        $('#password').attr('type', 'text');
        $('#show-password').addClass('hidden');
        $('#hide-password').removeClass('hidden');
    });

    $('#hide-password').click(function() {
        $('#password').attr('type', 'password');
        $('#show-password').removeClass('hidden');
        $('#hide-password').addClass('hidden');
    });

    async function register() {
        const name = $('#name').val();
        const email = $('#email').val();
        const phone = $('#phone').val();
        const password = $('#password').val();

        // Simple client-side validation (optional)
        if (!name || !email || !phone || !password) {
            errorToast("All fields are required.");
        }
        // Example: Sending data to the backend using Axios
        else {
            showLoader();
            const res = await axios.post('/api/register', {
                name,
                email,
                phone,
                password,
            });
            hideLoader();
            if (res.data.status == 'success') {
                successToast(res.data.message);
                setTimeout(() => {
                    window.location.href = '/register-otpVerify';
                }, 1000);
            } else {
                errorToast(res.data.message);
            }
        }

    }
</script>

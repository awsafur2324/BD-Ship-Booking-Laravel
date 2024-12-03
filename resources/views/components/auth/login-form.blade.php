<div class="w-full h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-200 w-96 h-auto rounded-lg pt-8 pb-8 px-8 flex flex-col items-center">
        <label class="font-light text-4xl mb-4">Log<span class="font-bold">In</span></label>
        <input type="text" class="w-full h-12 rounded-lg px-4 text-lg focus:ring-blue-600 mb-4" placeholder="Email" />
        <div class="relative w-full">
            <input id="password" type="password" class="w-full h-12 rounded-lg px-4 text-lg focus:ring-blue-600 mb-4"
                placeholder="Password" />
            <div
                class="flex absolute text-gray-400 right-0 -top-2 h-full w-12 items-center justify-center text-lg cursor-pointer">
                <i id="show-password" class="fas fa-eye "></i>
                <i id="hide-password" class="fas fa-eye-slash hidden"></i>
            </div>
        </div>
        <button
            class="w-full h-12 rounded-lg bg-blue-600 text-gray-200 uppercase font-semibold hover:bg-blue-700 transition mb-4">Login</button>
        <p class="text-right mb-4 w-full">Forgot password</p>
        <div class="">Don't have an account? Then <a href="/register" class="text-blue-600">Register</a></div>
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
</script>
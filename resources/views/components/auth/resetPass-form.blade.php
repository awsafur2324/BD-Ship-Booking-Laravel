<div class="w-full h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-200 w-96 h-auto rounded-lg pt-8 pb-8 px-8 flex flex-col items-center">
        <label class="font-light text-2xl mb-4">Reset<span class="font-bold"> Password</span></label>
        <div class="relative w-full">
            <input id="password" type="password" class="w-full h-12 rounded-lg px-4 text-lg focus:ring-blue-600 mb-4"
                placeholder="New Password" />
            <div
                class="flex absolute text-gray-400 right-0 -top-2 h-full w-12 items-center justify-center text-lg cursor-pointer">
                <i id="show-password" class="fas fa-eye "></i>
                <i id="hide-password" class="fas fa-eye-slash hidden"></i>
            </div>
        </div>
       <div class="relative w-full">
            <input id="Confirm-password" type="password" class="w-full h-12 rounded-lg px-4 text-lg focus:ring-blue-600 mb-4"
                placeholder="Confirm Password" />
            <div
                class="flex absolute text-gray-400 right-0 -top-2 h-full w-12 items-center justify-center text-lg cursor-pointer">
                <i id="show-password2" class="fas fa-eye "></i>
                <i id="hide-password2" class="fas fa-eye-slash hidden"></i>
            </div>
        </div>
        <button onclick="resetPass()"
            class="w-full h-12 rounded-lg bg-blue-600 text-gray-200 uppercase font-semibold hover:bg-blue-700 transition mb-4">Reset</button>
       
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
    $('#show-password2').click(function() {
        $('#Confirm-password').attr('type', 'text');
        $('#show-password2').addClass('hidden');
        $('#hide-password2').removeClass('hidden');
    });

    $('#hide-password2').click(function() {
        $('#Confirm-password').attr('type', 'password');
        $('#show-password2').removeClass('hidden');
        $('#hide-password2').addClass('hidden');
    });
async function resetPass(){
    const password = $('#password').val();
    const confirmPass = $('#Confirm-password').val();
    if(password === confirmPass){
        showLoader();
            const res = await axios.post('/api/resetPassword', {
                new_password: password
            });
            hideLoader();
            if (res.data.status =='success') {
                successToast(res.data.message);
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1000);
            }
            else {
                errorToast(res.data.message);
            }
    }
    else{
        errorToast('Confirm Password not match');
    }
}

</script>

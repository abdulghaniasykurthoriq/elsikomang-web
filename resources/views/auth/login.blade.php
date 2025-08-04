<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="Sign In|Elsikomang" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />

    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Required meta tags -->
    <title>Sign In | Elsikomang</title>
</head>

<body>
    <!-- start signin page -->
    <div class="flex flex-col items-center justify-center g-0 h-screen px-4">
        <!-- card -->
        <div class="justify-center items-center w-full bg-white rounded-md shadow lg:flex md:mt-0 max-w-md xl:p-0">
            <!-- card body -->
            <div class="p-6 w-full sm:p-8 lg:p-8">
                <div class="mb-4 text-center">
                    
                    <a class="text-indigo-600 text-2xl font-bold ">
                        
                            Elsikomang <br/> Klak Klik
                        
                        </a>
                    <!-- <p class="mb-6 mt-2">Please enter your user information.</p> -->
                </div>
                <!-- form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="inline-block mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus autocomplete="username"
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="Email address here" />
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

<!-- Password -->
<div class="mb-5">
    <label for="password" class="inline-block mb-2">Password</label>
    <div class="flex items-center border rounded focus-within:ring-1 focus-within:ring-indigo-600 overflow-hidden">
        <input type="password" id="password" name="password" required autocomplete="current-password"
            class="flex-1 px-3 py-2 border-gray-300 text-gray-900 focus:outline-none"
            placeholder="**************" />

        <button type="button" onclick="togglePassword()" class="px-3 focus:outline-none">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor"
                class="w-5 h-5 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.477 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.065 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
    @error('password')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19
                    c-4.477 0-8.268-2.943-9.542-7
                    a9.956 9.956 0 012.042-3.368
                    m2.69-2.691A9.953 9.953 0 0112 5
                    c4.477 0 8.268 2.943 9.542 7
                    a9.956 9.956 0 01-1.507 2.472
                    M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3l18 18" />`;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.477 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.065 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }
</script>



                    <!-- Remember Me -->
                    <div class="lg:flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="rememberme" name="remember"
                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2" />
                            <label class="inline-block ms-2" for="rememberme">Remember me</label>
                        </div>
                    </div>


                    

                    <!-- Button -->
                    <div class="grid">
                        <button type="submit"
                            class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            Sign in
                        </button>
                    </div>



                    <!-- Links -->
                    <div class="flex justify-between mt-4">
                        <div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-indigo-600 hover:text-indigo-800">Forgot your password?</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of signin page -->

    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Tambahkan di <head> atau sebelum </body> -->
<!-- Tambahkan di <head> atau sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "{{ session('error') }}",
    confirmButtonText: 'Tutup',
    customClass: {
        confirmButton: 'swal2-confirm custom-ok-button'
    },
    buttonsStyling: false
});
</script>

<style>
.custom-ok-button {
    background-color: #3b82f6; /* Tailwind blue-500 */
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 0.375rem;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    border: none;
    outline: none;
    transition: background-color 0.2s ease;
}

.custom-ok-button:hover {
    background-color: #2563eb; /* Tailwind blue-600 */
}

.custom-ok-button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); /* Tailwind focus ring-blue */
}
</style>

    @endif


</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico" />

    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet" href="./assets/libs/simplebar/dist/simplebar.min.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="./assets/css/theme.css">

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="Forgot Password - Dash UI" />
    <title>Forgot Password | Elsikomang</title>
</head>

<body>
    <!-- start forgot password page -->
    <div class="flex flex-col items-center justify-center g-0 h-screen px-4">
        <!-- card -->
        <div class="justify-center items-center w-full bg-white rounded-md shadow lg:flex md:mt-0 max-w-md xl:p-0">
            <!-- card body -->
            <div class="p-6 w-full sm:p-8 lg:p-8">
                <div class="mb-4 text-center">
                    <div class="mb-4 text-center">
                    
                        <a class="text-indigo-600 text-2xl font-bold ">
                            
                                Elsikomang <br/> Klak Klik
                            
                            </a>
                        <!-- <p class="mb-6 mt-2">Please enter your user information.</p> -->
                    </div>
                    <h2 class="text-lg font-semibold mb-2">Forgot your password?</h2>
                    <p class="mb-6 text-sm text-gray-600">No problem. Just enter your email address below and we will email you a password reset link that allows you to choose a new one.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="inline-block mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3" placeholder="you@example.com" />
                        @error('email')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="grid">
                        <button type="submit"
                            class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            Email Password Reset Link
                        </button>
                    </div>

                    <!-- Back to login -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of forgot password page -->

    <!-- Libs JS -->
    <script src="./assets/libs/feather-icons/dist/feather.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="./assets/js/theme.js"></script>
</body>

</html>

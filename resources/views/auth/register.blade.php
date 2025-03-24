<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="Sign Up|Elsikomang" />
    <title>Sign Up | Elsikomang</title>

    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico" />

    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet" href="./assets/libs/simplebar/dist/simplebar.min.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="./assets/css/theme.css">

</head>

<body>
    <!-- start register page -->
    <div class="flex flex-col items-center justify-center g-0 h-screen px-4">
        <!-- card -->
        <div class="justify-center items-center w-full bg-white rounded-md shadow lg:flex md:mt-0 max-w-md xl:p-0">
            <!-- card body -->
            <div class="p-6 w-full sm:p-8 lg:p-8">
                <div class="mb-4 text-center">
                    <a href="/"><img src="assets/images/brand/logo/logo-primary.svg" class="mb-1 mx-auto"
                            alt="Logo" /></a>
                    <p class="mb-6">Please enter your user information.</p>
                </div>

                <!-- Laravel Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="inline-block mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                            placeholder="Your Name" />
                        @error('name')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="inline-block mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                            placeholder="you@example.com" />
                        @error('email')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="inline-block mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                            placeholder="********" />
                        @error('password')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-5">
                        <label for="password_confirmation" class="inline-block mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                            placeholder="********" />
                        @error('password_confirmation')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="mb-5">
                        <div class="flex items-start gap-2">
                            <input type="checkbox"
                                class="mt-1 w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                id="agreeCheck" />
                            <label class="inline-block" for="agreeCheck">
                                I agree to the
                                <a href="#!" class="text-indigo-600 hover:text-indigo-800">Terms of Service</a>
                                and
                                <a href="#!" class="text-indigo-600 hover:text-indigo-800">Privacy Policy</a>.
                            </label>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="grid">
                        <button type="submit"
                            class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            Create Free Account
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="flex justify-between mt-4">
                        <div class="mb-2">
                            Already member?
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">Login</a>
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}"
                                class="text-indigo-600 hover:text-indigo-800">Forgot your password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of register page -->

    <!-- Libs JS -->
    <script src="./assets/libs/feather-icons/dist/feather.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="./assets/js/theme.js"></script>
</body>

</html>

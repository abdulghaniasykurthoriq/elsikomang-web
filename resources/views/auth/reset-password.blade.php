<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Reset Password - Elsikomang">
    <title>Reset Password | Elsikomang</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
</head>

<body class="bg-gray-50">
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <!-- Card -->
        <div class="bg-white rounded-md shadow max-w-md w-full p-6 sm:p-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="text-indigo-600 text-2xl font-bold leading-tight">
                    Elsikomang <br> Klak Klik
                </div>
                <h2 class="text-lg font-semibold mt-4">Reset Password</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Masukkan email dan password baru Anda untuk mengatur ulang akun Anda.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email"
                        class="border border-gray-300 rounded-md w-full p-2 px-3 mt-1 text-gray-900 focus:outline-none focus:ring focus:border-indigo-500"
                        value="{{ old('email', $request->email) }}" required autofocus placeholder="you@example.com">
                    @error('email')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" id="password" name="password"
                        class="border border-gray-300 rounded-md w-full p-2 px-3 mt-1 text-gray-900 focus:outline-none focus:ring focus:border-indigo-500"
                        required autocomplete="new-password" placeholder="********">
                    @error('password')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="border border-gray-300 rounded-md w-full p-2 px-3 mt-1 text-gray-900 focus:outline-none focus:ring focus:border-indigo-500"
                        required autocomplete="new-password" placeholder="********">
                    @error('password_confirmation')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="grid">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md transition duration-200">
                        Reset Password
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline text-sm">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JS (Optional) -->
    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
</body>

</html>

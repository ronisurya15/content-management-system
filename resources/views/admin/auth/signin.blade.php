<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <!-- Background tilted card -->
    <div class="relative w-[360px]">
        <div class="absolute inset-0 transform rotate-6 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl shadow-xl z-0"></div>

        <!-- Foreground card -->
        <div class="relative z-10 bg-white rounded-2xl p-8 shadow-2xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

            @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            </div>
            @endif

            @if (session('success'))
            <div class="mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <form action="{{ route('auth.authenticate') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 text-sm mb-1" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full border-b border-gray-300 outline-none py-2 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm mb-1" for="password">Password</label>
                    <input type="password" id="password" name="password" class="w-full border-b border-gray-300 outline-none py-2 focus:border-blue-500" required>
                </div>

                <div>
                    <button type="submit" class="bg-cyan-500 text-white font-semibold px-4 py-2 rounded-md hover:bg-cyan-600 transition">Login</button>
                </div>
            </form>

            <!-- Divider -->
            <!-- <div class="my-4 text-center text-gray-400 text-sm">or</div> -->

            <!-- Google Login -->
            <!-- <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-md shadow-sm hover:bg-gray-50 transition">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
                <span class="text-sm text-gray-700 font-medium">Continue with Google</span>
            </button> -->
        </div>
    </div>

</body>

</html>
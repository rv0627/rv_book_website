<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RvBooks Admin Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        laravel: '#FF2D20',
                        primary: '#3B82F6',
                    },
                }
            }
        }
    </script>

</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 font-sans">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <div class="mb-6 text-center">
            <div class="flex items-center justify-center gap-2 text-3xl font-bold text-gray-800 mb-1">
                <i class="fa-solid fa-book-open text-laravel"></i>
                <span>Rv<span class="text-laravel">Books</span> Admin</span>
            </div>
            <p class="text-sm text-gray-500">Sign in to manage the book website</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-2 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                    placeholder="admin@example.com"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                    placeholder="••••••••"
                >
            </div>

            <button
                type="submit"
                class="w-full mt-4 inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
            >
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                Login
            </button>

            <p class="mt-3 text-xs text-gray-400 text-center">
                Don't have an account?
                <a href="{{ route('admin.register') }}" class="text-blue-600 hover:underline">Register</a>
            </p>
        </form>
    </div>
</body>
</html>
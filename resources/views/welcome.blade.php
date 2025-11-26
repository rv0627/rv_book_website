<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Book Store - Home</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config for Custom Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        laravel: '#FF2D20',
                        primary: '#3B82F6',
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .book-card {
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            text-decoration: none;
            color: #374151;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }

        .pagination .active span {
            background-color: #fef2f2;
            border-color: #FF2D20;
            color: #FF2D20;
            font-weight: 600;
        }

        .pagination .disabled span {
            color: #9ca3af;
            cursor: not-allowed;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-laravel text-2xl"></i>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Rv<span class="text-laravel">Books</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-laravel font-medium">Home</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('admin.login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Admin Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-900 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-laravel bg-red-50">Home</a>
                <div class="border-t border-gray-100 my-2 pt-2">
                    <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Find Your Next <span class="text-laravel">Favorite Book</span>
            </h1>
            <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto">
                Explore our curated collection of bestsellers, classics, and hidden gems.
                Search by name to verify stock instantly.
            </p>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('home') }}" class="max-w-2xl mx-auto relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 group-focus-within:text-laravel transition-colors"></i>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    class="block w-full pl-12 pr-16 py-4 border border-gray-200 rounded-full leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-laravel focus:border-transparent transition shadow-sm"
                    placeholder="Search books by name...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-2">
                    @if($search ?? '')
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600 transition" title="Clear search">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                    <button type="submit" class="bg-gray-900 text-white p-2 rounded-full hover:bg-gray-700 transition w-10 h-10 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                @if($search ?? '')
                    Search Results for "{{ $search }}"
                @else
                    Latest Arrivals
                @endif
            </h2>
        </div>

        <!-- Book Grid -->
        @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($books as $book)
            <div class="book-card bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden relative group">
                <!-- Discount -->
                @if($book->discount_price)
                @php
                    $discountPercent = round((($book->price - $book->discount_price) / $book->price) * 100);
                @endphp
                <div class="absolute top-3 right-3 bg-laravel text-white text-xs font-bold px-2 py-1 rounded-full z-10 shadow-sm">
                    -{{ $discountPercent }}% OFF
                </div>
                @endif

                <div class="h-64 overflow-hidden relative bg-gray-100">
                    @if($book->image_path)
                        <img src="{{ asset('storage/' . $book->image_path) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <i class="fa-solid fa-book text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <a href="{{ route('books.show', $book->id) }}" class="bg-white text-gray-900 font-medium px-4 py-2 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            View Details
                        </a>
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <div class="mb-2">
                        <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">
                            {{ $book->author?->name ?? 'Unknown Author' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight group-hover:text-laravel transition-colors line-clamp-2">
                        {{ $book->title }}
                    </h3>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between">
                        <div>
                            @if($book->discount_price)
                                <span class="text-gray-400 text-sm line-through block">
                                    Rs. {{ number_format($book->price, 2) }}
                                </span>
                                <span class="text-xl font-bold text-gray-900">
                                    Rs. {{ number_format($book->discount_price, 2) }}
                                </span>
                            @else
                                <span class="text-xl font-bold text-gray-900">
                                    Rs. {{ number_format($book->price, 2) }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="text-right">
                            @if($book->stock > 0)
                                <div class="flex items-center gap-1 text-green-600 text-sm font-medium">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    In Stock
                                </div>
                                <span class="text-xs text-gray-500">({{ $book->stock }} available)</span>
                            @else
                                <div class="flex items-center gap-1 text-red-500 text-sm font-medium">
                                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                    Out of Stock
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $books->links() }}
        </div>
        @endif
        @else
        <!-- No Results State -->
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <i class="fa-solid fa-book-open text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No books found</h3>
            <p class="text-gray-500 mt-1">
                @if($search ?? '')
                    We couldn't find any books matching "{{ $search }}".
                @else
                    No books available at the moment.
                @endif
            </p>
            @if($search ?? '')
            <a href="{{ route('home') }}" class="mt-4 inline-block text-laravel font-medium hover:text-red-700">
                Clear search
            </a>
            @endif
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-book-open text-laravel text-xl"></i>
                        <span class="font-bold text-lg text-gray-900">Rv<span class="text-laravel">Books</span></span>
                    </div>
                    <p class="text-sm text-gray-500">
                        A modern bookstore. Quality books, great prices.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">All Books</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">New Arrivals</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">FAQ</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">Shipping</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-laravel text-sm">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Stay Updated</h3>
                    <div class="flex">
                        <input type="email" placeholder="Enter your email" class="flex-1 min-w-0 px-3 py-2 text-sm border border-gray-300 rounded-l-md focus:ring-laravel focus:border-laravel focus:outline-none">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-laravel hover:bg-red-700">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8 text-center text-sm text-gray-400">
                &copy; 2025 RvBooks Assessment. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>
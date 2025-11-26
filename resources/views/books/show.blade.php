<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - RvBooks</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-laravel text-2xl"></i>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Rv<span class="text-laravel">Books</span></span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-laravel font-medium">Home</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('admin.login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Admin Login</a>
                </div>

                <div class="flex items-center md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-900 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden md:hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-laravel bg-red-50">Home</a>
                <div class="border-t border-gray-100 my-2 pt-2">
                    <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-laravel">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900">{{ $book->title }}</li>
            </ol>
        </nav>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 flex items-center gap-2">
            <i class="fa-solid fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        @if(session('info'))
        <div class="mb-6 rounded-md bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700 flex items-center gap-2">
            <i class="fa-solid fa-info-circle"></i>
            {{ session('info') }}
        </div>
        @endif

        <!-- Book Details Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Book Image -->
                <div class="flex justify-center lg:justify-start">
                    <div class="w-full max-w-md">
                        @if($book->image_path)
                            <img src="{{ asset('storage/' . $book->image_path) }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-full rounded-lg shadow-lg object-cover">
                        @else
                            <div class="w-full aspect-[2/3] flex items-center justify-center bg-gray-200 rounded-lg">
                                <i class="fa-solid fa-book text-gray-400 text-8xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Information -->
                <div class="flex flex-col">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $book->title }}</h1>
                    
                    <div class="space-y-3 mb-6">
                        <div>
                            <span class="text-sm text-gray-500">Author:</span>
                            <span class="text-lg font-semibold text-gray-900 ml-2">{{ $book->author?->name ?? 'Unknown Author' }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Publisher:</span>
                            <span class="text-lg font-semibold text-gray-900 ml-2">{{ $book->publisher?->name ?? 'Unknown Publisher' }}</span>
                        </div>
                        @if($book->year)
                        <div>
                            <span class="text-sm text-gray-500">Year:</span>
                            <span class="text-lg font-semibold text-gray-900 ml-2">{{ $book->year }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Price Section -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-baseline gap-3">
                            @if($book->discount_price)
                                @php
                                    $discountPercent = round((($book->price - $book->discount_price) / $book->price) * 100);
                                @endphp
                                <div>
                                    <span class="text-gray-400 text-lg line-through">Rs. {{ number_format($book->price, 2) }}</span>
                                    <span class="text-3xl font-bold text-laravel ml-2">Rs. {{ number_format($book->discount_price, 2) }}</span>
                                </div>
                                <span class="bg-laravel text-white text-xs font-bold px-2 py-1 rounded-full">
                                    -{{ $discountPercent }}% OFF
                                </span>
                            @else
                                <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($book->price, 2) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($book->stock > 0)
                            <div class="flex items-center gap-2 text-green-600 font-semibold mb-4">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span>In Stock</span>
                                <span class="text-sm text-gray-500">({{ $book->stock }} available)</span>
                            </div>

                            <form action="{{ route('checkout', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-laravel hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2 shadow-lg">
                                    <i class="fa-solid fa-shopping-cart"></i>
                                    Buy Now
                                </button>
                            </form>
                        @else
                            <div class="flex items-center gap-2 text-red-600 font-semibold mb-4">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span>Out of Stock</span>
                            </div>

                            <button type="button" disabled class="w-full bg-gray-400 cursor-not-allowed text-white font-bold py-3 px-6 rounded-lg flex items-center justify-center gap-2 shadow-lg">
                                <i class="fa-solid fa-ban"></i>
                                Out of Stock
                            </button>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($book->description)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Other Books by Same Author -->
        @if($booksByAuthor->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-laravel"></i>
                Other Books by {{ $book->author?->name ?? 'This Author' }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($booksByAuthor as $relatedBook)
                <div class="book-card bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden relative group">
                    @if($relatedBook->discount_price)
                        @php
                            $discountPercent = round((($relatedBook->price - $relatedBook->discount_price) / $relatedBook->price) * 100);
                        @endphp
                        <div class="absolute top-2 right-2 bg-laravel text-white text-xs font-bold px-2 py-1 rounded-full z-10 shadow-sm">
                            -{{ $discountPercent }}% OFF
                        </div>
                    @endif

                    <a href="{{ route('books.show', $relatedBook->id) }}">
                        <div class="h-48 overflow-hidden relative bg-gray-100">
                            @if($relatedBook->image_path)
                                <img src="{{ asset('storage/' . $relatedBook->image_path) }}" 
                                     alt="{{ $relatedBook->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <i class="fa-solid fa-book text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4 flex flex-col flex-grow">
                        <div class="mb-1">
                            <span class="text-xs text-gray-500">{{ $relatedBook->publisher?->name ?? 'Unknown' }}</span>
                        </div>
                        <a href="{{ route('books.show', $relatedBook->id) }}" class="mb-2">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-laravel transition-colors line-clamp-2">
                                {{ $relatedBook->title }}
                            </h3>
                        </a>
                        
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <div class="flex items-end justify-between">
                                <div>
                                    @if($relatedBook->discount_price)
                                        <span class="text-gray-400 text-xs line-through block">Rs.{{ number_format($relatedBook->price, 2) }}</span>
                                        <span class="text-lg font-bold text-gray-900">Rs.{{ number_format($relatedBook->discount_price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">Rs.{{ number_format($relatedBook->price, 2) }}</span>
                                    @endif
                                </div>
                                
                                <div class="text-right">
                                    @if($relatedBook->stock > 0)
                                        <div class="flex items-center gap-1 text-green-600 text-xs font-medium">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                            <span>In Stock</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 text-red-500 text-xs font-medium">
                                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                                            <span>Out</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Other Books by Same Publisher -->
        @if($booksByPublisher->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-building text-laravel"></i>
                Other Books from {{ $book->publisher?->name ?? 'This Publisher' }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($booksByPublisher as $relatedBook)
                <div class="book-card bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden relative group">
                    @if($relatedBook->discount_price)
                        @php
                            $discountPercent = round((($relatedBook->price - $relatedBook->discount_price) / $relatedBook->price) * 100);
                        @endphp
                        <div class="absolute top-2 right-2 bg-laravel text-white text-xs font-bold px-2 py-1 rounded-full z-10 shadow-sm">
                            -{{ $discountPercent }}% OFF
                        </div>
                    @endif

                    <a href="{{ route('books.show', $relatedBook->id) }}">
                        <div class="h-48 overflow-hidden relative bg-gray-100">
                            @if($relatedBook->image_path)
                                <img src="{{ asset('storage/' . $relatedBook->image_path) }}" 
                                     alt="{{ $relatedBook->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <i class="fa-solid fa-book text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4 flex flex-col flex-grow">
                        <div class="mb-1">
                            <span class="text-xs text-gray-500">{{ $relatedBook->author?->name ?? 'Unknown' }}</span>
                        </div>
                        <a href="{{ route('books.show', $relatedBook->id) }}" class="mb-2">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-laravel transition-colors line-clamp-2">
                                {{ $relatedBook->title }}
                            </h3>
                        </a>
                        
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <div class="flex items-end justify-between">
                                <div>
                                    @if($relatedBook->discount_price)
                                        <span class="text-gray-400 text-xs line-through block">Rs.{{ number_format($relatedBook->price, 2) }}</span>
                                        <span class="text-lg font-bold text-gray-900">Rs.{{ number_format($relatedBook->discount_price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">Rs.{{ number_format($relatedBook->price, 2) }}</span>
                                    @endif
                                </div>
                                
                                <div class="text-right">
                                    @if($relatedBook->stock > 0)
                                        <div class="flex items-center gap-1 text-green-600 text-xs font-medium">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                            <span>In Stock</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 text-red-500 text-xs font-medium">
                                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                                            <span>Out</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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
                        A modern bookstore built for the Laravel Job Assessment. Quality books, great prices.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-laravel text-sm">All Books</a></li>
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
                &copy; 2024 RvBooks Assessment. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>


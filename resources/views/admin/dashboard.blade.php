<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RvBooks</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

<body class="min-h-screen bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-6xl mx-auto px 4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-laravel text-2xl"></i>
                    <span class="text-xl font-bold text-gray-800">Rv<span class="text-laravel">Books</span> Admin</span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-red-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
                {{ session('status') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <div class="font-semibold mb-2">Please fix the following errors:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Author -->
                <section class="bg-white rounded-lg shadow p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-blue-500"></i>
                        Add Author
                    </h2>
                    <form method="POST" action="{{ route('admin.authors.store') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio (optional)</label>
                            <textarea
                                name="bio"
                                rows="3"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"></textarea>
                        </div>
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Save Author
                        </button>
                    </form>
                </section>

                <!-- Add Publisher -->
                <section class="bg-white rounded-lg shadow p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-building-columns text-purple-500"></i>
                        Add Publisher
                    </h2>
                    <form method="POST" action="{{ route('admin.publishers.store') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Website (optional)</label>
                            <input
                                type="url"
                                name="website"
                                placeholder="https://example.com"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none">
                        </div>
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Save Publisher
                        </button>
                    </form>
                </section>

                <!-- Add Book -->
                <section class="bg-white rounded-lg shadow p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-book text-emerald-500"></i>
                        Add Book
                    </h2>
                    <form method="POST" action="{{ route('admin.books.store') }}" class="space-y-3" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                required
                                class="w-full rounded-md border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                <select
                                    name="author_id"
                                    class="w-full rounded-md border {{ $errors->has('author_id') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                    <option value="">Select author</option>
                                    @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                    @endforeach
                                </select>
                                @error('author_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                                <select
                                    name="publisher_id"
                                    class="w-full rounded-md border {{ $errors->has('publisher_id') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                    <option value="">Select publisher</option>
                                    @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                                @error('publisher_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    value="{{ old('price') }}"
                                    required
                                    class="w-full rounded-md border {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                @error('price')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Price (optional)</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="discount_price"
                                    value="{{ old('discount_price') }}"
                                    class="w-full rounded-md border {{ $errors->has('discount_price') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                @error('discount_price')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                <input
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock', 0) }}"
                                    min="0"
                                    required
                                    class="w-full rounded-md border {{ $errors->has('stock') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                @error('stock')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Year (optional)</label>
                                <input
                                    type="number"
                                    name="year"
                                    value="{{ old('year') }}"
                                    placeholder="2024"
                                    class="w-full rounded-md border {{ $errors->has('year') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                @error('year')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                            <textarea
                                name="description"
                                rows="3"
                                class="w-full rounded-md border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                            <input
                                type="file"
                                name="image"
                                accept="image/*"
                                class="w-full text-sm text-gray-700">
                            <p class="mt-1 text-xs text-gray-400">Optional. JPG, PNG, up to 2MB.</p>
                            @error('image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Save Book
                        </button>
                    </form>
                </section>
            </div>

            <!-- Recent Books -->
            <!-- Search & Tables -->
            <section class="mt-8 grid grid-cols-1 lg:grid-cols-1 gap-6">
                <!-- Authors table -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-users text-blue-500"></i>
                            Authors
                        </h2>
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <input
                                type="text"
                                name="author_search"
                                value="{{ $authorSearch ?? '' }}"
                                placeholder="Search name..."
                                class="w-32 lg:w-40 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-200 outline-none">
                            <button
                                type="submit"
                                class="rounded-md bg-blue-500 px-2 py-1 text-xs font-semibold text-white hover:bg-blue-600">
                                Search
                            </button>
                            @if($authorSearch ?? '')
                            <a href="{{ route('admin.dashboard', array_merge(request()->except(['author_search']))) }}"
                                class="rounded-md bg-gray-400 px-2 py-1 text-xs font-semibold text-white hover:bg-gray-500"
                                title="Reset search">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </form>
                    </div>
                    <div class="overflow-x-auto max-h-64">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="px-2 py-1 text-left font-medium text-gray-600">Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($authors as $author)
                                <tr>
                                    <td class="px-2 py-1">{{ $author->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-2 py-2 text-gray-400">No authors found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Publishers table -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-building text-purple-500"></i>
                            Publishers
                        </h2>
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <input
                                type="text"
                                name="publisher_search"
                                value="{{ $publisherSearch ?? '' }}"
                                placeholder="Search name..."
                                class="w-32 lg:w-40 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-purple-500 focus:ring-1 focus:ring-purple-200 outline-none">
                            <button
                                type="submit"
                                class="rounded-md bg-purple-500 px-2 py-1 text-xs font-semibold text-white hover:bg-purple-600">
                                Search
                            </button>
                            @if($publisherSearch ?? '')
                            <a href="{{ route('admin.dashboard', array_merge(request()->except(['publisher_search']))) }}"
                                class="rounded-md bg-gray-400 px-2 py-1 text-xs font-semibold text-white hover:bg-gray-500"
                                title="Reset search">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </form>
                    </div>
                    <div class="overflow-x-auto max-h-64">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="px-2 py-1 text-left font-medium text-gray-600">Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($publishers as $publisher)
                                <tr>
                                    <td class="px-2 py-1">{{ $publisher->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-2 py-2 text-gray-400">No publishers found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Books table -->
                <div class="bg-white rounded-lg shadow p-5 lg:col-span-1">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-book-open-reader text-gray-600"></i>
                            Books
                        </h2>
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <input
                                type="text"
                                name="book_search"
                                value="{{ $bookSearch ?? '' }}"
                                placeholder="Search title..."
                                class="w-32 lg:w-40 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-emerald-500 focus:ring-1 focus:ring-emerald-200 outline-none">
                            <button
                                type="submit"
                                class="rounded-md bg-emerald-500 px-2 py-1 text-xs font-semibold text-white hover:bg-emerald-600">
                                Search
                            </button>
                            @if($bookSearch ?? '')
                            <a href="{{ route('admin.dashboard', array_merge(request()->except(['book_search']))) }}"
                                class="rounded-md bg-gray-400 px-2 py-1 text-xs font-semibold text-white hover:bg-gray-500"
                                title="Reset search">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </form>
                    </div>
                    @if($books->isEmpty())
                    <p class="text-sm text-gray-500">No books found.</p>
                    @else
                    <div class="overflow-x-auto max-h-64">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Cover</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Title</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Author</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Publisher</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Price</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Stock</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Year</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($books as $book)
                                <tr>
                                    <td class="px-3 py-2">
                                        @if($book->image_path)
                                        <img src="{{ asset('storage/' . $book->image_path) }}"
                                            alt="{{ $book->title }} cover"
                                            class="h-12 w-9 object-cover rounded border border-gray-200">
                                        @else
                                        <span class="text-xs text-gray-400">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $book->title }}</td>
                                    <td class="px-3 py-2">{{ $book->author?->name ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $book->publisher?->name ?? '-' }}</td>
                                    <td class="px-3 py-2">
                                        @if($book->discount_price)
                                        <span class="text-emerald-600 font-semibold">{{ number_format($book->discount_price, 2) }}</span>
                                        <span class="text-xs text-gray-400 line-through ml-1">{{ number_format($book->price, 2) }}</span>
                                        @else
                                        <span>{{ number_format($book->price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $book->stock }}</td>
                                    <td class="px-3 py-2">{{ $book->year ?? '-' }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.books.edit', $book->id) }}"
                                            class="inline-flex items-center rounded-md bg-blue-500 px-2 py-1 text-xs font-semibold text-white hover:bg-blue-600"
                                            title="Edit book">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
            </section>
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
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - RvBooks Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-blue-600 text-2xl"></i>
                    <span class="text-xl font-bold text-gray-800">Rv<span class="text-blue-600">Books</span> Admin</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Dashboard
                    </a>
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

            <div class="bg-white rounded-lg shadow p-6 md:p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-edit text-emerald-500"></i>
                    Edit Book: {{ $book->title }}
                </h2>

                <form method="POST" action="{{ route('admin.books.update', $book->id) }}" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $book->title) }}"
                            required
                            class="w-full rounded-md border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                            <select
                                name="author_id"
                                required
                                class="w-full rounded-md border {{ $errors->has('author_id') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                <option value="">Select author</option>
                                @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
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
                                required
                                class="w-full rounded-md border {{ $errors->has('publisher_id') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                <option value="">Select publisher</option>
                                @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id) == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                value="{{ old('price', $book->price) }}"
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
                                value="{{ old('discount_price', $book->discount_price) }}"
                                class="w-full rounded-md border {{ $errors->has('discount_price') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            @error('discount_price')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input
                                type="number"
                                name="stock"
                                value="{{ old('stock', $book->stock) }}"
                                min="0"
                                required
                                class="w-full rounded-md border {{ $errors->has('stock') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                            @error('stock')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                            <input
                                type="number"
                                name="year"
                                value="{{ old('year', $book->year) }}"
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
                            rows="4"
                            class="w-full rounded-md border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                        @if($book->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $book->image_path) }}" 
                                 alt="{{ $book->title }} cover" 
                                 class="h-32 w-24 object-cover rounded border border-gray-200 mb-2">
                            <p class="text-xs text-gray-500">Current image</p>
                        </div>
                        @endif
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="w-full text-sm text-gray-700">
                        <p class="mt-1 text-xs text-gray-400">Optional. JPG, PNG, up to 2MB. Leave empty to keep current image.</p>
                        @error('image')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                            <i class="fa-solid fa-save mr-2"></i>
                            Update Book
                        </button>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center justify-center rounded-md bg-gray-500 px-6 py-2 text-sm font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>


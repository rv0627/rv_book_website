<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    // list books with search and pagination
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Book::with(['author', 'publisher']);
        
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $books = $query->latest()->paginate(8);
        
        return view('welcome', [
            'books' => $books,
            'search' => $search,
        ]);
    }

    // store book
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'discount_price' => ['nullable', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
                'author_id' => ['required', 'exists:authors,id'],
                'publisher_id' => ['required', 'exists:publishers,id'],
                'year' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:2048'],
            ], [
                'title.required' => 'The book title is required.',
                'title.max' => 'The book title cannot exceed 255 characters.',
                'price.required' => 'The price is required.',
                'price.numeric' => 'The price must be a valid number.',
                'price.min' => 'The price must be at least 0.',
                'discount_price.numeric' => 'The discount price must be a valid number.',
                'discount_price.min' => 'The discount price must be at least 0.',
                'stock.required' => 'The stock quantity is required.',
                'stock.integer' => 'The stock must be a whole number.',
                'stock.min' => 'The stock cannot be negative.',
                'author_id.required' => 'Please select an author.',
                'author_id.exists' => 'The selected author is invalid.',
                'publisher_id.required' => 'Please select a publisher.',
                'publisher_id.exists' => 'The selected publisher is invalid.',
                'year.integer' => 'The year must be a valid number.',
                'image.image' => 'The uploaded file must be an image.',
                'image.max' => 'The image size must not exceed 2MB.',
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('books', 'public');
                $data['image_path'] = $path;
            }

            Book::create($data);

            return back()->with('status', 'Book added successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create book', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return back()
                ->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    
    // display single book details
    public function show(Book $book)
    {
        $book->load(['author', 'publisher']);
        
        // Get other books by the same author
        $booksByAuthor = Book::where('author_id', $book->author_id)
            ->where('id', '!=', $book->id)
            ->with(['author', 'publisher'])
            ->latest()
            ->limit(6)
            ->get();
        
        // Get other books by the same publisher
        $booksByPublisher = Book::where('publisher_id', $book->publisher_id)
            ->where('id', '!=', $book->id)
            ->with(['author', 'publisher'])
            ->latest()
            ->limit(6)
            ->get();
        
        return view('books.show', [
            'book' => $book,
            'booksByAuthor' => $booksByAuthor,
            'booksByPublisher' => $booksByPublisher,
        ]);
    }

    // edit book
    public function edit(Book $book)
    {
        $book->load(['author', 'publisher']);
        
        $authors = \App\Models\Author::orderBy('name')->get();
        $publishers = \App\Models\Publisher::orderBy('name')->get();
        
        return view('admin.books.edit', [
            'book' => $book,
            'authors' => $authors,
            'publishers' => $publishers,
        ]);
    }

    // update book
    public function update(Request $request, Book $book)
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'discount_price' => ['nullable', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
                'author_id' => ['required', 'exists:authors,id'],
                'publisher_id' => ['required', 'exists:publishers,id'],
                'year' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:2048'],
            ], [
                'title.required' => 'The book title is required.',
                'title.max' => 'The book title cannot exceed 255 characters.',
                'price.required' => 'The price is required.',
                'price.numeric' => 'The price must be a valid number.',
                'price.min' => 'The price must be at least 0.',
                'discount_price.numeric' => 'The discount price must be a valid number.',
                'discount_price.min' => 'The discount price must be at least 0.',
                'stock.required' => 'The stock quantity is required.',
                'stock.integer' => 'The stock must be a whole number.',
                'stock.min' => 'The stock cannot be negative.',
                'author_id.required' => 'Please select an author.',
                'author_id.exists' => 'The selected author is invalid.',
                'publisher_id.required' => 'Please select a publisher.',
                'publisher_id.exists' => 'The selected publisher is invalid.',
                'year.integer' => 'The year must be a valid number.',
                'image.image' => 'The uploaded file must be an image.',
                'image.max' => 'The image size must not exceed 2MB.',
            ]);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
                    Storage::disk('public')->delete($book->image_path);
                }
                
                $path = $request->file('image')->store('books', 'public');
                $data['image_path'] = $path;
            }

            $book->update($data);

            return redirect()->route('admin.dashboard')
                ->with('status', 'Book updated successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to update book', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return back()
                ->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

}

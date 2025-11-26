<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $admin = Admin::where('email', $credentials['email'])->first();

            if ($admin && Hash::check($credentials['password'], $admin->password)) {
                $request->session()->put('admin_id', $admin->id);

                return redirect()->route('admin.dashboard');
            }

            return back()->withErrors([
                'email' => 'Invalid admin credentials.',
            ])->withInput();
        } catch (\Throwable $e) {
            Log::error('Admin login failed', ['error' => $e->getMessage()]);

            return back()
                ->withErrors(['email' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    public function create()
    {
        return view('admin.register');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $admin = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $request->session()->put('admin_id', $admin->id);

            return redirect()->route('admin.dashboard');
        } catch (\Throwable $e) {
            Log::error('Admin registration failed', ['error' => $e->getMessage()]);

            return back()
                ->withErrors(['email' => 'Could not create admin account. Please try again.'])
                ->withInput();
        }
    }


    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard(Request $request)
    {
        try {
            $authorSearch = $request->input('author_search');
            $publisherSearch = $request->input('publisher_search');
            $bookSearch = $request->input('book_search');

            $authorQuery = Author::query();
            if ($authorSearch) {
                $authorQuery->where('name', 'like', '%' . $authorSearch . '%');
            }

            $publisherQuery = Publisher::query();
            if ($publisherSearch) {
                $publisherQuery->where('name', 'like', '%' . $publisherSearch . '%');
            }

            $bookQuery = Book::with(['author', 'publisher']);
            if ($bookSearch) {
                $bookQuery->where('title', 'like', '%' . $bookSearch . '%');
            }

            return view('admin.dashboard', [
                'authors' => $authorQuery->orderBy('name')->get(),
                'publishers' => $publisherQuery->orderBy('name')->get(),
                'books' => $bookQuery->latest()->get(),
                'authorSearch' => $authorSearch,
                'publisherSearch' => $publisherSearch,
                'bookSearch' => $bookSearch,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to load admin dashboard', ['error' => $e->getMessage()]);

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Unable to load dashboard. Please log in again.']);
        }
    }
}

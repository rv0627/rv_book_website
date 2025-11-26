<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    // store author
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'bio' => ['nullable', 'string'],
            ]);

            Author::create($data);

            return back()->with('status', 'Author added.');
        } catch (\Throwable $e) {
            Log::error('Failed to create author', ['error' => $e->getMessage()]);

            return back()
                ->with('status', 'Could not add author. Please try again.')
                ->withInput();
        }
    }
}

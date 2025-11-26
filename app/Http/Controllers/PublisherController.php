<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublisherController extends Controller
{
    // store publisher
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'website' => ['nullable', 'url'],
            ]);

            Publisher::create($data);

            return back()->with('status', 'Publisher added.');
        } catch (\Throwable $e) {
            Log::error('Failed to create publisher', ['error' => $e->getMessage()]);

            return back()
                ->with('status', 'Could not add publisher. Please try again.')
                ->withInput();
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Request $request, Book $book)
    {
        // Check if book is in stock
        if ($book->stock <= 0) {
            return redirect()->route('books.show', $book->id)
                ->with('error', 'This book is currently out of stock.');
        }

        try {
            $price = $book->discount_price ?? $book->price;
            
            $priceInCents = (int)($price * 100);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => $book->title,
                            'description' => $book->author?->name ?? 'Unknown Author',
                            'images' => $book->image_path ? [asset('storage/' . $book->image_path)] : [],
                        ],
                        'unit_amount' => $priceInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success', ['book' => $book->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', ['book' => $book->id]),
                'metadata' => [
                    'book_id' => $book->id,
                ],
            ]);

            return redirect($session->url);
        } catch (ApiErrorException $e) {
            Log::error('Stripe checkout error', ['error' => $e->getMessage()]);
            
            return redirect()->route('books.show', $book->id)
                ->with('error', 'Unable to process payment. Please try again.');
        }
    }

    public function success(Request $request, Book $book)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('books.show', $book->id)
                ->with('error', 'Invalid payment session.');
        }

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Reduce stock by 1
                $book->decrement('stock');

                return redirect()->route('books.show', $book->id)
                    ->with('success', 'Payment successful! Your order has been processed.');
            }

            return redirect()->route('books.show', $book->id)
                ->with('error', 'Payment was not completed.');
        } catch (ApiErrorException $e) {
            Log::error('Stripe session retrieval error', ['error' => $e->getMessage()]);
            
            return redirect()->route('books.show', $book->id)
                ->with('error', 'Unable to verify payment. Please contact support.');
        }
    }

    public function cancel(Book $book)
    {
        return redirect()->route('books.show', $book->id)
            ->with('info', 'Payment was cancelled.');
    }
}

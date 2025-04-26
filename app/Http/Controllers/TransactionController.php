<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\CartItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indexCart()
    {
        $cart_items = CartItem::with('item')->get(); 
        $items = Item::get();
        return view('transaction.transaction', compact('cart_items','items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);
        $existingCartItem = CartItem::where('item_id', $item->id)->first();

        $newQuantity = $request->quantity + ($existingCartItem->quantity ?? 0);

        if ($newQuantity > $item->stock) {
            Session::flash('message', 'The maximum quantity for "' . $item->item_name . '" is ' . $item->stock);
            Session::flash('message_type', 'danger');
            return back();
        }

        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            CartItem::create([
                'item_id' => $item->id,
                'quantity' => $request->quantity,
            ]);
        }
        
        Session::flash('message', 'Item successfully added to cart!');
        Session::flash('message_type', 'success');

        return back();
    }

    public function updateQuantity(Request $request, $cart_item_id)
    {
        $cart_item = CartItem::findOrFail($cart_item_id);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart_item->item->stock,
        ], [
            'quantity.min' => 'The quantity must be at least 1',
            'quantity.max' => 'The maximum quantity for "' . $cart_item->item->item_name . '" is ' . $cart_item->item->stock,
        ]);
        
        $cart_item->update(['quantity' => $request->quantity]);
        
        Session::flash('message', 'Quantity updated successfully');
        Session::flash('message_type', 'success');

        return redirect()->route('cart');
    }

    public function destroy($cart_item_id)
    {
        $cart_item = CartItem::findOrFail($cart_item_id);
        $cart_item->delete();

        Session::flash('message', 'Item removed from cart');
        Session::flash('message_type', 'warning');

        return redirect()->route('cart');
    }

    public function index()
    {
        $cart_items = CartItem::with('item')->get();

        if ($cart_items->isEmpty()) {
        return redirect()->back()
            ->with('message', 'Cart is empty. Please add items before checking out.')
            ->with('message_type', 'warning');
    }

    
        
        $total = $cart_items->sum(fn($item) => $item->quantity * $item->item->price);

        return view('transaction.checkout', compact('cart_items', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $cartItems = CartItem::with('item')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('message', 'Cart is empty')->with('message_type', 'danger');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->item->price);
        $paid = $request->paid_amount;

        if ($paid < $total) {
            return redirect()->back()->with('message', 'Insufficient amount')->with('message_type', 'danger');
        }

        /** @var \App\Models\User $user */

        // Langsung eksekusi tanpa DB::beginTransaction
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'paid_amount' => $paid,
            'change' => $paid - $total,
        ]);

        // dd($transaction);

        foreach ($cartItems as $cartItem) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'item_id' => $cartItem->item->id,
                'item_name' => $cartItem->item->item_name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
                'subtotal' => $cartItem->quantity * $cartItem->item->price,
            ]);

            // Update stock
            $cartItem->item->decrement('stock', $cartItem->quantity);
        }

        // Kosongkan cart
        CartItem::truncate();

        return redirect()->route('transaction.show', $transaction->id)
            ->with('message', 'Transaction successful!')
            ->with('message_type', 'success');
    }

}
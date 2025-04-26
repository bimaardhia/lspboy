<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    public function history()
    {
        $transactions = Transaction::latest()->paginate(10);
        return view('history.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['details', 'user'])->findOrFail($id);
        return view('history.detail', compact('transaction'));
    }
}
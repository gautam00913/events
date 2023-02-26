<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\NotifyPaymentRequest;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:100',
            'account_holder' => 'required|string',
            'account_number' => 'required|string',
            'account_provider' => 'required|string',
        ]);
        $transaction = Transaction::create([
            'amount' => $request->amount,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'account_provider' => $request->account_provider,
        ]);
        //send mail to admin that the organizer want get his money
        Mail::to(config('mail.from.address'))->send(new NotifyPaymentRequest(auth()->user(), $transaction));
        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => "Votre demande de transfère de $transaction->amount a été envoyée avec succès.<br>Vos sous seront bientôt disponible dans votre compte"
        ]);

        return response()->json(['transaction' => $transaction]);
    }

    public function create()
    {
        return view('transactions.create', ['user' => auth()->user()]);
    }
    public function history()
    {
        return view('transactions.history', ['transactions' => auth()->user()->transactions]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function insert(Request $request, User $user)
    {
        $transaction = $user->transactions()->create([

        ]);
        //send mail to admin that the organizer want get his money
        return back()->with('toast', [
            'type' => 'success',
            'message' => "Votre demande de transfère de $transaction->amount a été envoyée avec succès.<br>Vos sous seront bientôt disponible dans votre compte"
        ]);
    }
}

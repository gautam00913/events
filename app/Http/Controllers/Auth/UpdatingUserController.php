<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UpdatingUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('auth.edit', ['user' => auth()->user()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'imqge' => ['nullable', 'image', 'size:3000'],
            'phone' => ['nullable', 'string', 'regex:/^\+[0-9 ]{10,}$/']
        ]);
        $tab1 = [];
        $path = null;
        if($request->password) $tab1 = ['password' => Hash::make($request->password)];
        if($request->image)
        {
            $path = $request->image->store('public/avatars');
            $tab1['image'] = $path;
        }
        if($request->phone) $tab1['phone'] = $request->phone;
        
        $user->update(array_merge(
            [
                'name' => $request->name
            ],
            $tab1
        ));
        $user = User::find($user->id);
        Auth::login($user);
        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => "Modifcation effectuée avec succès"
        ]);
        return response()->json(['user' => $user]);
    }
}

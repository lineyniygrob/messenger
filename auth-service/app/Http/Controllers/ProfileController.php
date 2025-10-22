<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request) 
    {
        $user = $request->user();

        $validate = $request->validate([
            'login' => 'required|min:3|string',
            'email' => 'required|email',
        ]);

        $user->update($validate);

        return response()->json(['message' => 'Профиль обновлен']);
    }

    public function destroy (Request $request) 
    {
        $user = $request->user();
        $user->delete();
        return response()->json([
            'message' => 'Аккаунт удален'
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = User::select('id', 'login', 'created_at')->findOrFail($id);
        dd($user);

    }
}

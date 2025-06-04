<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MokaroUser;
use Illuminate\Support\Facades\Http;


class MatchController extends Controller
{
    //code
    public function todayMatches()
    {
        return view('matches');
    }
    public function fetch()
    {
        $users = MokaroUser::paginate(5);
        return response()->json($users); // JSON formatda
    }
    // UserAjaxController.php
    public function destroy($id)
    {
        $user = MokaroUser::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Foydalanuvchi topilmadi'], 404);
        }

        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'Foydalanuvchi o‘chirildi']);
    }
    // Save
    public function update(Request $request, $id)
    {
        $user = MokaroUser::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Foydalanuvchi topilmadi']);
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['status' => 'success']);
    }


}

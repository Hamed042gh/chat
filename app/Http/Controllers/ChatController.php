<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ChatController extends Controller
{
   public function index()
   {
      $user = Auth::user();
      Gate::authorize('viewAny', $user);
      return view('chat.index', compact('user'));
   }
}

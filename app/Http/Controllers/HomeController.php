<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $chat;
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }
    public function index()
    {
        $chats = $this->chat->get();
        return view('home')->with('chats',$chats);
    }
}

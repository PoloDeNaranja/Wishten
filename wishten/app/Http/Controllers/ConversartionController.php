<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;



class ConversationController extends Controller
{
    //conversaciones de un usuario
    function userConversations()
    {
        $userConversations = Conversation::where('id_user1',auth()->user()->id)->orWhere('id_user2',auth()->user()->id)->with(['user1','user2'])->get();
        return view('conversationsList',compact('userConversations'));
    }

    
    
}

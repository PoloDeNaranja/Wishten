<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ChatController extends Controller
{
    public function home3(Request $request)
    {
        $conversation = Conversation::findOrFail($request['conversation']);
        return view('home-3')->with(['conversation' =>  $conversation]);
    }


    function createChat(Offer $offer){

        $offer = Offer::findOrFail($offer->id);
        $chat = $offer->chats()->where('id_user', Auth::user()->id)->first();

        if($chat){
            return redirect()->route("home-3",['conversation' =>  $chat]);
        }

        $user_id = Auth::user()->id;
        $company_id = $offer->owner_id;

        $chat = $offer->chats()->create([
            'id_user' =>  $user_id,
            'id_company'   =>  $company_id
        ]);
        return redirect()->route("home-3",['conversation' =>  $chat]);
    }

    function sendMessage(Conversation $conversation,Request $request){

        $conversation = Conversation::findOrFail($conversation->id);

        $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $conversation->messages()->create([
            'id_sender' =>  Auth::id(),
            'content'   =>  $request->message,
            'date' =>  date("Y-m-d H:i:s")
        ]);

        return back();
    }

    function chatList(Request $request){
        $offer = Offer::findOrFail($request->offer);
        return view('home-4')->with(['chats' =>  $offer->chats]);;
    }


    function adminMessages() {
        $messages = Message::all();

        return view('adminMessages')->with('messages',$messages);
    }

    function deleteMessage(Message $message) {

        $message->delete();
        return back()->with('success', 'The message was deleted successfully!');


    }



}

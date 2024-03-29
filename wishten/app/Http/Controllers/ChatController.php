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
    // Manda a la página de chat
    public function index(Request $request)
    {
        $conversation = Conversation::findOrFail($request['conversation']);
        return view('chat')->with(['conversation' =>  $conversation]);
    }

    // crea el chat de cada oferta tomando al usuario logeado y a la empresa que ha subido la oferta
    function createChat(Offer $offer){

        $offer = Offer::findOrFail($offer->id);
        $chat = $offer->chats()->where('id_user', Auth::user()->id)->first();

        if($chat){
            return redirect()->route("chat.index",['conversation' =>  $chat]);
        }

        $user_id = Auth::user()->id;
        $company_id = $offer->owner_id;

        $chat = $offer->chats()->create([
            'id_user' =>  $user_id,
            'id_company'   =>  $company_id
        ]);
        return redirect()->route("chat.index",['conversation' =>  $chat]);
    }
    // Manda mensaje al chat desde el usuario logeado
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
    //Lista todos los chats que tiene una oferta concreta de una empresa
    function chatList(Request $request){
        $offer = Offer::findOrFail($request->offer);
        return view('chatList')->with(['chats' =>  $offer->chats()->withCount('messages')->having('messages_count', '>', 0)->get()]);
    }

    

    //Lista todos los chats que tiene una oferta concreta de una empresa
    function userChatList(Request $request){
        $chats = Auth::user()->conversations()->withCount('messages')->having('messages_count', '>', 0)->get();
        return view('myChats')->with(['chats' =>  $chats]);
    }

    // Manda a la paagina de administracion de mensajes
    function adminMessages() {
        $messages = Message::all();

        return view('adminMessages')->with('messages',$messages);
    }
    //elimina el mensaje 
    function deleteMessage(Message $message) {

        $message->delete();
        return back()->with('success', 'The message was deleted successfully!');


    }



}

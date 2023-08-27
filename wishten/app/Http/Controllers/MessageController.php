<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;



class MessageController extends Controller
{
    //mostrar la pagina de chat 
    function create()
    {
        $users =User::all();
        return view('sendMessage',compact('users'));
    }
    //almcenar cuando se ha creado el chat y enviado algo
    function store(Request $request)
    {
        $id_sender = auth()->user()->id;
        $id_receiver = $request->input('id_receiver');

        
        $existingConversation = Conversation::where(function ($query) use ($id_sender, $id_receiver) {
            $query->where('id_user1', $id_sender)->where('id_user2', $id_receiver);
        })->orWhere(function ($query) use ($id_sender, $id_receiver) {
            $query->where('id_user1', $id_receiver)->where('id_user2', $id_sender);
        })->first();

        if (!$existingConversation) {
            $conversation = new Conversation([
                'id_user1' => $id_sender,
                'id_user2' => $id_receiver
            ]);
            $conversation->save();
        }

        $message = new Message([
            'id_conversation' => $existingConversation ? $existingConversation->id_conversation : $conversation->id_conversation,
            'id_sender' => $id_sender,
            'id_receiver' => $id_receiver,
            'content' => $request->input('content')
        ]);
        $message->save();

        return redirect()->route('sendMessage')->with('success', 'Message sent');
    }
    //Todos los mensajes enviados por un usuario
    function sentMessages()
    {
        $sentMessages = Message::where('id_sender', auth()->user()->id)
            ->with(['conversation', 'receiver']) 
            ->get();

        return view('messages.sent', compact('sentMessages'));
    }
}

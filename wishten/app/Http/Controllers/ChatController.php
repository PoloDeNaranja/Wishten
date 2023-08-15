namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $message = new Message([
            'content' => $request->input('message')
        ]);
        $message->save();

        return response()->json(['status' => 'success']);
    }

    public function getMessages()
    {
        $messages = Message::all();

        return response()->json(['messages' => $messages]);
    }
}
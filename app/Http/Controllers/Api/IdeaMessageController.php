<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\IdeaMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaMessageController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(['content' => 'required|max:255']);

        $idea = Idea::findOrFail($request->input('idea_id'));

        $ideaMessage = new IdeaMessage();
        $ideaMessage->idea_id = $idea->id;
        $ideaMessage->user_id = Auth::user()->id;
        $ideaMessage->content = $request->input('content');
        $ideaMessage->save();

        return response()->json($ideaMessage);
    }
}

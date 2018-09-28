<?php namespace App\Http\Controllers\Api;

use App\Events\IdeaVoteAdded;
use App\Events\IdeaVoteDeleted;
use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\IdeaVote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaVoteController extends Controller
{
    public function create(Request $request)
    {
        $idea = Idea::findOrFail($request->input('idea_id'));

        // dont allow duplicate voting
        $existingVote = IdeaVote::where(['user_id' => Auth::user()->id, 'idea_id' => $request->input('idea_id')])->first();
        if($existingVote) {
            throw new Exception('already voted');
        }

        $ideaVote = new IdeaVote();
        $ideaVote->idea_id = $idea->id;
        $ideaVote->user_id = Auth::user()->id;
        $ideaVote->save();

        broadcast(new IdeaVoteAdded($ideaVote));

        return response()->json($ideaVote);
    }

    public function delete($ideaVoteId)
    {
        $ideaVote = IdeaVote::findOrFail($ideaVoteId);

        $ideaVote->delete();

        broadcast(new IdeaVoteDeleted($ideaVote));
    }
}

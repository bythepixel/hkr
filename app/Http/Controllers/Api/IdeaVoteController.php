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
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
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

    /**
     * @param $ideaVoteId
     */
    public function delete($ideaVoteId)
    {
        $ideaVote = IdeaVote::findOrFail($ideaVoteId);

        $ideaVote->delete();

        broadcast(new IdeaVoteDeleted($ideaVote));
    }

    /**
     * @param int $ideaId
     */
    public function deleteByUserAndIdea(int $ideaId)
    {
        $idea = Idea::findOrFail($ideaId);
        $user = Auth::user();

        $ideaVote = $idea->votes->first(function($vote) use ($user) {
            if($vote->user_id === $user->id) {
                return true;
            }
        });

        $this->delete($ideaVote->id);
    }
}

<?php namespace App\Http\Controllers\Api;

use App\Events\IdeaFavoriteAdded;
use App\Events\IdeaVoteAdded;
use App\Events\IdeaVoteDeleted;
use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\Idea;
use App\Models\IdeaFavorite;
use App\Models\IdeaVote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaFavoriteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function create(Request $request)
    {
        $idea = Idea::findOrFail($request->input('idea_id'));
        $hackathon = Hackathon::findOrFail($request->input('hackathon_id'));
        $user = Auth::user();

        IdeaFavorite::where(['user_id' => $user->id, 'hackathon_id' => $hackathon->id])->delete();

        $ideaFavorite = new IdeaFavorite();
        $ideaFavorite->idea_id = $idea->id;
        $ideaFavorite->user_id = $user->id;
        $ideaFavorite->hackathon_id = $hackathon->id;
        $ideaFavorite->save();

        broadcast(new IdeaFavoriteAdded($ideaFavorite));

        return response()->json($ideaFavorite);
    }

    /**
     * @param $ideaVoteId
     */
    public function delete($ideaVoteId)
    {
        $ideaVote = IdeaVote::findOrFail($ideaVoteId);

        $ideaVote->delete();

        broadcast(new IdeaFavoriteDeleted($ideaVote));
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

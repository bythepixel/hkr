<?php namespace App\Http\Controllers\Api;

use App\Events\IdeaArchived;
use App\Events\IdeaDeleted;
use App\Events\IdeaRestored;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeatureMessage;
use App\Models\FeatureVote;
use App\Models\Hackathon;
use App\Models\Idea;
use App\Models\IdeaFavorite;
use App\Models\IdeaMessage;
use App\Models\IdeaVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate(['title' => 'required|max:255', 'description' => 'required|max:999']);

        $hackathon = Hackathon::findOrFail($request->input('hackathon_id'));

        $idea = new Idea();
        $idea->hackathon_id = $hackathon->id;
        $idea->user_id = Auth::user()->id;
        $idea->title = $request->input('title');
        $idea->description = $request->input('description');
        $idea->long_description = $request->input('long_description');
        $idea->save();

        return response()->json($idea);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $idea = Idea::with(['user', 'messages', 'messages.user', 'votes', 'favorites'])->findOrFail($id);

        return response()->json($idea);
    }

    /**
     * @param $ideaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVotes($ideaId)
    {
        $ideaVotes = IdeaVote::with(['user'])->where(['idea_id' => $ideaId])->get();

        return response()->json($ideaVotes);
    }

    /**
     * @param $ideaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFavorites($ideaId)
    {
        $ideaFavorites = IdeaFavorite::with(['user'])->where(['idea_id' => $ideaId])->get();

        return response()->json($ideaFavorites);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        IdeaVote::where('idea_id', $id)->delete();
        IdeaMessage::where('idea_id', $id)->delete();
        $features = Feature::where('idea_id', $id)->get();
        foreach($features as $feature) {
            FeatureVote::where('feature_id', $feature->id)->delete();
            FeatureMessage::where('feature_id', $feature->id)->delete();
        }
        $features->each->delete();
        $idea = Idea::where('id', $id)->get();
        Idea::where('id', $id)->delete();

        broadcast(new IdeaDeleted($idea));

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive($id)
    {
        $idea = Idea::where('id', $id)->first();
        $idea->archived = true;
        $idea->save();

        broadcast(new IdeaArchived($idea));

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $idea = Idea::where('id', $id)->first();
        $idea->archived = false;
        $idea->save();

        broadcast(new IdeaRestored($idea));

        return response()->json(['success' => 'success'], 200);
    }
}

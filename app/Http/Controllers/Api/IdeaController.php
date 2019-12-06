<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\Idea;
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
        $idea->save();

        return response()->json($idea);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $idea = Idea::with(['user', 'messages', 'messages.user', 'votes'])->findOrFail($id);

        return response()->json($idea);
    }

    /**
     * @param $ideaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVotes($ideaId)
    {
        $ideas = IdeaVote::with(['user'])->where(['idea_id' => $ideaId])->get();

        return response()->json($ideas);
    }
}

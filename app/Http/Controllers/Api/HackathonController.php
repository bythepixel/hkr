<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\Idea;
use App\Models\IdeaVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HackathonController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Hackathon::with(['user'])->get());
    }

    /**
     * @param $id
     * @param $order
     * @param $direction
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $order="created_at", $direction="DESC")
    {
        if($order != "votes") {
            $hackathon = Hackathon::with(['user', 'ideas' => function($query) use($order, $direction) {
                $query->orderBy($order, $direction);
            }, 'ideas.messages', 'ideas.messages.user', 'ideas.votes', 'ideas.user'])->findOrFail($id);
        } else {
            $hackathon = Hackathon::with(['user', 'ideas', 'ideas.messages', 'ideas.messages.user', 'ideas.votes', 'ideas.user'])->findOrFail($id);
            $hackathon['ideas']->loadCount('votes');
            $sorted = false;
            while(!$sorted) {
                $switchMade = false;
                foreach($hackathon['ideas'] as $index => $idea) {
                    if(isset($hackathon['ideas'][$index + 1])) {
                        if($direction === "DESC") {
                            $comparison = $hackathon['ideas'][$index]->votes_count < $hackathon['ideas'][$index+1]->votes_count;
                        } else {
                            $comparison = $hackathon['ideas'][$index]->votes_count > $hackathon['ideas'][$index+1]->votes_count;
                        }
                        if($comparison) {
                            $temp = $hackathon['ideas'][$index];
                            $hackathon['ideas'][$index] = $hackathon['ideas'][$index+1];
                            $hackathon['ideas'][$index+1] = $temp;
                            $switchMade = true;
                        }
                    }
                }
                if(!$switchMade) {
                    $sorted = true;
                }
            }
        }

        return response()->json($hackathon);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate(['title' => 'required|max:255']);

        $hackathon = new Hackathon();
        $hackathon->title =  $request->input('title');
        $hackathon->user_id = Auth::user()->id;
        $hackathon->save();

        return response()->json($hackathon);
    }

    /**
     * @param $hackathonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset($hackathonId) {
        $ideas = Idea::where('hackathon_id', $hackathonId)->get();
        IdeaVote::whereIn('idea_id', $ideas->pluck('id'))->delete();

        return $this->show($hackathonId);
    }
}

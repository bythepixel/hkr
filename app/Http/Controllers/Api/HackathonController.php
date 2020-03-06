<?php namespace App\Http\Controllers\Api;

use App\Events\HackathonDeleted;
use App\Events\HackathonLocked;
use App\Events\HackathonUnlocked;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeatureMessage;
use App\Models\FeatureVote;
use App\Models\Hackathon;
use App\Models\Idea;
use App\Models\IdeaMessage;
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
     * @param string $sort
     * @param string $filter
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     *             <div class="footer__selects">
    <div class="field-wrapper">
    <label for="sort">Sort</label>
    <select id="sort" name="sort" @change="loadHackathon(true)" v-model.trim="sort">
    <option value="most_recent">Most Recent</option>
    <option value="most_voted">Most Voted</option>
    <option value="a_z">A-Z</option>
    </select>
    </div>
    <div class="field-wrapper">
    <label for="filter">Show</label>
    <select id="filter" name="filter" @change="loadHackathon(true)" v-model.trim="filter">
    <option value="unarchived">Unarchived</option>
    <option value="archived">Archived</option>
    <option value="all">All</option>
    </select>
    </div>
    </div>
     */

    public function show($id, $sort="most_recent", $filter="unarchived")
    {
        if($filter === "unarchived") {
            $showArchives = [false];
        } else if($filter === "archived") {
            $showArchives = [true];
        } else if($filter === "all") {
            $showArchives = [true, false];
        }
        if($sort === "most_recent") {
            $order = "created_at";
            $direction = "DESC";
        } else if($sort === "most_voted") {
            $order = "votes";
        } else if($sort === "a_z") {
            $order = "title";
            $direction = "ASC";
        }
        if($order != "votes") {
            $hackathon = Hackathon::with(['user', 'ideas' => function($query) use($order, $showArchives, $direction) {
                $query->whereIn('archived', $showArchives)->orderBy($order, $direction);
            }, 'ideas.messages', 'ideas.messages.user', 'ideas.votes', 'ideas.votes.user', 'ideas.favorites', 'ideas.favorites.user', 'ideas.user'])->findOrFail($id);
        } else {
            $hackathon = Hackathon::with(['user', 'ideas' => function($query) use($showArchives) {
                $query->whereIn('archived', $showArchives);
            }, 'ideas.messages', 'ideas.messages.user', 'ideas.votes', 'ideas.votes.user', 'ideas.favorites', 'ideas.favorites.user', 'ideas.user'])->findOrFail($id);
            $hackathon['ideas']->loadCount('votes');
            $sorted = false;
            while(!$sorted) {
                $switchMade = false;
                foreach($hackathon['ideas'] as $index => $idea) {
                    if(isset($hackathon['ideas'][$index + 1])) {
                        $comparison = $hackathon['ideas'][$index]->votes_count < $hackathon['ideas'][$index+1]->votes_count;
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

    /**
     * @param $hackathonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function lock($hackathonId) {
        $hackathon = Hackathon::findOrFail($hackathonId);
        $hackathon->locked = true;
        $hackathon->save();

        broadcast(new HackathonLocked($hackathon));

        return $this->show($hackathonId);
    }

    /**
     * @param $hackathonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlock($hackathonId) {
        $hackathon = Hackathon::findOrFail($hackathonId);
        $hackathon->locked = false;
        $hackathon->save();

        broadcast(new HackathonUnlocked($hackathon));

        return $this->show($hackathonId);
    }

    /**
     * @param $hackathonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($hackathonId) {
        $hackathon = Hackathon::findOrFail($hackathonId);
        $ideas = Idea::where('hackathon_id', $hackathonId)->get();
        IdeaVote::whereIn('idea_id', $ideas->pluck('id'))->delete();
        IdeaMessage::whereIn('idea_id', $ideas->pluck('id'))->delete();
        $features = Feature::whereIn('idea_id', $ideas->pluck('id'))->get();
        foreach($features as $feature) {
            FeatureVote::where('feature_id', $feature->id)->delete();
            FeatureMessage::where('feature_id', $feature->id)->delete();
        }
        $features->each->delete();
        $ideas->each->delete();
        $hackathon->delete();

        broadcast(new HackathonDeleted($hackathon));

        return response()->json(['success' => 'success'], 200);
    }
}

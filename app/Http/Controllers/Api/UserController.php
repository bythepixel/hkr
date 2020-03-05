<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];
        $data['ideas'] = Idea::with('hackathon')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        $data['hackathons'] = Hackathon::all();

        return response()->json($data);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copyIdea(Request $request)
    {
        $user = Auth::user();
        $idea = Idea::findOrFail($request->input('idea_id'));
        $hackathonId = $request->input('hackathon_id');

        $newIdea = new Idea();
        $newIdea->user_id = $user->id;
        $newIdea->hackathon_id = $hackathonId;
        $newIdea->title = $idea->title;
        $newIdea->description = $idea->description;
        $newIdea->long_description = $idea->long_description;
        $newIdea->archived = false;

        $newIdea->save();

        return response()->json($newIdea);
    }
}

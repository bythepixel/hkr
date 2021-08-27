<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|unique:users|min:3|max:255',
            'password' => 'required|min:3|max:255'
        ]);

        if($request->get('top-secret') !== 'hkr') {
            abort(401);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        return response()->json($user);
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

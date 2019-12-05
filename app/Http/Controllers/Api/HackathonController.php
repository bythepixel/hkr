<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $hackathon = Hackathon::with(['user', 'ideas', 'ideas.messages', 'ideas.messages.user', 'ideas.votes', 'ideas.user'])->findOrFail($id);

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
}

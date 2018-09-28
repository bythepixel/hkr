<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;

class HackathonController extends Controller
{
    public function index()
    {
        return response()->json(Hackathon::all());
    }

    public function show($id)
    {
        $hackathon = Hackathon::with(['ideas', 'ideas.messages', 'ideas.votes'])->findOrFail($id);

        return response()->json($hackathon);
    }
}

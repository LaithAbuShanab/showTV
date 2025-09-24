<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\EpisodeRepository;
use App\Models\Episode;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EpisodeController extends Controller
{
    public function __construct(protected EpisodeRepository $episodeRepository) {}

    public function index(Episode $episode)
    {
        try {
            $data = $this->episodeRepository->index($episode);
            return view('frontend.episode', $data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    public function react(Request $request)
    {
        $user = auth()->user();
        $episodeId = $request->input('episode_id');
        $isLiked = (bool) $request->input('is_liked');

        Like::updateOrCreate(
            ['user_id' => $user->id, 'episode_id' => $episodeId],
            ['is_liked' => $isLiked]
        );

        $likes = Like::where('episode_id', $episodeId)->where('is_liked', true)->count();
        $dislikes = Like::where('episode_id', $episodeId)->where('is_liked', false)->count();

        return response()->json([
            'success' => true,
            'likes' => $likes,
            'dislikes' => $dislikes,
        ]);
    }
}

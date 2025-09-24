<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\EpisodeRepository;
use App\Models\Episode;
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
}

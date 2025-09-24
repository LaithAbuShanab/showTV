<?php

namespace App\Http\Repositories\Frontend;

class EpisodeRepository
{
    public function index($episode)
    {
        return [
            'episode'          => $episode,
            'season'           => $episode->season,
            'show'             => $episode->season->show,
            'currentEpisodeId' => $episode->id,
            'currentSeasonId'  => $episode->season_id,
        ];
    }
}

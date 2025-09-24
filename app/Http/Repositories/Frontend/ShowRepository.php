<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Show;
use App\Models\Tag;

class ShowRepository
{
    public function index($id)
    {
        $show = Show::findOrFail($id);

        $firstSeason = $show->seasons()->orderBy('season_number')->first();

        $firstEpisode = null;
        if ($firstSeason) {
            $firstEpisode = $firstSeason->episodes()->orderBy('episode_number')->first();
        }

        return [
            'show'         => $show,
            'firstEpisode' => $firstEpisode,
        ];
    }

}

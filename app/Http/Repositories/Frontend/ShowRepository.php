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

    public function toggleFollow($request)
    {
        $user = auth()->user();
        $showId = $request->input('show_id');

        if (!$user || !$showId) {
            return response()->json(['status' => 'error'], 403);
        }

        $alreadyFollowed = $user->follows()->where('show_id', $showId)->exists();

        if ($alreadyFollowed) {
            $user->follows()->detach($showId);
            $status = 'unfollowed';
        } else {
            $user->follows()->attach($showId);
            $status = 'followed';
        }

        $count = Show::find($showId)->followers()->count();

        return [
            'status' => $status,
            'count' => $count
        ];
    }
}

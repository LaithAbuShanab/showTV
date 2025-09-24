<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Episode;
use App\Models\Show;

class SearchRepository
{
    public function index($query)
    {
        $query = strtolower($query);

        $shows = Show::whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
            ->orWhereRaw('LOWER(title) LIKE ?', ["{$query}%"])
            ->orWhereRaw('LOWER(title) LIKE ?', ["%{$query}"])
            ->with('category:id,name')
            ->get()
            ->map(function ($show) {
                return [
                    'id' => $show->id,
                    'title' => $show->title,
                    'type' => 'Show',
                    'category' => $show->category->name ?? '',
                    'image' => $show->getFirstMediaUrl('show_cover', 'thumbnail'),
                ];
            })
            ->values();

        $episodes = Episode::whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
            ->orWhereRaw('LOWER(title) LIKE ?', ["{$query}%"])
            ->orWhereRaw('LOWER(title) LIKE ?', ["%{$query}"])
            ->get()
            ->map(function ($episode) {
                return [
                    'id' => $episode->id,
                    'title' => $episode->title,
                    'type' => 'Episode',
                    'category' => 'Episode',
                    'image' => $episode->getFirstMediaUrl('episode_cover', 'thumbnail'),
                ];
            })
            ->values();

        return [
            'shows' => $shows,
            'episodes' => $episodes,
        ];
    }
}

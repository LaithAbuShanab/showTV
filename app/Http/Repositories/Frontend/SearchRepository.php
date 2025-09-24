<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Episode;
use App\Models\Show;

class SearchRepository
{
    public function index($query)
    {
        $search = $query . '*';

        $shows = Show::selectRaw("*, MATCH(title) AGAINST(? IN BOOLEAN MODE) as relevance", [$search])
            ->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$search])
            ->with('category:id,name')
            ->orderByDesc('relevance')
            ->get()
            ->map(function ($show) {
                return [
                    'id'       => $show->id,
                    'title'    => $show->title,
                    'type'     => 'Show',
                    'category' => $show->category->name ?? '',
                    'image'    => $show->getFirstMediaUrl('show_cover', 'thumbnail') ?: asset('frontend/img/default.png'),
                ];
            });

        $episodes = Episode::selectRaw("*, MATCH(title) AGAINST(? IN BOOLEAN MODE) as relevance", [$search])
            ->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$search])
            ->orderByDesc('relevance')
            ->get()
            ->map(function ($episode) {
                return [
                    'id'       => $episode->id,
                    'title'    => $episode->title,
                    'type'     => 'Episode',
                    'category' => 'Episode',
                    'image'    => $episode->getFirstMediaUrl('episode_cover', 'thumbnail') ?: asset('frontend/img/default.png'),
                ];
            });

        return [
            'shows'    => $shows->values(),
            'episodes' => $episodes->values(),
        ];
    }
}

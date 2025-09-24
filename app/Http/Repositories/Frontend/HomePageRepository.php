<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Show;

class HomePageRepository
{
    public function index()
    {
        $episodes = Episode::with('season.show.tags')
            ->latest()
            ->get()
            ->unique(fn($episode) => $episode->season->show->id)
            ->take(5)
            ->values();

        return [
            'episodes'   => $episodes,
            'categories' => Category::with(['shows.tags'])->get(),
            'newShows'   => Show::with('tags')->latest()->take(6)->get(),
        ];
    }
    public function randomly()
    {
        return Show::with('tags')->inRandomOrder()->limit(5)->get();
    }
}

<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Show;

class HomePageRepository
{
    public function index()
    {
        return [
            'episodes'   => Episode::with('season.show.tags')->latest()->take(5)->get(),
            'categories' => Category::with(['shows.tags'])->get(),
            'newShows'   => Show::with('tags')->latest()->take(5)->get(),
        ];
    }

    public function randomly()
    {
        return Show::with('tags')->inRandomOrder()->limit(5)->get();
    }
}

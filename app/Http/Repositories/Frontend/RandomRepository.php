<?php

namespace App\Http\Repositories\Frontend;

use App\Models\Show;
use App\Models\Tag;

class RandomRepository
{
    public function index()
    {
        return [
            'randomly' => Show::with('tags')->inRandomOrder()->limit(10)->get(),
            'tags'     => Tag::all(),
        ];
    }

    public function filterByTag($tagId)
    {
        $tag = Tag::with('show.tags')->findOrFail($tagId);

        return [
            'tags'     => Tag::all(),
            'tag'      => $tag,
            'randomly' => $tag->show()->inRandomOrder()->limit(10)->get(),
        ];
    }

}

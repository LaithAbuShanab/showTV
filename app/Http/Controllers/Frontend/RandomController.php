<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\RandomRepository;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RandomController extends Controller
{
    public function __construct(protected RandomRepository $randomRepository) {}

    public function randomly()
    {
        try {
            $data = $this->randomRepository->index();
            return view('frontend.random', $data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    public function filterByTag(Request $request)
    {
        try {
            $data = $this->randomRepository->filterByTag($request->query('tag_id'));
            return view('frontend.random', $data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}

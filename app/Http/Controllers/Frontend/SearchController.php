<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\SearchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function __construct(protected SearchRepository $searchRepository) {}

    public function index(Request $request)
    {
        try {
            $data = $this->searchRepository->index($request->get('q'));
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}

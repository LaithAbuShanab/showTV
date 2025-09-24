<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\ShowRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    public function __construct(protected ShowRepository $showRepository) {}

    public function index(Request $request, $id)
    {
        try {
            $data = $this->showRepository->index($id);
            return view('frontend.series', $data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\HomePageRepository;
use Illuminate\Support\Facades\Log;

class HomePageController extends Controller
{
    public function __construct(protected HomePageRepository $homePageRepository) {}

    public function index()
    {
        try {
            $data = $this->homePageRepository->index();
            return view('frontend.home', $data);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}

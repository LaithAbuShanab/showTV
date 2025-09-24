<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Repositories\Frontend\Auth\LoginRepository;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function __construct(protected LoginRepository $loginRepository) {}

    public function create()
    {
        try {
            return view('frontend.auth.login');
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $this->loginRepository->store($request);
            return redirect()->route('dashboard');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->loginRepository->destroy($request);
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}

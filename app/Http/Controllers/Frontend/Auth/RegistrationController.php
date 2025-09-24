<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Frontend\Auth\RegisterRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegistrationController extends Controller
{
    public function __construct(protected RegisterRepository $registerRepository) {}

    public function create()
    {
        try {
            return view('frontend.auth.register');
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
                'avatar'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ],
        ]);

        try {
            $this->registerRepository->store($request);
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
        }
    }
}

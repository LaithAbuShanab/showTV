@extends('frontend.master')
@section('content')
    <div class="sign section--bg" data-bg="{{ asset('frontend/img/section/section.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <form method="POST" action="{{ route('login') }}" class="sign__form" style="width: 600px;">
                            @csrf
                            <a href="index.html" class="sign__logo">
                                <img src="{{ asset('frontend/img/logo.svg') }}" alt="">
                            </a>

                            <div class="sign__group">
                                <input style="width: 480px;" class="sign__input @error('email') is-invalid @enderror" name="email"
                                    type="email" placeholder="your@email.com" value="{{ old('email') }}" autofocus>
                                @error('email')
                                    <div class="invalid-feedback" style="color: #ff55a5; font-size: 14px; margin-top: 5px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group">
                                <input style="width: 480px;" class="sign__input @error('password') is-invalid @enderror" name="password"
                                    type="password" placeholder="••••••••">
                                @error('password')
                                    <div class="invalid-feedback" style="color: #ff55a5; font-size: 14px; margin-top: 5px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group sign__group--checkbox">
								<input id="remember" name="remember" type="checkbox">
								<label for="remember">Remember Me</label>
							</div>

                            <button class="sign__btn" type="submit">Sign in</button>

                            <span class="sign__text">Don't have an account? <a href="{{ route('register') }}">Sign up!</a></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

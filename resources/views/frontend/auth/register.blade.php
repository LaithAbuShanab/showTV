@extends('frontend.master')
@section('content')
    <style>
        .custom-file-upload {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .upload-btn {
            background: #ff55a5;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s ease;
        }

        .upload-btn:hover {
            background: #e04493;
        }

        .upload-btn i {
            font-size: 18px;
        }

        .sign__input-file {
            display: none;
        }

        .file-name {
            color: #aaa;
            font-size: 14px;
            font-style: italic;
        }
    </style>

    <div class="sign section--bg" data-bg="{{ asset('frontend/img/section/section.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <!-- registration form -->
                        <form action="{{ route('register') }}" method="POST" class="sign__form" style="width: 600px;" enctype="multipart/form-data">
                            @csrf

                            <a href="{{ route('home') }}" class="sign__logo">
                                <img src="{{ asset('frontend/img/logo.svg') }}" alt="">
                            </a>

                            <div class="sign__group">
                                <input style="width: 480px;" type="text"
                                    class="sign__input @error('name') is-invalid @enderror" name="name"
                                    placeholder="Name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback" style="color: #ff55a5; margin-top: 5px;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group">
                                <input style="width: 480px;" type="text"
                                    class="sign__input @error('email') is-invalid @enderror" name="email"
                                    placeholder="Email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback" style="color: #ff55a5; margin-top: 5px;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group">
                                <input style="width: 480px;" type="password"
                                    class="sign__input @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback" style="color: #ff55a5; margin-top: 5px;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group">
                                <input style="width: 480px;" type="password" class="sign__input"
                                    name="password_confirmation" placeholder="Confirm Password">
                            </div>

                            <div class="sign__group">
                                <label for="avatar" style="color: #fff;">Profile Image</label><br>

                                <div class="custom-file-upload">
                                    <label for="avatar" class="upload-btn">
                                        <i class="ion-ios-cloud-upload"></i> Choose Image
                                    </label>
                                    <input type="file" id="avatar" name="avatar" class="sign__input-file"
                                        accept="image/*">
                                    <span id="file-name" class="file-name">No file chosen</span>
                                </div>

                                @error('avatar')
                                    <div class="invalid-feedback" style="color: #ff55a5; margin-top: 5px;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="sign__group">
                                <img id="avatarPreview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 150px; margin-top: 10px; border-radius: 10px;">
                            </div>

                            <button class="sign__btn" type="submit">Sign up</button>

                            <span class="sign__text">Already have an account? <a href="{{ route('login') }}">Sign
                                    in!</a></span>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

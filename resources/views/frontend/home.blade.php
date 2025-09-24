@extends('frontend.master')
@section('content')
    <!-- home -->
    <section class="home">
        <!-- home bg -->
        <div class="owl-carousel home__bg">
            <div class="item home__cover" data-bg="{{ asset('frontend/img/home/home__bg.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('frontend/img/home/home__bg2.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('frontend/img/home/home__bg3.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('frontend/img/home/home__bg4.jpg') }}"></div>
        </div>
        <!-- end home bg -->

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="home__title"><b>LATEST EPISODES</b> AVAILABLE NOW</h1>

                    <button class="home__nav home__nav--prev" type="button">
                        <i class="icon ion-ios-arrow-round-back"></i>
                    </button>
                    <button class="home__nav home__nav--next" type="button">
                        <i class="icon ion-ios-arrow-round-forward"></i>
                    </button>
                </div>

                <div class="col-12">
                    <div class="owl-carousel home__carousel">

                        @foreach ($episodes as $episode)
                            <div class="item">
                                <!-- card -->
                                <div class="card card--big">
                                    <div class="card__cover">
                                        <img src="{{ $episode->getFirstMediaUrl('episode_cover', 'thumbnail') }}"
                                            alt=""
                                            style="height: 382.78px">
                                        <a href="{{ route('episode.index', $episode) }}" class="card__play">
                                            <i class="icon ion-ios-play"></i>
                                        </a>
                                    </div>
                                    <div class="card__content">
                                        <h3 class="card__title">
                                            <a href="{{ route('episode.index', $episode) }}">{{ $episode->title }}</a>
                                        </h3>

                                        <span class="card__category">
                                            @foreach ($episode->season?->show?->tags ?? [] as $tag)
                                                <a href="#">{{ $tag->name }}</a>
                                            @endforeach
                                        </span>

                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end home -->

    <!-- content -->
    <section class="content">
        <div class="content__head">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- content title -->
                        <h2 class="content__title">New items</h2>
                        <!-- end content title -->

                        <!-- content tabs nav -->
                        <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
                            <!-- Fixed first tab -->
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab"
                                    aria-controls="tab-1" aria-selected="true">NEW RELEASES</a>
                            </li>

                            <!-- Dynamic tabs from categories -->
                            @foreach ($categories as $index => $category)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-{{ $index + 2 }}" role="tab"
                                        aria-controls="tab-{{ $index + 2 }}" aria-selected="false">
                                        {{ strtoupper($category->name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <!-- end content tabs nav -->

                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- content tabs -->
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                    <div class="row">
                        @foreach ($newShows as $show)
                            <!-- card -->
                            <div class="col-6 col-sm-12 col-lg-6">
                                <div class="card card--list">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="card__cover">
                                                <img src="{{ $show->getFirstMediaUrl('show_cover', 'thumbnail') }}"
                                                    alt=""
                                                    style="height: 236.89px">
                                                <a href="{{ route('show.index', $show->id) }}" class="card__play">
                                                    <i class="icon ion-ios-play"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="card__content">
                                                <h3 class="card__title"><a href="{{ route('show.index', $show->id) }}">{{ $show->title }}</a>
                                                </h3>
                                                <span class="card__category">
                                                    @foreach ($show->tags as $tag)
                                                        <a href="#">{{ $tag->name }}</a>
                                                    @endforeach
                                                </span>

                                                <div class="card__description">
                                                    <p>{{ $show->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        @endforeach
                    </div>
                </div>

                @foreach ($categories as $index => $category)
                    <div class="tab-pane fade" id="tab-{{ $index + 2 }}" role="tabpanel" aria-labelledby="2-tab">
                        <div class="row">
                            <!-- card -->
                            @foreach ($category->shows as $show)
                                <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                                    <div class="card">
                                        <div class="card__cover">
                                            <img src="{{ $show->getFirstMediaUrl('show_cover', 'thumbnail') }}" alt="" style="height: 236.89px">
                                            <a href="{{ route('show.index', $show->id) }}" class="card__play">
                                                <i class="icon ion-ios-play"></i>
                                            </a>
                                        </div>
                                        <div class="card__content">
                                            <h3 class="card__title"><a href="{{ route('show.index', $show->id) }}">{{ $show->title }}</a></h3>
                                            <span class="card__category">
                                                @foreach ($show->tags as $tag)
                                                    <a href="#">{{ $tag->name }}</a>
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- end card -->
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end content tabs -->
        </div>
    </section>
    <!-- end content -->
@endsection

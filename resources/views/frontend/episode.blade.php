@extends('frontend.master')
@section('content')

    <style>
        .accordion__list tr.active {
            background-color: rgba(255, 255, 255, 0.05);
            font-weight: bold;
            color: #fff;
            transition: background-color 0.3s ease;
        }
    </style>

    <!-- details -->
    <section class="section details">
        <!-- details background -->
        <div class="details__bg" data-bg="{{ asset('frontend/img/home/home__bg.jpg') }}"></div>
        <!-- end details background -->

        <!-- details content -->
        <div class="container">
            <div class="row">
                <!-- title -->
                <div class="col-12">
                    <h1 class="details__title">{{ $show->title }}</h1>
                </div>
                <!-- end title -->

                <!-- content -->
                <div class="col-10">
                    <div class="card card--details card--series">
                        <div class="row">
                            <!-- card cover -->
                            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                                <div class="card__cover">
                                    <img src="{{ $show->getFirstMediaUrl('show_cover', 'thumbnail') }}" alt="">
                                </div>
                            </div>
                            <!-- end card cover -->

                            <!-- card content -->
                            <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
                                <div class="card__content">
                                    <div class="card__wrap">
                                    </div>

                                    <ul class="card__meta">
                                        <li>
                                            <span>Genre:</span>
                                            @foreach ($show->tags as $tag)
                                                <a href="#">{{ $tag->name }}</a>
                                            @endforeach
                                        </li>
                                        <li><span>Running time:</span> {{ $show->airing_time }}</li>
                                    </ul>

                                    <div class="card__description card__description--details">
                                        <p>{{ $show->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end card content -->
                        </div>
                    </div>
                </div>
                <!-- end content -->

                <!-- player -->
                @php
                    $videoUrl = $episode?->getFirstMediaUrl('episode_video', 'video');
                @endphp

                @if ($videoUrl)
                    <div class="col-12 col-xl-6">
                        <video controls crossorigin playsinline
                            poster="{{ $episode->getFirstMediaUrl('episode_cover', 'thumbnail') }}" id="player">
                            <source src="{{ $videoUrl }}" type="video/mp4">
                            <a href="{{ $videoUrl }}" download>Download</a>
                        </video>
                    </div>
                @else
                    <div class="col-12 col-xl-6">
                        <video controls crossorigin playsinline poster="{{ asset('frontend/img/sorry.png') }}"
                            id="player">
                            <source src="{{ $videoUrl }}" type="video/mp4">
                            <a href="{{ $videoUrl }}" download>Download</a>
                        </video>
                    </div>
                @endif
                <!-- end player -->

                <!-- accordion -->
                @if ($show->seasons->count() > 0)
                    <div class="col-12 col-xl-6">
                        <div class="accordion" id="accordion">

                            @foreach ($show->seasons as $index => $season)
                                @if ($season->episodes->count() > 0)
                                    @php
                                        $isCurrentSeason = $season->id == $currentSeasonId;
                                        $collapseId = 'collapseSeason' . $season->id;
                                        $headingId = 'headingSeason' . $season->id;
                                    @endphp

                                    <div class="accordion__card">
                                        <div class="card-header" id="{{ $headingId }}">
                                            <button type="button" class="{{ $isCurrentSeason ? '' : 'collapsed' }}"
                                                data-toggle="collapse" data-target="#{{ $collapseId }}"
                                                aria-expanded="{{ $isCurrentSeason ? 'true' : 'false' }}"
                                                aria-controls="{{ $collapseId }}">
                                                <span>Season: {{ $season->season_number }}</span>
                                                <span>{{ $season->episodes->count() }} Episodes</span>
                                            </button>
                                        </div>

                                        <div id="{{ $collapseId }}"
                                            class="collapse {{ $isCurrentSeason ? 'show' : '' }}"
                                            aria-labelledby="{{ $headingId }}" data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="accordion__list">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Title</th>
                                                            <th>Time</th>
                                                            <th>Day</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($season->episodes as $ep)
                                                            <tr class="{{ $ep->id == $currentEpisodeId ? 'active' : '' }}"
                                                                onclick="window.location='{{ route('episode.index', $ep) }}'">
                                                                <th>
                                                                    {{ $ep->episode_number }}
                                                                </th>
                                                                <td>
                                                                    {{ $ep->title }}
                                                                </td>
                                                                <td>
                                                                    {{ $ep->duration }}
                                                                </td>
                                                                <td>
                                                                    {{ $ep->airing_time }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                @endif
                <!-- end accordion -->

                <div class="col-12">
                    <div class="details__wrap">
                        <!-- availables -->
                        <div class="details__devices">
                            <span class="details__devices-title">Available on devices:</span>
                            <ul class="details__devices-list">
                                <li><i class="icon ion-logo-apple"></i><span>IOS</span></li>
                                <li><i class="icon ion-logo-android"></i><span>Android</span></li>
                                <li><i class="icon ion-logo-windows"></i><span>Windows</span></li>
                                <li><i class="icon ion-md-tv"></i><span>Smart TV</span></li>
                            </ul>
                        </div>
                        <!-- end availables -->

                        <!-- share -->
                        <div class="details__share">
                            <span class="details__share-title">Share with friends:</span>

                            <ul class="details__share-list">
                                <li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
                                <li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
                                <li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
                                <li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
                            </ul>
                        </div>
                        <!-- end share -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end details content -->
    </section>
    <!-- end details -->
@endsection

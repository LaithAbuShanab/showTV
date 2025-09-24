@extends('frontend.master')
@section('content')
    <!-- page title -->
    <section class="section section--first section--bg" data-bg="{{ asset('frontend/img/section/section.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__wrap">
                        <!-- section title -->
                        <h2 class="section__title">RANDOM TV SHOWS</h2>
                        <!-- end section title -->

                        <!-- breadcrumb -->
                        <ul class="breadcrumb">
                            <li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__item breadcrumb__item--active">Random Tv Shows</li>
                        </ul>
                        <!-- end breadcrumb -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->

    <!-- filter -->
    <div class="filter">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="filter__content">
                        <div class="filter__items">
                            <!-- filter item -->
                            <div class="filter__item" id="filter__genre">
                                <span class="filter__item-label">GENRE:</span>

                                <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <input type="button" value="{{ $tag->name ?? 'ALL / TAGS' }}">
                                    <span></span>
                                </div>

                                <ul class="filter__item-menu dropdown-menu scrollbar-dropdown"
                                    aria-labelledby="filter-genre">
                                    @foreach ($tags as $tag)
                                        <li data-tag-id="{{ $tag->id }}">{{ $tag->name }}</li>
                                    @endforeach
                                </ul>

                                <input type="hidden" id="selectedTag" name="tag_id" value="">
                            </div>
                            <!-- end filter item -->
                        </div>

                        <!-- filter btn -->
                        <button class="filter__btn" type="button">apply filter</button>
                        <!-- end filter btn -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end filter -->

    <!-- catalog -->
    <div class="catalog">
        <div class="container">
            <div class="row">
                @foreach ($randomly as $show)
                    <!-- card -->
                    <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                        <div class="card">
                            <div class="card__cover">
                                <img src="{{ $show->getFirstMediaUrl('show_cover', 'thumbnail') }}" alt="">
                                <a href="{{ route('show.index', $show->id) }}" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title"><a href="{{ route('show.index', $show->id) }}">{{ $show->title }}</a></h3>
                                <span class="card__category">
                                    @foreach ($show->tags ?? [] as $tag)
                                        <a href="#">{{ $tag->name }}</a>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                @endforeach
            </div>
        </div>
    </div>
    <!-- end catalog -->
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('[data-tag-id]').forEach(item => {
            item.addEventListener('click', function() {
                const tagName = this.textContent;
                const tagId = this.getAttribute('data-tag-id');

                document.querySelector('#selectedTag').value = tagId;
                document.querySelector('#filter-genre input[type="button"]').value = tagName;
            });
        });

        document.querySelector('.filter__btn').addEventListener('click', function() {
            const tagId = document.querySelector('#selectedTag').value;
            if (tagId) {
                window.location.href = `/random/filter?tag_id=${tagId}`;
            }
        });
    </script>
@endsection

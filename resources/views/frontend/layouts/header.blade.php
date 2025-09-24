<!-- header -->
<style>
    .search-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .search-popup-content {
        background: #222;
        padding: 20px;
        border-radius: 8px;
        width: 70%;
        max-height: 80%;
        overflow-y: auto;
        color: #fff;
        position: relative;
    }

    .close-popup {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 28px;
        cursor: pointer;
        color: #fff;
    }

    .search-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    border-bottom: 1px solid #333;
    cursor: pointer;
    color: #fff;           /* اللون الافتراضي للنص */
    text-decoration: none; /* يشيل الخط الأزرق */
}

.search-item img {
    width: 60px;
    border-radius: 4px;
}

.search-item:hover {
    background: #444;
    color: #ff0066; /* أو أي لون تحبه عند hover */
}

</style>

<header class="header">
    <div class="header__wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <!-- header logo -->
                        <a href="{{ route('home') }}" class="header__logo">
                            <img src="{{ asset('frontend/img/logo.svg') }}" alt="">
                        </a>
                        <!-- end header logo -->

                        <!-- header nav -->
                        <ul class="header__nav">
                            <!-- dropdown -->
                            <li class="header__nav-item <?php if (Route::currentRouteName() == 'home') {
                                echo 'header__nav-link--active';
                            } ?>">
                                <a href="{{ route('home') }}" class="header__nav-link">Home</a>
                            </li>

                            <li class="header__nav-item <?php if (Route::currentRouteName() == 'random.shows' || Route::currentRouteName() == 'random.filter') {
                                echo 'header__nav-link--active';
                            } ?>">
                                <a href="{{ route('random.shows') }}" class="header__nav-link">Random Shows</a>
                            </li>
                            <!-- end dropdown -->
                        </ul>
                        <!-- end header nav -->

                        <!-- header auth -->
                        <div class="header__auth">
                            <button class="header__search-btn" type="button">
                                <i class="icon ion-ios-search"></i>
                            </button>

                            <a href="signin.html" class="header__sign-in">
                                <i class="icon ion-ios-log-in"></i>
                                <span>sign in</span>
                            </a>
                        </div>
                        <!-- end header auth -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header search -->
    <form action="#" class="header__search" onsubmit="return false;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__search-content">
                        <input type="text" id="search-input"
                            placeholder="Search for a movie, TV Series that you are looking for">
                        <button type="button">search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end header search -->

</header>
<!-- end header -->

<!-- Search Popup -->
<div id="search-popup" class="search-popup" style="display:none;">
    <div class="search-popup-content">
        <span id="close-popup" class="close-popup">&times;</span>
        <h3 style="color:#fff;">Search Results</h3>
        <div id="popup-results"></div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        function doSearch() {
            let query = $('#search-input').val().trim();

            if (query.length > 1) {
                $.ajax({
                    url: "/search",
                    type: "GET",
                    data: { q: query },
                    success: function(data) {
                        let resultsDiv = $('#popup-results');
                        resultsDiv.empty();

                        if (data.shows.length > 0) {
                            resultsDiv.append("<h4>Shows</h4>");
                            data.shows.forEach(item => {
                                resultsDiv.append(`
                                    <a href="/show/${item.id}" class="search-item">
                                        <img src="${item.image}" alt="${item.title}">
                                        <div>
                                            <strong>${item.title}</strong><br>
                                            <small>${item.type}</small>
                                        </div>
                                    </a>
                                `);
                            });
                        }

                        if (data.episodes.length > 0) {
                            resultsDiv.append("<h4>Episodes</h4>");
                            data.episodes.forEach(item => {
                                resultsDiv.append(`
                                    <a href="/episode/${item.id}" class="search-item">
                                        <img src="${item.image}" alt="${item.title}">
                                        <div>
                                            <strong>${item.title}</strong><br>
                                            <small>${item.type}</small>
                                        </div>
                                    </a>
                                `);
                            });
                        }

                        if (data.shows.length === 0 && data.episodes.length === 0) {
                            resultsDiv.html("<p>No results found</p>");
                        }

                        // افتح البوب أب
                        $('#search-popup').fadeIn();
                    }
                });
            }
        }

        $('button[type="button"]').on('click', function() {
            doSearch();
        });

        $('#search-input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                doSearch();
            }
        });

        $('#close-popup').on('click', function() {
            $('#search-popup').fadeOut();
        });

        $(document).on('click', function(e) {
            if ($(e.target).is('#search-popup')) {
                $('#search-popup').fadeOut();
            }
        });
    });
</script>
@endsection


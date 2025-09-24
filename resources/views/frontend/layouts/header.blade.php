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
        color: #fff;
        text-decoration: none;
    }

    .search-item img {
        width: 60px;
        border-radius: 4px;
    }

    .search-item:hover {
        background: #444;
        color: #ff0066;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.1);
    }

    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #1c1c1c;
        border-radius: 6px;
        padding: 8px 0;
        min-width: 140px;
        display: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        z-index: 999;
    }

    .dropdown-item {
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        background: none;
        border: none;
        text-align: left;
        width: 100%;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .dropdown-item:hover {
        background-color: #ff0066;
        color: #fff;
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

                            @if (Auth::check())
                                <div class="header__user" style="position: relative;margin-left: 15px;">
                                    <div class="user-dropdown-toggle" id="userToggle"
                                        style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                        <img src="{{ Auth::user()->getFirstMediaUrl('avatar', 'user_avatar') ?: asset('frontend/img/default-avatar.png') }}"
                                            alt="Avatar" class="user-avatar">
                                        <span style="color: #fff;">{{ Auth::user()->name }}</span>
                                    </div>

                                    <div class="user-dropdown-menu" id="userDropdownMenu">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="header__sign-in">
                                    <i class="icon ion-ios-log-in"></i>
                                    <span>sign in</span>
                                </a>
                            @endif

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
        document.addEventListener("DOMContentLoaded", function() {

            const avatarInput = document.getElementById('avatar');
            const fileNameSpan = document.getElementById('file-name');
            const avatarPreview = document.getElementById('avatarPreview');

            if (avatarInput && fileNameSpan && avatarPreview) {
                avatarInput.addEventListener('change', function(event) {
                    const file = avatarInput.files[0];
                    if (file) {
                        fileNameSpan.textContent = file.name;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        fileNameSpan.textContent = "No file chosen";
                        avatarPreview.style.display = 'none';
                    }
                });
            }

            const toggle = document.getElementById('userToggle');
            const menu = document.getElementById('userDropdownMenu');

            if (toggle && menu) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                });

                document.addEventListener('click', function() {
                    menu.style.display = 'none';
                });
            }

            function doSearch() {
                const searchInput = $('#search-input');
                if (!searchInput.length) return;

                let query = searchInput.val().trim();

                if (query.length > 1) {
                    $.ajax({
                        url: "/search",
                        type: "GET",
                        data: {
                            q: query
                        },
                        success: function(data) {
                            const resultsDiv = $('#popup-results');
                            if (!resultsDiv.length) return;

                            resultsDiv.empty();

                            if (data.shows.length > 0) {
                                resultsDiv.append("<h4>Shows</h4>");
                                data.shows.forEach(item => {
                                    resultsDiv.append(`
                                    <a href="/show/${item.id}" class="search-item">
                                        <img src="${item.image}" alt="${item.title}" style="height: 90.06px;">
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
                                        <img src="${item.image}" alt="${item.title}" style="height: 90.06px;">
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

                            $('#search-popup').fadeIn();
                        }
                    });
                }
            }

            if ($('button[type="button"]').length) {
                $('button[type="button"]').on('click', function() {
                    doSearch();
                });
            }

            if ($('#search-input').length) {
                $('#search-input').on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        doSearch();
                    }
                });
            }

            if ($('#close-popup').length) {
                $('#close-popup').on('click', function() {
                    $('#search-popup').fadeOut();
                });
            }

            $(document).on('click', function(e) {
                if ($(e.target).is('#search-popup')) {
                    $('#search-popup').fadeOut();
                }
            });

            if (document.querySelectorAll('[data-tag-id]').length) {
                document.querySelectorAll('[data-tag-id]').forEach(item => {
                    item.addEventListener('click', function() {
                        const tagName = this.textContent;
                        const tagId = this.getAttribute('data-tag-id');

                        const selectedTag = document.querySelector('#selectedTag');
                        const genreBtn = document.querySelector(
                            '#filter-genre input[type="button"]');

                        if (selectedTag && genreBtn) {
                            selectedTag.value = tagId;
                            genreBtn.value = tagName;
                        }
                    });
                });
            }

            const filterBtn = document.querySelector('.filter__btn');
            if (filterBtn) {
                filterBtn.addEventListener('click', function() {
                    const selectedTag = document.querySelector('#selectedTag');
                    if (selectedTag && selectedTag.value) {
                        window.location.href = `/random/filter?tag_id=${selectedTag.value}`;
                    }
                });
            }

            const followBtn = document.querySelector('#follow-btn');
            if (followBtn) {
                $(document).ready(function() {
                    $('#follow-btn').on('click', function() {
                        let btn = $(this);
                        let showId = btn.data('show-id');

                        $.ajax({
                            url: "{{ route('show.follow') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                show_id: showId
                            },
                            success: function(response) {
                                if (response.status === 'followed') {
                                    btn.addClass('followed');
                                    btn.text('Unfollow');
                                } else {
                                    btn.removeClass('followed');
                                    btn.text('🤍 Follow');
                                }

                                const countText = response.count === 1 ? '1 follower' :
                                    response.count + ' followers';
                                $('#followers-count').text(countText);
                            },

                            error: function() {
                                alert('Something went wrong');
                            }
                        });
                    });
                });
            }

            const reactionIcon = document.querySelector('.reaction-icon');
            if (reactionIcon) {
                $(document).ready(function() {
                    $('.reaction-icon').on('click', function() {
                        const btn = $(this);
                        const episodeId = btn.data('episode');
                        const isLiked = btn.data('liked');

                        $.ajax({
                            url: "{{ route('episode.react') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                episode_id: episodeId,
                                is_liked: isLiked
                            },
                            success: function(res) {
                                if (res.success) {
                                    const container = btn.closest('.reaction-buttons');
                                    container.find('.reaction-icon').removeClass(
                                        'active');

                                    if (isLiked) {
                                        container.find('.like').addClass('active');
                                    } else {
                                        container.find('.dislike').addClass('active');
                                    }

                                    container.find('.like-count').text( '👍' + res.likes);
                                    container.find('.dislike-count').text('👎' + res.dislikes);
                                }
                            },
                            error: function() {
                                alert('Something went wrong.');
                            }
                        });
                    });
                });
            }
        });
    </script>
@endsection

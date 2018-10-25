@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        @include('pages.flash')
        @include('pages.errors')
        <div class="banner-user border-top">
            <div class="banner-contain">
                <div class="user_profile">
                    @if(isset($user->img_user))
                        <img src="{{ $user->img_user }}" alt="" class="avatar">
                        @else
                        <img src="/image/téléchargement.png" alt="" class="avatar">
                    @endif
                    <div class="profile_user_info">
                        <span class="username">{{ $user->name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-banner-end"></div>
        <div class="panel panel-primary" style="margin-top: 25px">
                <div class="panel-heading">
                    <h3 class="panel-title">Votre Profil</h3>
                    <div class="" style="text-align: right; margin-top: -20px">
                        <a class="btn btn-default" href="{{ route('settings.edit', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}">Editer</a>
                    </div>
                </div>
                <div class="panel-body">
                    <p>
                        <strong>Twitter Url:</strong>
                        @if(isset($user->url_twitter))
                            <a rel="nofollow" href="{{ $user->url_twitter }}">{{ $user->url_twitter }}</a>
                        @else
                            Aucuns Resultats
                        @endif
                    </p>
                    <p>
                        <strong>Facebook Url:</strong>
                        @if(isset($user->Facebook_twitter))
                            <a rel="nofollow" href="{{ $user->url_twitter }}">{{ $user->url_twitter }}</a>
                        @else
                            Aucuns Resultats
                        @endif
                    </p>
                    <p>
                        <strong>About:</strong>
                        @if(isset($user->about))
                            {{ $user->about }}
                            @else
                            Aucuns Resultats
                        @endif
                    </p>
                    <p class="info-group">
                        <strong>Hobbies:</strong>
                        @if(isset($user->hobbies))
                            {{ $user->hobbies }}
                        @else
                            Aucuns Resultats
                        @endif
                    </p>
                    <p>
                        <strong>Favorite Music:</strong>
                        @if(isset($user->favorite_music))
                            {{ $user->favorite_music }}
                        @else
                            Aucuns Resultats
                        @endif
                    </p>
                </div>
            </div>
        <div class="panel panel-default content-preview-container">
            <div class="panel-heading panel-wallpaper">
                <h2 class="panel-title">
                    <div>{{ $user->name }}'s Recent Wallpaper</div>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body center" style="margin-left: -25px">
                @if(isset($post))
                @foreach($post as $post)
                    <div class="col-sm-4">
                        <div class="thumb-container">
                            <div class="thumb-contain">
                                <div class="boxgrip">
                                    <a href="{{ route('picture.show', ['id' => $post->id])}}">
                                        <img height="250" width="350" class="" src="{{ $post->image->url_min }}" alt="Fond d'écran HD | Arrière-Plan ID:958080">
                                    </a>
                                </div>
                                <div class="hover-box">
                            <span class="thumb-info-big">
						        <span>{{ $post->image->size }}</span>&nbsp;&nbsp;
						        <a href="{{ route('picture.show', ['id' => $post->id])}}" title="{{ $post->title }}">{{ $post->title }}</a>&nbsp;&nbsp;
						        <a href="{{ route('cat.show', ['id' => $post->category->id])}}" title="{{ $post->category->name }} Fonds d'écran HD | Arrière-Plans">{{ $post->category->name }}</a>
					        </span>
                                </div>
                            </div>
                            <div class="extra-block"></div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="panel panel-default content-preview-container">
            <div class="panel-heading panel-wallpaper">
                <h2 class="panel-title">
                    <div>{{ $user->name }}'s Recent Wallpaper Favorite</div>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body center" style="margin-left: -25px">
                @if(isset($post_like))
                    @foreach($post_like as $post)
                        <div class="col-sm-4">
                            <div class="thumb-container">
                                <div class="thumb-contain">
                                    <div class="boxgrip">
                                        <a href="{{ route('picture.show', ['id' => $post->id])}}">
                                            <img height="250" width="350" class="" src="{{ $post->url_min }}" alt="Fond d'écran HD | Arrière-Plan ID:958080">
                                        </a>
                                    </div>
                                    <div class="hover-box">
                            <span class="thumb-info-big">
						        <span>{{ $post->size }}</span>&nbsp;&nbsp;
						        <a href="{{ route('picture.show', ['id' => $post->id])}}" title="{{ $post->title }}">{{ $post->title }}</a>&nbsp;&nbsp;
						        <a href="{{ route('cat.show', ['id' => $post->category_id])}}" title="{{ $post->name }} Fonds d'écran HD | Arrière-Plans">{{ $post->name }}</a>
					        </span>
                                    </div>
                                </div>
                                <div class="extra-block"></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="panel panel-default content-preview-container">
            <div class="panel-heading panel-wallpaper">
                <h2 class="panel-title">
                    <div>CrazyDiamond's Recent Users Follow</div>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body center" style="margin-left: -25px">
                    <div class="fan-container">
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                        <div class="user-container">
                            <h5>AlPha_GoD</h5>
                            <div class="avatar">
                                <a href="https://alphacoders.com/users/profile/76677">
                                    <img src="https://static.alphacoders.com/avatars/76677.jpg" alt="Avatar User ID: 76677" title="AlPha_GoD">
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        @include('pages.flash')
        @include('pages.errors')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $post->title }}</h3>
            </div>
            <div class="panel-body">
                <a href="{{$post->image->url_original}}"><img src="{{$post->image->url}}" alt="..." class="img-rounded" height="720" width="1100"></a>
                <div style="padding-top: 15px">
                    {!! Form::open(['method' => 'POST', 'url' => action('ActionPost@PostAction', ['id' => $post->id])]) !!}
                    @if(isset($likes->type))
                        <button type="submit" class="btn btn-danger" name="heart"><i class="fa fa-heart"></i> Remove Favorite</button>
                    @else
                        <button type="submit" class="btn btn-success" name="heart"><i class="fa fa-heart"></i> Favorite</button>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Info Picture</div>
            <div class="panel-body">
                <div class="wrapper-info">
                    <div class="info-position">
                        <div>
                            <h5 style="color: #000">
                                <b>Shared By:</b>
                            </h5>
                        </div>
                        <div class="info-container">
                            <div>
                                @if(isset($user->img_user))
                                    <img alt="{{ $user->name }} - Avatar" src="{{ $user->img_user }}">
                                    @else
                                    <img alt="{{ $user->name }} - Avatar" src="/image/téléchargement.png">
                                @endif
                            </div>
                            <div class="btn-group">
                                @if($user->id === \Illuminate\Support\Facades\Auth::id())
                                    <a href="{{ route('settings.index') }}" class="btn btn-default">
                                    <span class="glyphicon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                        {{ $user->name }}
                                    </a>
                                    @else
                                    <a href="{{ route('User', ['id' => $user->id]) }}" class="btn btn-default">
                                    <span class="glyphicon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                        {{ $user->name }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="wrapper-option">
                        <div class="wrapper-option-stats">
                            <div class="option-stats">
                                <h3 style="color: #000">
                                    500
                                    <br>
                                    <span class="glyphicon">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </h3>
                            </div>
                            <div class="option-stats">
                                <h3 style="color: #000">
                                    {{ $comments_count }}
                                    <br>
                                    <span class="glyphicon">
                                        <i class="fa fa-comments"></i>
                                    </span>
                                </h3>
                            </div>
                            <div class="option-stats">
                                <h3 style="color: #000">
                                    {{ $likes_count }}
                                    <br>
                                    <span class="glyphicon">
                                        <i class="fa fa-heart"></i>
                                    </span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <span class="nav">
                                    <span class="block">ID</span>
                                    <span class="block">Dimensions /</span>
                                    <span class="block">Size /</span>
                                </span>
                            </td>
                            <td>
								<span>
									<span class="block">180111 /</span>
									<span class="block">1920x1080 /</span>
                                    <span class="block">1.77 MB /</span>
                                    PNG
								</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="nav">Date Added</span>
                            </td>
                            <td>
								<span>
									<span title="2018-03-04 09:02:36"><span class="glyphicon "><i class="fa fa-calendar-alt"></i></span> 7 months, 14 days ago</span>
								</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="nav">Description Wallpaper</span>
                            </td>
                            <td>
								<span>
									<span title="{{ $post->content }}"> {{ $post->content }}</span>
								</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="nav">Recently Favorited By</span>
                            </td>
                            <td>
                                @foreach($likes_post_user as $user_like)
                                    @if($user_like->id === \Illuminate\Support\Facades\Auth::id())
                                        <a class="btn btn-default btn-favorite" href="{{ route('settings.index') }}">
                                            @if(isset($user_like->img_user))
                                                <img alt="" src="{{ $user_like->img_user }}">
                                                @else
                                                <img alt="" src="/image/téléchargement.png">
                                            @endif
                                            {{ $user_like->name }}
                                        </a>
                                        @else
                                        <a class="btn btn-default btn-favorite" href="{{ route('User', ['id' => $user_like->id]) }}">
                                            @if(isset($user_like->img_user))
                                                <img alt="" src="{{ $user_like->img_user }}">
                                            @else
                                                <img alt="" src="/image/téléchargement.png">
                                            @endif
                                                {{ $user_like->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h1>Commentaires</h1>
            <div class="panel panel-default" id="'.$f->id.'">
                @if(isset($comments))
                    @foreach($comments as $comment)
                        <div class="panel-body">
                            <h3><img src="/image/pika.jpg" class="img-circle" style="max-height: 100px; max-width: 100px" alt=""> {{ $comment->name }}</h3>
                            <div class="well">
                               {!! $comment->content !!}
                            </div>
                            <p class="text-right">
                                @if($comment->id === \Illuminate\Support\Facades\Auth::id())
                                    <a href="{{ route('settings.index') }}" class="btn btn-primary">Voir Profile</a>
                                @else
                                    <a href="{{ route('User', ['id' => $comment->users_id]) }}" class="btn btn-primary">Voir Profile</a>
                                @endif
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
            @guest
            <h2 class="center title-small">Connectez-Vous afin de permettre d'écrire un commentaire !!!</h2>
            @else
                {!! Form::open(['method' => 'POST', 'url' => action('ActionPost@PostAction', ['id' => $post->id])]) !!}
                <div class="form-group">
                    <label for="textArea" class="control-label">Ecrire votre commentaire</label>
                    <textarea class="form-control" rows="10" id="textArea" name="comments_add"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
                {!! Form::close() !!}
            @endguest
        </div>
        <div class="row" style="padding-top: 15px">
        <div class="center-block">
            <div class="separator-img"></div>
            <div>
            <h2 style="padding-left: 180px">
                <span class="glyphicon"><i class="fa fa-search"></i></span>
                Découvrez d'autres Fonds d'écran dans la Sous
                <a title="{{ $post->category->name }} Fonds d'écran" href="{{ route('cat.show', ['id' => $post->category->id]) }}">{{ $post->category->name }}</a>
            </h2>
                @foreach($post_all_cat as $post_cat)
                    @if($post_cat->id != $post->id)
                    <div class="thumb-img">
                        <a href="{{ route('picture.show', ['id' => $post_cat->id]) }}" title="Découvrez ce Fond d'écran de {{ $post_cat->category->name }}">
                            <img height="250" width="350" class="image-show-more" src="{{ $post_cat->image->url_min }}" alt="Wallpaper ID: {{ $post->id }}">
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection
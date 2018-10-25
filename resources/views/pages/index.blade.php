@extends('default')

@section('content')

<div class="container" style="padding-top: 25px">
<div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1 id="containers">Wallpaper</h1>
                    @include('pages.flash')
                    @include('pages.errors')
                </div>
                <div class="bs-component">
                    <div class="jumbotron">
                        <h1>Bienvenue</h1>
                        <p>Bien le bonjour chez visiteur, sur ce site tu pourras trouver un tas de wallpaper, fais toi plaisir !!!</p>
                        @guest
                            <p><a class="btn btn-primary btn-lg" href="{{ route('register') }}">S'inscrire</a></p>
                        @else
                            <p><a class="btn btn-primary btn-lg" href="{{ route('picture.create') }}">Ajouter une image</a></p>
                        @endguest
                    </div>
                    <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div></div>
            </div>
        </div>
    </div>
    <h1>Les Dernières photos !!!</h1>
    <div class="row">
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
						        <span>5120x2880</span>&nbsp;&nbsp;
						        <a href="{{ route('picture.show', ['id' => $post->id])}}" title="{{ $post->title }}">{{ $post->title }}</a>&nbsp;&nbsp;
						        <a href="{{ route('cat.show', ['id' => $post->category->id])}}" title="{{ $post->category->name }} Fonds d'écran HD | Arrière-Plans">{{ $post->category->name }}</a>
					        </span>
                        </div>
                    </div>
                    <div class="extra-block"></div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
@endsection

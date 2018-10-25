@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
    <h1>Ici vous pouvez trouver plus 500 wallpapers !!!</h1>
        @include('pages.flash')
        @include('pages.errors')
        {!! Form::open(['method' => 'get', 'url' => route('search')]) !!}
        <div class="input-group" id="search_zone_index">
                <input name="search" class="search-bar form-control input-lg" placeholder="Rechercher un Fond d'écran" type="text">
                @csrf
                <span class="input-group-btn">
                <button type="submit" class="btn-search-bar btn btn-default btn-lg">
                    <span class="glyphicon">
                        <i class="fa fa-search"></i>
                    </span>
                </button>
                </span>
            </div>
        {!! Form::close() !!}
        <h4 class="center">Rechercher des Fonds d'écran! Un Fond d'écran de Jeux Vidéo, de Dragon, ...</h4>
        <div class="list-group" style="padding-top: 15px">
            <div class="list-group-item list-group-item-info">Recherches par Catégories</div>
            @foreach($category as $cat)
                <a class="list-group-item" title="{{ $cat->name }} Fonds d'écran HD | Arrière-Plans - Wallpaper Abyss" href="{{ route('cat.show', ['id' => $cat->id]) }}">{{ $cat->name }}</a>
            @endforeach
            <a class="list-group-item list-group-item-success" href="{{ route('cat.index') }}">Voir toutes les Catégories</a>
            </div>
    <div class="row">
        @foreach($paginator as $post)
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
    </div>
        {{ $paginator->links() }}
    </div>
@endsection
@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        <h1>Voici les wallpapers de la catégorie "{{ $post_fetch->name }}"</h1>
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
    </div>
</div>
@endsection
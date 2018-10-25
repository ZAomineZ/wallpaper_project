@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        <h1 style="padding-bottom: 15px">Modifier Votre Image</h1>
        @include('pages.flash')
        @include('pages.errors')
        {!! Form::open(['method' => 'put', 'url' => route('picture.update' , ['id' => $post_find->id]), 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {!! Form::label('Title') !!}
            {!! Form::text('title', $post_find->title, ['class' => 'form-control', 'placeholder' => "Votre title", 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Description') !!}
            {!! Form::textarea('content', $post_find->content, ['class' => 'form-control', 'placeholder' => "Votre contenu de l'image", 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Category') !!}
            {!! Form::select('category_id', $cat, $post_find->category_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Modifier votre image') !!}
            {!! Form::file('image_id', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <div>
                <a href="{{ $post_image->url_original }}"><img height="150"  width="250" src="{{ $post_image->url_min }}" alt="" class="img-circle"></a>
            </div>
        </div>
        <button class="btn btn-primary">Envoyer</button>
        {!! Form::close() !!}
    </div>
@endsection
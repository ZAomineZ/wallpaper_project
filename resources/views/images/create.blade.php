@extends('default')

@section('content')
    <div class="container" style="padding-top: 50px">
        <h1 style="padding-bottom: 15px">Ajouter Votre Image</h1>
        @include('pages.flash')
        @include('pages.errors')
        {!! Form::open(['url' => route('picture.store'), 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {!! Form::label('Title') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => "Votre title", 'required' => true]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description') !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => "Votre contenu de l'image", 'required' => true]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Category') !!}
        {!! Form::select('category_id', $cat, null, ['class' => 'form-control']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Votre image') !!}
        {!! Form::file('image_id', null, ['class' => 'form-control']) !!}
    </div>
    <button class="btn btn-primary">Envoyer</button>
    {!! Form::close() !!}
@endsection

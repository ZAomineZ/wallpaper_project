@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        <h1 style="padding-bottom: 15px">Ajouter une catégorie</h1>
        @include('pages.flash')
        @include('pages.errors')
        {!! Form::open(['url' => route('cat.store')]) !!}
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => "Votre nom de catégorie", 'required' => true]) !!}
        </div>
        <button class="btn btn-primary">Envoyer</button>
    {!! Form::close() !!}
    </div>
@endsection

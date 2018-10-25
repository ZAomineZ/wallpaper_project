@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        @include('pages.flash')
        <h1>Admin Page</h1>
        <div class="jumbotron">
            <h1>Bienvenue sur votre Admin Page</h1>
            <p>Mais vous allez vous posez, " Quelle est cette page ?", ne paniquez pas !!! Cette page va vous permettre de modifier ou encore de suprimmer vos images et également vos catégories crée !!!</p>
        </div>
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li role="presentation" class="dropLi active">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Vos Images</a>
            </li>
            <li role="presentation" class="dropLi">
                <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Vos Catégories</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">
                <div style="padding-top: 25px">
                    <a class="btn btn-primary" type="submit" href="{{ route('picture.create') }}">Ajouter une image</a>
                </div>
                <div style="padding-top: 25px">
                    <table class="table panel panel-body">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Categorie</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($post as $post)
                            <tr id="id_posts">
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ substr($post->content, '0', '75') }} ...</td>
                                <td>{{ $post->category->name }}</td>
                                <td>
                                    <form action="">
                                        <a class="btn btn-primary" href="{{ route('picture.edit', ['id' => $post->id]) }}">Modifier</a>
                                    </form>
                                    {!! Form::open(['method' => 'DELETE', 'url' => route('picture.destroy' , ['id' => $post->id])]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab">
                <div style="padding-top: 25px">
                    <a class="btn btn-primary" type="submit" href="{{ route('cat.create') }}">Ajouter une catégorie</a>
                </div>
                <div style="padding-top: 25px">
                    <table class="table panel panel-body">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image associé</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cat as $cat)
                            <tr id="id_cats">
                                <td>{{ $cat->id }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>
                                    @if(isset($cat->images->url_original))
                                        <a class="btn btn-primary" href="{{ $cat->images->url_original }}">Voir-Ici</a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('cat.edit', ['id' => $cat->id]) }}">Modifier</a>
                                    {!! Form::open(['method' => 'DELETE', 'url' => route('cat.destroy' , ['id' => $cat->id])]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        <h1 class="title center">Les différentes catégories</h1>
        <div class="row" style="padding-top: 50px">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <table class="table panel panel-body">
                    <thead>
                    <tr>
                        <th>La Catégorie</th>
                        <th>Nombre d'images issue de la catégorie</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($category as $cat)
                    <tr id="search_20856254">
                        <td>
                            <h3>
                                <a title="{{ $cat->name }} Fonds d'écran HD | Arrière-Plans" href="{{ route('cat.show', ['id' => $cat->id]) }}">{{ $cat->name }}</a>
                            </h3>
                        </td>
                        <td>
                            <h3>{!! \App\Post::with('category')->where('category_id', $cat->id)->count('id') !!}</h3>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
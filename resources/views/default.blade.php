<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bootswatch: Cerulean</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{'/css/style.css' }}" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        @guest
        <form class="navbar-form navbar-right" method="put" action="{{ route('LogPage') }}">
            <div class="form-group">
                <input type="text" placeholder="Email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
        </form>
        @else
            <div class="nav navbar-nav navbar-right" style="padding-top: 5px">
                <ul class="nav navbar-nav">
                    <li class="dropdown" id="dropLog">
                        <a class="dropdown-toggle" href="#" id="themes" aria-expanded="true">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="themes">
                            <li><a href="{{ route('settings.index') }}">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa-home"></i>
                                    </span>
                                    Mon profile
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ route('picture.index') }}">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa-images"></i>
                                    </span>
                                    Mes images
                                </a>
                            </li>
                            <li><a href="#">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa-tags"></i>
                                    </span>
                                    Mes categories
                                </a>
                            </li>
                            <li><a href="#">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa-users"></i>
                                    </span>
                                    Mes Followers
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ route('Admin') }}">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa fa-pencil-alt"></i>
                                    </span>
                                    Editer ou ajouter une image
                                </a>
                            </li>
                            <li><a href="{{ route('Admin') }}">
                                    <span class="glyphicon" style="padding-right: 10px">
                                            <i class="fa fa-pencil-alt"></i>
                                    </span>
                                    Editer ou ajouter une category
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="" data-toggle="dropdown" href="{{ route('logout') }}" id="themes" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @endguest
        <div class="navbar-header">
            <a href="../" class="navbar-brand">Wallpaper Web</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
            <div class="navbar-collapse collapse" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="" href="{{ route('wallpaper') }}" id="">Wallpaper images</a>
                    </li>
                    <li class="dropdown">
                        <a class="" href="{{ route('cat.index') }}" id="">Wallpaper categories</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @yield('content')
    <footer style="padding-bottom: 30px">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="/js/ckeditor.js"></script>
        <script>
            $(document).ready(function(){
                $('#themes').click(function(){
                    $('#dropLog').toggleClass('open');
                });
                $('#myTabs a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                })
            });
            ClassicEditor
              .create(document.querySelector('#textArea')), {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            }
        </script>
    </footer>
</div>
</body>
</html>

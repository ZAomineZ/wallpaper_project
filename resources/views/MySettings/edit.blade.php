@extends('default')

@section('content')
    <div class="container" style="padding-top: 75px">
        @include('pages.flash')
        @include('pages.errors')
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li role="presentation" class="dropLi active">
                <a href="#personal" id="personal-tab" role="tab" data-toggle="tab" aria-controls="personal" aria-expanded="true">Personal Information</a>
            </li>
            <li role="presentation" class="dropLi">
                <a href="#password" role="tab" id="password-tab" data-toggle="tab" aria-controls="password" aria-expanded="false">Change Password</a>
            </li>
            <li role="presentation" class="dropLi">
                <a href="#avatar" role="tab" id="avatar-tab" data-toggle="tab" aria-controls="avatar" aria-expanded="false">Change Avatar</a>
            </li>
            <li role="presentation" class="dropLi">
                <a href="#username" role="tab" id="username-tab" data-toggle="tab" aria-controls="username" aria-expanded="false">Change Username</a>
            </li>
            <li role="presentation" class="dropLi">
                <a href="#account" role="tab" id="account-tab" data-toggle="tab" aria-controls="account" aria-expanded="false">Your Account</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active in" role="tabpanel" id="personal" aria-labelledby="personal-tab" style="padding-top: 25px">
                <div class="row">
                        <div class="panel">
                            <div class="panel-body">
                                {!! Form::open(['method' => 'POST', 'url' => route('settings.store')]) !!}
                                    <div class="form-group">
                                        <label class="lead">Email:</label>
                                        <span class="help-block">(A valid email is required if you ever need to recover your password.)</span>
                                        <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="lead">About Yourself:</label>
                                        @if(isset($user->about))
                                            <textarea name="about" class="form-control">{{ $user->about }}</textarea>
                                            @else
                                            <textarea name="about" class="form-control"></textarea>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="lead">Music You Enjoy:</label>
                                        @if(isset($user->favorite_music))
                                            <textarea name="favorite_music" class="form-control">{{ $user->favorite_music }}</textarea>
                                        @else
                                            <textarea name="favorite_music" class="form-control"></textarea>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="lead">Your Interests and Hobbies:</label>
                                        @if(isset($user->hobbies))
                                            <textarea name="hobbies" class="form-control">{{ $user->hobbies }}</textarea>
                                        @else
                                            <textarea name="hobbies" class="form-control"></textarea>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="lead">Social:</label>
                                        <blockquote><label>Twitter URL:</label>
                                            @if(isset($user->twitter_url))
                                                <input type="text" name="twitter_url" value="{{ $user->twitter_url }}" class="form-control">
                                            @else
                                                <input type="text" name="twitter_url" value="" class="form-control">
                                            @endif
                                            <br>
                                            <label>Facebook URL:</label>
                                            @if(isset($user->facebook_url))
                                                <input type="text" name="facebook_url" value="{{ $user->facebook_url }}" class="form-control">
                                            @else
                                                <input type="text" name="facebook_url" value="" class="form-control">
                                            @endif
                                        </blockquote>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-custom" type="submit"><span class="glyphicon"><i class="fa fa-pencil-alt"></i></span> Update Personal Information</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade" role="tabpanel" id="password" aria-labelledby="password-tab" style="padding-top: 25px">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Change Your Password</div>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['method' => 'POST', 'url' => route('settings.store')]) !!}
                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input class="form-control" name="password" type="password" value="" id="password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password:</label>
                                <input class="form-control" name="password_confirmation" type="password" value="" id="password_confirmation">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><span class="glyphicon"><i class="fa fa-pencil-alt"></i></span> Update Password!</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="avatar" aria-labelledby="avatar-tab" style="padding-top: 25px">
                <div class="panel">
                    <div class="panel-body">
                        {!! Form::open(['url' => route('settings.store'), 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="avatar">New Avatar:</label>
                                {!! Form::file('avatar', null, ['class' => 'form-control']) !!}
                            </div>
                        @if(isset($user->img_user))
                            <div class="form-group">
                                <label for="avatar">Your Avatar:</label>
                            </div>
                            <div style="padding-bottom: 25px;">
                                <a href="{{ $user->img_user }}"><img height="150" width="250" src="{{ $user->img_user }}" alt="" class="img-rounded img-avatar"></a>
                            </div>
                        @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><span class="glyphicon"><i class="fa fa-pencil-alt"></i></span> Submit Avatar!</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="alert alert-warning">
                        <ul>
                            <li>Avatars must be .jpg, .jpeg, .gif, or .png files.</li>
                            <li>Please note that browsers cache (save) images.  If your old avatar is still displaying on a page you can do a force refresh (ctrl + F5), or usually just wait a bit.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="username" aria-labelledby="username-tab" style="padding-top: 25px">
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'url' => route('settings.store')]) !!}
                        <label for="new_username"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Votre nouveau nom d'utilisateur</font></font></label>
                        <div class="input-group">
                            <input class="form-control" maxlength="24" name="new_username" type="text" id="new_username">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-warning">
                                        <b><span class="glyphicon"><i class="fa fa-pencil-alt"></i></span>
                                            <span class="hidden-xs">
                                                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Soumettre un</font></font></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> changement de </font><span class="hidden-xs"><font style="vertical-align: inherit;">nom</font></span></font></b>
                                    </button>
                                </span>
                        </div>
                    {!! Form::close() !!}
                    <br>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="account" aria-labelledby="account-tab" style="padding-top: 25px">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title center">Information sur vos activités</div>
                    </div>
                    <div class="row" style="padding-top: 50px">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                            <table class="table panel panel-body">
                                <thead>
                                <tr>
                                    <th>Info</th>
                                    <th>Nombre</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="search_20856254">
                                    <td>
                                        <h3>
                                            <a title="Mes Abonnements" href="">Mes Abonnements </a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3>10</h3>
                                    </td>
                                </tr>
                                <tr id="search_20856254">
                                    <td>
                                        <h3>
                                            <a title="Mes Followers" href="">Mes Followers </a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3>5</h3>
                                    </td>
                                </tr>
                                <tr id="search_20856254">
                                    <td>
                                        <h3>
                                            <a title="Mes Images" href="">Mes Images </a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3>10</h3>
                                    </td>
                                </tr>
                                <tr id="search_20856254">
                                    <td>
                                        <h3>
                                            <a title="Mes Catégories" href="">Mes Catégories </a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3>3</h3>
                                    </td>
                                </tr>
                                <tr id="search_20856254">
                                    <td>
                                        <h3>
                                            <a title="Mes Images Adorés" href="">Mes Images Adorés </a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3>3</h3>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
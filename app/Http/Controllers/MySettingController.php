<?php

namespace App\Http\Controllers;

use App\MySettings;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MySettingController extends Controller
{

    protected function User()
    {
        return DB::table('mysettings')
            ->select('id')
            ->where('users_id', Auth::id())
            ->first();
    }

    protected function UserSettingExists()
    {
        if($this->User()) {
            return DB::table('users')
                ->join('mysettings', 'users.id', '=', 'mysettings.users_id')
                ->select('*')
                ->where('users.id', Auth::id())
                ->first();
        } else {
            return DB::table('users')
                ->select('*')
                ->where('id', Auth::id())
                ->first();
        }
    }

    public function index()
    {
        $post = Post::with('category')->where('users_id', Auth::id())->limit(3)->orderByDesc('id')->get();
        $user = $this->UserSettingExists();
        $post_like =
            DB::table('likes')
            ->join('posts', 'likes.posts_id', '=', 'posts.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('images', 'posts.image_id', '=', 'images.id')
            ->select('images.url_min', 'posts.id', 'images.size', 'posts.title', 'categories.name', 'posts.category_id')
            ->where('likes.users_id', Auth::id())
            ->limit(3)
            ->orderByDesc('likes.id')
            ->get();
        return view('MySettings.index', compact('post', 'user', 'post_like'));
    }

    public function edit($id)
    {
        if($id != Auth::id()) {
            return redirect(route('settings.index'))->with('danger', 'Cette page n\'est pas sous vos droits !!!');
        }
        $user = $this->UserSettingExists();
        return view('MySettings.edit', compact('user'));
    }

    protected function password(Request $request)
    {
        if($request->password == $request->password_confirmation) {
            $user = User::findOrFail(Auth::id());
            if($user) {
                $user->update(['password' => Hash::make($request->password)]);
                return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez changez votre mot passe avec success !!!');
            }
        } else {
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('danger', 'Les mots passes ne sont pas identiques !!!');
        }
    }

    protected function settingsUser(Request $request)
    {
        $user_setting_exist = DB::table('mysettings')
            ->join('users', 'mysettings.users_id', '=', 'users.id')
            ->select('mysettings.id', 'users.email')
            ->where('mysettings.users_id', Auth::id())
            ->first();
        if($user_setting_exist) {
            $email = User::firstOrFail([Auth::id() => 'id']);
            DB::table('mysettings')->update([
                'about' => $request->about,
                'favorite_music' => $request->favorite_music,
                'hobbies' => $request->hobbies,
                'url_twitter' => $request->url_twitter,
                'url_facebook' => $request->url_facebook,
                'updated_at' => now()
            ]);
            if($user_setting_exist->email === $request->email) {
                return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez modifié vos informations personnels avec success !!!');;
            } else {
                $email->update(['email' => $request->email]);
            }
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez modifié vos informations personnels avec success !!!');
        } else {
            DB::table('mysettings')->insert([
                'about' => $request->about,
                'favorite_music' => $request->favorite_music,
                'hobbies' => $request->hobbies,
                'url_twitter' => $request->url_twitter,
                'url_facebook' => $request->url_facebook,
                'users_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez crée vos premières informations personnels !!!');

        }
    }

    protected function UsernameChange(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if($request->new_username === $user->name) {
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('danger', 'Ce name est déja utilisé sur votre compte !!!');;
        } else {
            $user->update(['name' => $request->new_username]);
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez modifié votre Username avec success !!!');;
        }
    }

    protected function ImageExist()
    {
        return DB::table('mysettings')
            ->select('img_user')
            ->where('users_id', Auth::id())
            ->first();
    }

    protected function Avatar(Request $request)
    {
        if($request->avatar->extension() != NULL) {
            if($request->avatar->extension() === 'png' || $request->avatar->extension() === 'gif' || $request->avatar->extension() === 'jpeg' || $request->avatar->extension() === 'jpg') {
                $img = 'ThumbUser-' . Auth::id() . '-' .$request->avatar->getClientOriginalName();
                $img_resize = \Intervention\Image\Facades\Image::make($request->file('avatar'));
                $img_size = $img_resize->resize(250, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img_size->save(public_path('image/User/' . '250x150' . '-' . $img ));
                if($this->ImageExist()) {
                    DB::table('mysettings')->update([
                        'img_user' => '/image/User/' . '250x150' . '-' . $img
                    ]);
                    return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez modifié votre photo avec success !!!');
                } else {
                    DB::table('mysettings')->insert([
                        'img_user' => '/image/User/' . '250x150' . '-' . $img,
                        'users_id' => Auth::id()
                    ]);
                    return redirect(route('settings.edit', ['id' => Auth::id()]))->with('success', 'Vous avez ajouté votre première photo !!!');
                }
            } else {
                return redirect(route('settings.edit', ['id' => Auth::id()]))->with('danger', 'Attention !!! L\'extension de cette image n\'est pas bonne, on accepte seulement les formats de type : ');
            }
        } else {
            return redirect(route('settings.edit', ['id' => Auth::id()]))->with('danger', 'Attention !!! L\'extension de cette image n\'est pas bonne, on accepte seulement les formats de type : ');
        }
    }

    protected function EmptyInput()
    {
        return redirect(route('settings.edit', ['id' => Auth::id()]))->with('danger', 'Des champs sont vides afin de valier votre requete !!!');
    }

    public function store(Request $request)
    {
        if($request->email) {
            return $this->settingsUser($request);
        } else {
            if(!empty($request->all())) {
                if($request->password) {
                    return $this->password($request);
                }
                if($request->new_username) {
                    return $this->UsernameChange($request);
                }
                if($request->hasFile('avatar')) {
                    return $this->Avatar($request);
                }
                else {
                    return $this->EmptyInput();
                }
            } else {
                return $this->EmptyInput();
            }
        }
    }
}

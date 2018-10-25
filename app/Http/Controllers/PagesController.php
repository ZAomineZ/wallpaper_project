<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function index()
    {
        $post = Post::with('category')->with('image')->limit(12)->orderByDesc('id')->get();
        return view('pages.index', compact('post'));
    }

    protected function User($id)
    {
        return DB::table('mysettings')
            ->select('id')
            ->where('users_id', $id)
            ->first();
    }

    protected function UserSettingExists($id)
    {
        if($this->User($id)) {
            return DB::table('users')
                ->join('mysettings', 'users.id', '=', 'mysettings.users_id')
                ->select('*')
                ->where('users.id', $id)
                ->first();
        } else {
            return DB::table('users')
                ->select('*')
                ->where('id', $id)
                ->first();
        }
    }

    public function UserProfile($id)
    {
        $post = Post::with('category')->where('users_id', $id)->limit(3)->get();
        $user = $this->UserSettingExists($id);
        $follow = DB::table('follow_user')->where('follow_users', $id)->where('users_id', Auth::id())->first();
        $post_like =
            DB::table('likes')
                ->join('posts', 'likes.posts_id', '=', 'posts.id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('images', 'posts.image_id', '=', 'images.id')
                ->select('images.url_min', 'posts.id', 'images.size', 'posts.title', 'categories.name', 'posts.category_id')
                ->where('likes.users_id', $id)
                ->limit(3)
                ->orderByDesc('likes.id')
                ->get();
        return view('pages.UserSetting.setting', compact('post', 'user', 'post_like', 'follow'));    }

    public function LogPage(Request $request)
    {
        if(!empty($request->all())) {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return redirect(route('home'))->with('success', 'Vous êtes maintenant connecté !!!');
                } else {
                    return redirect(route('home'))->with('danger', 'Le mot de passe ou l\'email n\'est pas bon !!!');
                }
            } else {
                return redirect(route('home'))->with('danger', 'Les champs sont vides !!!');
            }
        }

    public function Admin()
    {
        $post = Post::with('category')
            ->with('image')
            ->where('users_id', Auth::id())
            ->get();
        $cat = Category::with('images')
            ->where('users_id', Auth::id())
            ->get();
        return view('pages.PostOrCat', compact('post', 'cat'));
    }

    public function wallpaper()
    {
        $paginator = Post::with('category')->with('image')->paginate(12);
        $category = Category::limit(5)->get();
        return view('pages.wallpaper', compact('paginator', 'category'));
    }

    public function search(Request $request)
    {
        if(!empty($request->all())) {
            if($request->search) {
                $search = $request->search;
                $paginator = Post::with('category')->where('title', 'LIKE', '%' .$search. '%')->paginate(12);
                $post = DB::table('posts')
                    ->where('title', 'LIKE', '%' .$search. '%')
                    ->count('id');
                if($post > 0) {
                    return view('pages.search', compact('paginator', 'search', 'post'));
                } else {
                    return view('pages.search');
                }
            }
        }
    }
}

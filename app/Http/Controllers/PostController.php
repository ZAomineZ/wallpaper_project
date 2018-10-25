<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostImgRequest;
use App\Image;
use App\Post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index() {
        $paginator = Post::with('category')->with('image')->where('users_id', Auth::id())->paginate(12);
        return view('images.index', compact('paginator'));
    }

    public function create() {
        $cat = Category::pluck('name', 'id');
        return view('images.create', compact('cat'));
    }

    public function edit($id)
    {
        $post_find = Post::findOrFail($id);
        $cat = Category::pluck('name', 'id');
        $post_image = DB::table('images')
            ->join('posts', 'images.id', '=', 'posts.image_id')
            ->select('images.*')
            ->where('posts.id', $id)
            ->first();
        return view('images.edit', compact('post_find', 'cat', 'post_image'));
    }

    protected function SettingsExits($id)
    {
        return DB::table('mysettings')
            ->select('*')
            ->where('users_id', $id)
            ->first();
    }

    protected function UserPage($id)
    {
        if($this->SettingsExits($id)) {
            return DB::table('users')->join('mysettings', 'users.id', '=', 'mysettings.users_id')->select('users.id', 'users.name', 'mysettings.img_user')->where('users.id', $id)->first();
        } else {
            return DB::table('users')->select('*')->where('id', $id)->first();
        }
    }

    protected function UserLikeSettings($id)
    {
        if($this->SettingsExits(Auth::id())) {
            return DB::table('likes')->join('users', 'likes.users_id', '=', 'users.id')->join('mysettings', 'likes.users_id', '=', 'mysettings.users_id')->select('users.id', 'users.name', 'mysettings.img_user')->where('likes.posts_id', $id)->get();
        } else {
            return DB::table('likes')->join('users', 'likes.users_id', '=', 'users.id')->select('users.id', 'users.name')->where('likes.posts_id', $id)->get();
        }
    }

    protected function CreateImg(Request $request)
    {
        $img = 'thumb-' . Auth::id() . '-' .$request->image_id->getClientOriginalName();
        $img_resize = \Intervention\Image\Facades\Image::make($request->file('image_id'));
        $size_img = getimagesize($request->file('image_id'));
        // backup status
        $img_resize->backup();
        $img_1 = $img_resize->resize(1100, 720, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img_1->save(public_path('image/' . '1100x720' . '-' . $img ));
        // reset file
        $img_resize->reset();
        //new picture
        $img_2 = $img_resize->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img_2->save(public_path('image/' . '500x500' . '-' . $img ));
        $img_resize->reset();
        $img_resize->save(public_path('image/' . 'original' . '-' . $img ));
        return compact('size_img', 'img');
    }

    protected function ImageExist(Request $request, $id)
    {
        $img = $this->CreateImg($request);
        $image = DB::table('images')->where('id', $id)->update([
            'url' => '/image/' . '1100x720' . '-' . $img['img'] ,
            'url_min' => '/image/' . '500x500' . '-' . $img['img'] ,
            'url_original' => '/image/' . 'original' . '-' . $img['img'] ,
            'size' => $img['size_img'][0] . 'x' .$img['size_img'][1]
        ]);
        return $image;
    }

    public function show($id)
    {
        $post = Post::with('category')->with('image')->findOrFail($id);
        $post_all_cat = Post::with('category')->with('image')->where('category_id', $post->category_id)->get();
        $user = $this->UserPage($post->users_id);
        $likes = DB::table('likes')->select('*')->where('users_id', Auth::id())->where('posts_id', $id)->first();
        $likes_count = DB::table('likes')->select('id')->where('posts_id', $id)->count();
        $comments = DB::table('comments')->join('users', 'comments.users_id', '=', 'users.id')->select('*')->where('comments.posts_id', $id)->get();
        $comments_count = DB::table('comments')->select('id')->where('posts_id', $id)->count();
        $likes_post_user = $this->UserLikeSettings($id);
        return view('images.show', compact('post', 'user', 'likes', 'likes_count', 'comments', 'post_all_cat', 'comments_count', 'likes_post_user'));
    }

    public function store(PostImgRequest $request) {
        if(!empty($request->all())) {
            if($request->hasFile('image_id')) {
                $request->validated();
                $img = $this->CreateImg($request);
                $image = Image::create([
                    'url' => '/image/' . '1100x720' . '-' . $img['img'] ,
                    'url_min' => '/image/' . '500x500' . '-' . $img['img'] ,
                    'url_original' => '/image/' . 'original' . '-' . $img['img'] ,
                    'size' => $img['size_img'][0] . 'x' .$img['size_img'][1]
                ]);
                $post = Post::create([
                    'title' => $request->get('title'),
                    'content' => $request->get('content'),
                    'slug' => str_slug($request->get('title'), '-'),
                    'category_id' => $request->get('category_id'),
                    'image_id' => $image->id,
                    'users_id' => Auth::id()
                ]);
                $cat = DB::table('categories')->where('id', $post->category_id)->update(['images_id' => $image->id]);
                return redirect(route('picture.index'))->with('success', 'Votre image à bien été ajouté !!!');
            } else {
                return redirect(route('picture.create'))->with('danger', 'Des erreurs sont présentes !!!');
            }
        }
    }

    public function update($id, PostImgRequest $request)
    {
        if(!empty($request->all())) {
            $request->validated();
            $post = Post::findOrFail($id);
            $this->ImageExist($request, $post->image_id);
            $post->update(['title' => $request->get('title'),
                'content' => $request->get('content'),
                'slug' => str_slug($request->get('title'), '-'),
                'category_id' => $request->get('category_id'),
                'image_id' => $post->image_id,
                'users_id' => Auth::id()
            ]);
            return redirect(route('Admin'))->with('success', 'Votre image à était modifié avec success !!!');
        } else {
            return redirect(route('picture.edit'), ['id' => $id])->with('danger', 'Certains champs vides afin de valider votre requete !!!');
        }
    }


    public function destroy($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $delete = $post->delete();
        if($delete) {
            return redirect(route('Admin'))->with('success', 'Votre image à était supprimé avec success !!!');
        } else {
            return redirect(route('Admin'))->with('danger', 'La suppression de votre image à échouer !!!');
        }
    }
}

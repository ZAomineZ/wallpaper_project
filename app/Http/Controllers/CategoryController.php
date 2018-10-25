<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with('images')->paginate(15);
        return view('pages.categories', compact('category', 'fetch_count'));
    }

    public function show($id)
    {
        $paginator = Post::with('image')->with('category')->where('category_id', $id)->paginate(12);
        $post_fetch = DB::table('categories')->where('id', $id)->first();
        return view('categorie.show', compact('paginator', 'post_fetch'));
    }

    public function create()
    {
        return view('categorie.create');
    }

    public function update($id, Request $request)
    {
        if(!empty($request->all())) {
            DB::table('categories')->where('id', $id)->update([
                "name" => $request->name,
                "slug" => str_slug($request->name),
                "users_id" => Auth::id()
            ]);
            return redirect(route('Admin'))->with('success', 'Vous avez modifié votre catégorie avec success !!!');
        } else {
            return redirect(route('cat.edit', ['id' => $id]))->with('danger', 'Certaines conditions ne sont pas remplie afin de valier votre catégorie !!!');
        }
    }

    public function edit($id)
    {
        $cat_id = Category::findOrFail($id);
        return view('categorie.edit', compact('cat_id'));
    }

    public function destroy($id) {
        $cat = Category::findOrFail($id);
        $delete = $cat->delete();
        if($delete) {
            return redirect(route('Admin'))->with('success', 'Votre catégorie à était supprimé avec success !!!');
        } else {
            return redirect(route('Admin'))->with('danger', 'La suppression de votre image à échouer !!!');
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->all())) {
            Category::create([
                "name" => $request->name,
                "slug" => str_slug($request->name),
                "images_id" => 0,
                "users_id" => Auth::id()
            ]);
            return redirect(route('Admin'))->with('success', 'Vous avez crée votre catégorie avec success !!!');
        } else {
            return redirect(route('cat.create'))->with('danger', 'Certaines conditions ne sont pas remplie afin de valier votre catégorie !!!');
        }
    }
}

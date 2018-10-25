<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActionPost extends Controller
{

    protected function PostHeart($id, Request $request)
    {
        $like = DB::table('likes')->select('*')->where('users_id', Auth::id())->where('posts_id', $id)->first();
        if($like) {
            DB::table('likes')->where(['users_id' => Auth::id(), 'posts_id' => $id])->delete();
            return redirect(route('picture.show', ['id' => $id]))->with('danger', 'Vous avez supprimer cet wallpaper dans votre liste favorite !!!');
        } else {
            DB::table('likes')->insert([
                'type' => '1',
                'users_id' => Auth::id(),
                'posts_id' => $id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect(route('picture.show', ['id' => $id]))->with('success', 'Vous avez mis cette image dans votre liste favorite !!!');
        }
    }

    protected function CommentAdd($id, Request $request)
    {
        $request->validate(['comments_add' => 'required|min:10|max:350']);
        $comment = $request->comments_add;
        DB::table('comments')->insert(['content' => $comment, 'users_id' => Auth::id(), 'posts_id' => $id, 'created_at' => now(), 'updated_at' => now()]);
        return redirect(route('picture.show', ['id' => $id]))->with('success', 'Vous avez ajouté un commentaire avec success !!!');
    }

    protected function EmptyInput($id)
    {
        return redirect(route('picture.show', ['id' => $id]))->with('danger', 'Des champs sont vides afin de valier votre requete !!!');

    }

    protected function FollowUserExist($id)
    {
        return DB::table('follow_user')->select('id')->where('users_id', Auth::id())->where('follow_users', $id)->first();
    }

    protected function FollowAction($id, Request $request)
    {
        $follow = $this->FollowUserExist($id);
        if($follow) {
            $user = DB::table('users')->select('id', 'name')->where('id', $id)->first();
            DB::table('follow_user')->where('follow_users', $id)->where('users_id', Auth::id())->delete();
            return redirect(route('User', ['id' => $id]))->with('success', 'Vous suivez plus '.$user->name.' avec success !!!');
        } else {
            DB::table('follow_user')->insert(['follow_users' => $id, 'users_id' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
            $user = DB::table('users')->select('id', 'name')->where('id', $id)->first();
            return redirect(route('User', ['id' => $id]))->with('success', 'Vous suivez '.$user->name.' avec success !!!');
        }
    }

    public function PostAction($id, Request $request)
    {
        if($request->hasAny('heart')) {
            return $this->PostHeart($id, $request);
        } else {
            if($request->comments_add === "<p>&nbsp;</p>") {
                return $this->EmptyInput($id);
            } else {
                return $this->CommentAdd($id, $request);
            }
        }
    }

    public function Follow($id, Request $request) {
        if($request->hasAny('follow')) {
            return $this->FollowAction($id, $request);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tasklist;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザーを取得
            $user = \Auth::user();
            // ユーザーの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザーの投稿も取得するように変更しますが、現時点ではこのユーザーの投稿のみ取得します）
            $tasklist = $user->tasklist()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasklist' => $tasklist,
            ];
        }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        
        // 認証済みユーザー（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasklist()->create([
            'content' => $request->content,
        ]);
        
        // 前のURLへリダイレクトさせる
        return back();
    } 
    
    public function destroy(string $id)
    {
        // idの値で投稿を検索して取得
        $tasklist = Tasklist::findOrFail($id);
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
            return back()
                ->with('success','Delete Successful');
        }

        // 前のURLへリダイレクトさせる
        return back()
            ->with('Delete Failed');
    }
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    }
}
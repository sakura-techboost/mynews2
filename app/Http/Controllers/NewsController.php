<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // 全てのnewsテーブルを取得する->updated_atキーで降順(後ろから/つまり新しい順に)並べ替える
        $posts=News::all()->sortByDesc('updated_at');
        
        if(count($posts)>0){
            // $headlineに最新記事、それ以外を$postsに代入する
            $headline=$posts->shift();
        }else{
            $headline=null;
        }
        
        // news/index.blade.phpファイルを表示する
        // viewテンプレートにheadline,postsという変数を渡している
        return view('news.index',['headline'=>$headline,'posts'=>$posts]);
    }
    
    //
}

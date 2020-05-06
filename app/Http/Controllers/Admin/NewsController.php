<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Newsモデルを扱えるようにする
use App\News;
use App\History;
use Carbon\Carbon;

class NewsController extends Controller
{
    //
    public function add()
    {
        return view('admin.news.create');
    }
    /* Requestクラス
    　ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクトを取得できる。
    　例)ユーザーが入力したメールアドレス・パスワード・名前などだけでなく
    　使用したブラウザ(User Agent),送られたIP,どのURLからアクセスしたか等。
    　ログイン後の画面であれば会員認証において保存されたクッキーなども含まれる。
    　
    　これらの情報を$requestに代入して使用することができる。 */
    
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request,News::$rules);
        // newsインスタンスを作成する
        $news=new News;
        // formで入力された値を取得する
        $form=$request->all();
        
        /* フォームから画像が送信されてきたら保存して、$news->image_pathに画像のパスを保存する
        issetメソッド→因数の中にデータがあるかないかを判断する。
        fileメソッド→画像をアップロードする。
        storeメソッド→どこのフォルダにファイルを保存するかのパスを指定する
        上記のメソッドにより$path内に(public/image/ハッシュ化されたファイル名)が代入される
        basenameメソッド→ファイル名だけを取得する。以下ではimage_pathにファイル名のみを保存する。
        */
        
        if(isset($form['image'])){
            $path=$request->file('image')->store('public/image');
            $news->image_path=basename($path);
        }else{
            $news->image_path=null;
        }
        /* 以下、残りのtitleとbodyに値を代入してテーブルを保存する。
        $form変数の中には
        ["title"=>"タイトルの内容"
         "body"=>"本文の内容"
         "_token"=>"MRwPPawSebvocRdrOoLUrGo8ID6lTDRwfweenj3K"
         "image"=>UploadedFile]
        というデータが入っているが、_tokenとimageは不要
        unsetメソッド→送信されてきたデータの中で不要なものを削除する。
        結果$form=["title"=>"タイトルの内容","body"=>"本文の内容"]のみとなる。
        
        fillメソッド→配列をカラムに代入する。*/
         
         
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);
        
        //配列をカラムに代入しデータベースに保存する
        $news->fill($form);
        $news->save();
        // ニュース新規投稿画面にリダイレクトする
        return redirect('admin/news/create');
    }
    
    
    /* ※cond_title→index.blade.php内で入力された検索ワードデータの名前
    whereメソッド→テーブル内の条件に一致したレコードを配列の形で取得することができる
   
    $posts=News::where('title',$cond_title)->get();
    newsテーブルの中のtitleカラムで$cond_title(ユーザーが入力した文字)に一致する
    レコードをすべて取得し、変数$postsに代入する
    
    $posts=News::all();
    Newsモデルを使ってデータベースに保存されているnewsテーブルのレコード(インスタンス)を
    すべて取得して$postsに代入する */
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
          // 検索されたら検索結果を取得する
            $posts = News::where('title', $cond_title)->get();
        } else {
          // それ以外はすべてのニュースを取得する
            $posts = News::all();
        }
        /* 上記で取得したレコード($posts)とユーザーが入力した文字列($cond_title)を
        index.blade.phpに渡してページを開く。*/
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $news = News::find($request->id);
        // データが空なら中断する
        if (empty($news)) {
          abort(404);    
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request,News::$rules);
        // News Modelからデータを取得する
        $news=News::find($request->id);
        // 送信されてきたフォームデータを格納する
        $news_form=$request->all();
        // 画像を変更した場合の処理
        // 画像がほかのものに変更された場合、上書き保存をする
        if(isset($news_form['image'])){
            $path=$request->file('image')->store('public/image');
            $news->image_path=basename($path);
            unset($news_form['image']);
        }elseif(isset($request->remove)){
            /*画像が取り除かれた(削除された)場合、image_passデータはnullになり、
            imageデータはnullable(空欄でも保存可能)なためわざわざremoveという記録を残さずに空欄のまま保存する*/
            $news->image_path=null;
            unset($news_form['remove']);
        }
        unset($news_form['_token']);
        
        // 該当するデータを上書きして保存する
        $news->fill($news_form)->save();
        
        //HistoryModelにも編集履歴を追加する
        $history=new History;
        $history->news_id=$news->id;
        $history->edited_at=Carbon::now();
        $history->save();
        
        return redirect('admin/news/');
    }
    
    // データを削除する
    public function delete(Request $request)
    {
        // 該当するNewsモデルを取得
        $news=News::find($request->id);
        // 削除する
        $news->delete();
        // ニュース一覧画面に戻る
        return redirect('admin/news/');
    }
}

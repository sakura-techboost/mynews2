<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    /*【応用】 ProfileControllerを編集して、
    admin/profile/createから送信されてきたフォーム情報を
    データベースに保存するようにしましょう。*/
    
    // フォーム情報をデータベースに保存する
    public function create(Request $request)
    {
        $this->validate($request,Profile::$rules);
        $profile=new Profile;
        $form=$request->all();
        
        unset($form['_token']);
        $profile->fill($form)->save();
        
        return redirect('admin/profile/create');
    }
    
    //プロフィール検索アクション
    public function index(Request $request)
    {
        $cond_name=$request->cond_title;
        if($cond_name != ''){
            $posts=Profile::where('name',$cond_name)->get();
        }else{
            $posts=Profile::all();
        }
        return view('admin.profile.index',['posts'=>$posts,'cond_name'=>$cond_name]);
    }
    // プロフィール操作アクション(編集・削除)
    public function edit(Request $request)
    {
        $profile=Profile::find($request->id);
        if (empty($profile)){
            abort(404);
        }
        return view('admin.profile.edit',['profile_form'=>$profile]);
    }
    // プロフィールの更新アクション
    public function update(Request $request)
    {
        $this->validate($request,Profile::$rules);
        $profile=Profile::find($request->id);
        $profile_form=$request->all();
        unset($profile_form['_token']);
        $profile->fill($profile_form)->save();
        
        $history=new ProfileHistory;
        $history->profile_id=$profile->id;
        $history->edited_at=Carbon::now();
        $history->save();
        
        return redirect('admin/profile');
    }
    
    // プロフィールの削除アクション
    public function delete(Request $request)
    {
        $profile=Profile::find($request->id);
        $profile->delete();
        return redirect('admin/news/');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

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
    public function edit(Request $request)
    {
        $profile=Profile::find($request->id);
        if (empty($profile)){
            abort(404);
        }
        return view('admin.profile.edit',['profile_form'=>$profile]);
    }
    public function update(Request $request)
    {
        $this->validate($request,Profile::$rules);
        $profile=Profile::find($request->id);
        $profile_form=$request->all();
        unset($profile_form['_token']);
        $profile->fill($profile_form)->save();
        return redirect('admin/profile/edit');
    }
}

{{--4. 【応用】 プロフィール作成画面用に、--}}
{{--resources/views/admin/profile/create.blade.php ファイルを作成し、--}}
{{--3. で作成した profile.blade.phpファイルを読み込み、また --}}
{{--プロフィールのページであることがわかるように titleとcontentを編集しましょう。--}}
{{--（ヒント: resources/views/admin/news/create.blade.php を参考にします。）--}}


{{-- layouts/profile.blade.phpを読み込む --}}
@extends('layouts.profile')


{{-- profile.blade.phpの@yield('title')に埋め込む --}}
@section('title', 'プロフィールの新規作成')

{{-- profile.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>Myプロフィール</h2>
                <form action="{{ action('Admin\ProfileController@create') }}" method="post" >
                    @if(count($errors) >0)
                       <ul>
                           @foreach($errors->all()  as $e)
                              <li>{{ $e }}</li>
                           @endforeach
                       </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">氏名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">性別</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="gender" value="{{ old('gender') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">趣味</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="hobby" value="{{ old('hobby') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">自己紹介</label>
                        <div class="col-md-10">
                           <textarea class="form-control" name="introduction" rows="20" value="{{ old('introduction') }}"></textarea>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
            </div>
        </div>
    </div>
@endsection
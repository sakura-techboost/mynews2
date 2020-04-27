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
            </div>
        </div>
    </div>
@endsection
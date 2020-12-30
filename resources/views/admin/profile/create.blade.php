{{--第７部の課題４ プロフィール作成画面用に、resources/views/admin/profile/create.blade.php ファイルを作成し、
３で作成した profile.blade.phpファイルを読み込み、また プロフィールのページであることがわかるように titleとcontentを編集しましょう。--}}

{{-- layouts/profile.blade.phpを読み込む --}}
@extends('layouts.profile')


{{-- profile.blade.phpの@yield('title')に'プロフィール'を埋め込む --}}
@section('title', 'プロフィール')

{{-- profile.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>My プロフィール</h2>
{{-- resources/views/admin/profile/create.blade.php を編集して、--}}
{{--氏名(name)、性別(gender)、趣味(hobby)、自己紹介欄(introduction)を入力するフォームを作成してください。--}}
{{--また、formの送信先(<form action=”この部分”>)を、Admin\ProfileController の create Action に指定してください。--}}

        <form action="{{ action('Admin\ProfileController@create') }}" method="post" enctype="multipart/form-data">
          @if (count($errors) > 0)
            <ul>
              @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          @endif
          <div class="form-group row">
            <label class="col-md-2" for="name">名前</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2" for="gender">性別</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="gender" value="{{ old('gender') }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2" for="hobby">趣味</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="hobby" value="{{ old('hobby') }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-2" for="introduction">自己紹介</label>
            <div class="col-md-10">
              <textarea class="form-control" name="introduction" rows="20">{{ old('introduction') }}</textarea>
            </div>
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary" value="更新">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

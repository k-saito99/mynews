<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    
  public function add()
  {
        return view('admin.news.create');
  }


  public function create(Request $request)
  {

     // 以下を追記
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $news = new Profile;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$profile->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $profile->image_path = basename($path);
      } else {
          $news->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $profile->fill($form);
      $profile->save();


      // admin/profile/createにリダイレクトする
      return redirect('admin/profile/create');
  } 

  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのプロフィールを取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }


  public function edit(Request $request)
  {
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }


  public function update(Request $request)
  {
    $this->validate($request, Profile::$rules);
    $profile = Profile::find($request->input('id'));
    $profile_form = $request->all();
    if ($request->input('remove')) {
        $profile_form['image_path'] = null;
    } elseif ($request->file('image')) {
        $path = $request->file('image')->store('public/image');
        $profile_form['image_path'] = basename($path);
    } else {
        $profile_form['image_path'] = $profile->image_path;
    }

    unset($profile_form['_token']);
    unset($profile_form['image']);
    unset($profile_form['remove']);
    $profile->fill($profile_form)->save();

    // 以下を追記
    $profile_history = new ProfileHistory;
    $profile_history->profile_id = $profile->id;
    $profile_history->edited_at = Carbon::now();
    $profile_history->save();

    return redirect('admin/profile');
  }


  public function delete(Request $request)
  {
      // 該当するProfile Modelを取得
  $profile = Profile::find($request->id);
      // 削除する
  $profile->delete();
  return redirect('admin/profile/');
  }  

}

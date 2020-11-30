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
        return view('admin.profile.create');
}

public function create(Request $request)
{
        return redirect('admin/profile/create');
}

public function edit()
{
        return view('admin.profile.edit');
}

public function update(Request $request)
{
        
     $this->validate($request, Profile::$rules);
     
     $profile = Profile::find($request->id);
     
     $profile_form = $request->all();
     unset($profile_form['_token']);
     
     $profile->fill($profile_form)->save();
     
     
     $profile_history = new ProfileHistory;
     $profile_history->profile_id = $profile->id;
     $profile_history->edited_at = Carbon::now();
     $profile_history->save();
        
        
        
        
        return redirect('admin/profile/');
 }  //
}

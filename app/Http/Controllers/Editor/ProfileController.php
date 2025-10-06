<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Validator;
use Hash;
use File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use View;
use App\Models\Branch;
use Carbon\Carbon;


class ProfileController extends Controller
{
   
    public function show()
    {
    	return view ('editor.profile.detail');
    }

    public function delete_image(UserRepository $UserRepository)
    {
        $UserRepository->delete_image(Auth::user()->id);
        return redirect('editor/profile');
    }

    public function edit()
    {
    	return view ('editor.profile.edit');
    }

    public function update(Request $request)
    {
    	$data = array(
            'email' => $request->input('email'), 
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'), 
            );

        $rules = [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => '',
        ];

        if($request->image)
        {
            $data['image'] = $request->image;
            $rules['image'] = 'image|between:0, 5000';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {   
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            // dd($request->input());
            // $this->UserRepository->update(Auth::user()->id, $request->input());

            $user = User::where('id', Auth::user()->id)->first();
            $user->email = $request->input('email');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');            
     
            $user->save();

            if($request->image)
            {
                // $this->UserRepository->update_image(Auth::user()->id, $request->image);
                $user = User::FindOrFail(Auth::user()->id);

                $original_directory = "uploads/user/".$user->username."/";
                
                if(!File::exists($original_directory))
                {
                    File::makeDirectory($original_directory, $mode = 0777, true, true);
                }
                $file_extension = $request->image->getClientOriginalExtension();
                $user->filename = Carbon::now()->format("d-m-Y h-i-s").$request->image->getClientOriginalName();
                
                $thumbnail_directory = $original_directory."thumbnail/";
                if(!File::exists($thumbnail_directory))
                {
                    File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
                }
                // $thumbnail = Image::make($original_directory.$user->filename);
                // $thumbnail->fit(300,300)->save($thumbnail_directory.$user->filename);
                $request->image->move($thumbnail_directory, $user->filename);

                $user->save();
            }
 
            return redirect('editor/profile');
        }
    }

    public function edit_password()
    {
        return view ('editor.profile.password');
    }

    public function update_password(Request $request, UserRepository $UserRepository)
    {
        $data = array(
            'password_current' => $request->input('password_current'), 
            'password_new' => $request->input('password_new'),
            'password_new_confirmation' => $request->input('password_new_confirmation'), 
            );

        $rules = [
            'password_current' => 'required',
            'password_new' => 'required|confirmed',
            'password_new_confirmation' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {   
            return redirect()->back()->withInput()->withErrors(['New password confirmation failed!']);
        } else {
            
            $user = $UserRepository->get_one(Auth::user()->id);
            
            if(Hash::check($request->input('password_current'), $user->password))
            {
                $UserRepository->change_password(Auth::user()->id, $request->input('password_new'));

                return redirect('editor/profile');
            } else {
                return redirect()->back()->withInput()->withErrors(['Current password mismatch!']);
            }
        }
    }
}

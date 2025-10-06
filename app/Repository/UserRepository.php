<?php

namespace App\Repository;
use DB;
use File;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Http\Controllers\Controller;


class UserRepository
{
    public function get_all()
    {
        return User::all();
    }

    public function get_one($id)
    {
        return User::FindOrFail($id);
    }

    public function store($data)
    {
        $user = new User;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return $user;
    }

    public function update($id, $data)
    {
        $user = User::find($id);
        $user->email = $data['email'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];            
 
        $user->save();
        return $user;
    }

    public function update_image($id, $image)
    {
        $user = User::FindOrFail($id);

        $original_directory = "uploads/user/".$user->username."/";
        
        if(!File::exists($original_directory))
        {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
        }
        $file_extension = $image->getClientOriginalExtension();
        $user->filename = Carbon::now()->format("d-m-Y h-i-s").$image->getClientOriginalName();
        $image->move($original_directory, $user->filename);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
        {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
        }
        $thumbnail = Image::make($original_directory.$user->filename);
        $thumbnail->fit(300,300)->save($thumbnail_directory.$user->filename);

        $user->save();
        return $user;
    }

    public function delete_image($id)
    {
        $user = User::FindOrFail($id);
        $user->filename = null;
        $user->save();
    }

    public function change_password($id, $password)
    {
        $user = User::FindOrFail($id);
        $user->password = bcrypt($password);

        $user->save();
    }

    public function delete($id)
    {
        User::FindOrFail($id)->delete();
    }
}
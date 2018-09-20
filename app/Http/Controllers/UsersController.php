<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;


class UsersController extends Controller
{	

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }


    public function show(User $user)
    {
       return view('users.show',compact('user'));
    }


    public function edit(User $user)
    { 	
    	$this->authorize('update',$user);
    	return view('users.edit',compact('user'));
    }

    public function update(UserRequest $Request,ImageUploadHandler $uploader,User $user)
    { 	
    	// dd($Request->avatar);
    	$this->authorize('update', $user);
	    $data = $Request->all();
	   if ($Request->avatar) {
            $result = $uploader->save($Request->avatar, 'avatars', $user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

    	$user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

}

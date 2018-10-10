<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use Auth;

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

    public function attention($user_id)
    {   

        $user = Auth::user();

        if( $user->isAttention($user_id) )
        {
            $user->unfollow($user_id);
        }
        else
        {
            $user->follow($user_id);
        }   

        return redirect()->back();

    }

    public function attentions_or_followers_list(User $user,$type='attentions')
    {     
        return view('users.list',compact('user','type'));
    }



     public function activation($token,User $user)
    {   

        if(!empty( $user_info = $user->where('activation_token',$token)->firstOrFail() )){ 
            $user_info->activation  = true;
            $user_info->activation_token = null;

            if( $user_info->save() ){ 

                if( Auth::check() )
                {
                    session()->flash('success','恭喜你,激活成功'); 
                    return redirect()->route('users.show',[$user_info]);  

                }else{ 

                    session()->flash('danger','激活失敗,请登录账号'); 
                    return redirect()->route('root');
                }
                
            }else{
                session()->flash('danger','激活失敗,此账号无需激活'); 
                return redirect()->route('root');
            }

        }

       // $user->activation($token);
    }

    //激活提示页面
    public function activation_view(User $user)
    {   
        return view('users.activation',compact('user'));
    }

    //激活发送邮件
    public function send_activation_email(User $user)
    {   
        if($user->sendEmailConfirmationTo($user))
        { 
            return true;;
        }
        
    }

}

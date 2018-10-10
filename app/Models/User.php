<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Mail;

class User extends Authenticatable
{
    use Notifiable,HasRoles,Traits\ActiveUserHelper,Traits\LastActivedAtHelper{
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function topics()
    { 
        return $this->hasMany(Topic::class);
    }

     public function isAuthorOf($model)
    { 
        return $this->id == $model->user_id;
    }

    //一个用户多个回复
    public function replies()
    { 
        return $this->hasMany(Reply::class);
    }


    //重写了这个函数 这个函数原本是有自带的
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        $this->increment('notification_count');

        $this->laravelNotify($instance);
    }

     public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function setPasswrdAttribute($value)
    {   
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
    

    //多对多 用户粉丝关联
    public function followers()
    { 
        return $this->belongsToMany(User::class,'followers','user_id','follower_id')->withTimestamps();

    }

    //多对多 用户关注关联
    public function attention()
    { 
        return $this->belongsToMany(User::class,'followers','follower_id','user_id')->withTimestamps();
    }

    //关注用户
    public function follow($user_ids)
    { 
        $user_ids = is_array($user_ids) ? $user_ids : compact('user_ids');
       
        if(!empty($user_ids)) $this->attention()->sync($user_ids,false);         

    }

    //取消关注
    public function unfollow($user_ids)
    { 
        $user_ids = is_array($user_ids) ? $user_ids : compact('user_ids');

        if(!empty($user_ids)) $this->attention()->detach($user_ids);

    }

    //判断是否已经关注
    public function isAttention($user_id)
    {   
        return $this->attention->contains($user_id);        
    }


    //判断是否激活
    public function isActivation($user_id)
    {   
        if(!empty($user = $this->find($user_id) ))
        {
            if(!empty($user->activation_token) && !isset($user->activation))
            { 
                //activation_token不为空 跟 activation状态为false(未激活)
                session()->flash('information','账号未激活请先激活');
                return redirect()->route('confirm_email');

            }elseif( empty($user->activation_token) && isset($user->activation) ){ 
                //activation_token为空 跟 true(激活)
                return true;
            }

        }else{
            session()->flash('error','没有此账号');
            return redirect()->back();
        }

    }

    //激活用户
    // public function activation($token)
    // {   

    //     if(!empty( $user = $this->where('activation_token',$token)->firstOrFail() )){ 
    //         $user->activation  = true;
    //         $user->activation_token = null;

    //         if( $user->save() ){ 

    //             if( Auth::check() )
    //             {
    //                 session()->flash('success','恭喜你,激活成功'); 
    //                 return redirect()->route('users.show',[$user]);  

    //             }else{ 

    //                 session()->flash('error','激活失敗,请登录账号'); 
    //                 return redirect()->route('/');
    //             }
                
    //         }else{
    //             session()->flash('error','激活失敗,此账号无需激活'); 
    //             return redirect()->route('/');
    //         }

    //     }

    // }


    //发送注册邮件
    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '460667926@qq.com';
        $name = 'Ming';
        $to = $user->email;
        $subject = "感谢注册 Drip memory 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function is_Activation($user_id)
    {   
        return $this->where('user_id',$user_id)->get(['activation']);
    }




}

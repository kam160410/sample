<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use PhpParser\Node\Stmt\Return_;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //是否已经关注
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    //关注
    public  function follow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_id = compact('user_ids');
        }
        return $this->followings()->sync($user_ids,false);
    }

    //取消关注
    public function unfollow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        return $this->followings()->detach($user_ids);
    }

    //获取粉丝  (多对一)
    public  function followers()
    {
        return $this->belongsToMany(User::Class,'followers','user_id','follower_id');
    }

    //获取关注人(自己关注别人)  一对多
    public function followings()
    {
        return $this->belongsToMany(User::Class,'followers','follower_id','user_id');
    }


    public function feed()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
    }

    public  function statuses()
    {
        return $this->hasMany(Status::class);
    }


    /**
     * 生成动态令牌
     * @param string $size
     * @return string
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 用户头像生成
     * @param string $size
     * @return string
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 生成验证token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}

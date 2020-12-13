<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //نستخدم هذه الدالة للسماح للارافيل بتخزين هذه البيانات في قاعدة البيانات واخبارها بأنها آمنة
    protected $fillable = [
        'title','body','user_id','excerpt','is_published','created_at','updated_at'
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

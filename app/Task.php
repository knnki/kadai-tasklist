<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //2019.6.11追記
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

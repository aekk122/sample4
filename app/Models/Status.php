<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = "statuses";

    protected $fillable = ['content'];

    public function belongsToUser() {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'picture',
    ];

    protected $dates = ['deleted_at'];

    /**
     * getPictureAttribute so we have full url every where
     * @return string
     */
    public function getPictureAttribute() {
        if ( !empty($this->attributes['picture']) ) {
           return asset('storage/pictures') . '/' .$this->attributes['picture'];
        }
        return asset('storage/pictures') . '/user.png';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function team() {
        return $this->hasMany(PlayerTeam::class, 'team_id', 'id');
    }
}

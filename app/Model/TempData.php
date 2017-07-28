<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    protected $fillable = [
        'data', 'updated', 'created'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

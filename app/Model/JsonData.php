<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class JsonData extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'data_json', 'created', 'user_id', 'iCalUID', 'location', 'status',
        'summary', 'updated', 'creator', 'organizer', 'start', 'end', 'htmlLink'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}

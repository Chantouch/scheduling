<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Meeting extends Model
{
    use SoftDeletes;
    protected $appends = ['hashid'];
    protected $fillable = [
        'date', 'time', 'subject', 'related_org', 'location', 'user_id', 'ampm'
    ];

    protected $dates = ['date'];

    public static function rules()
    {
        return [
            'date' => 'required|date'
        ];
    }

    public static function messages()
    {
        return [

        ];
    }

    /**
     * @return string
     */
    public function getDateAttribute()
    {
        return $this->attributes['date'] = Carbon::parse($this->attributes['date'])->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getTimeAttribute()
    {
        return $this->attributes['time'] = Carbon::parse($this->attributes['time'])->format('H:i');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getHashIdAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
}

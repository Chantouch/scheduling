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
        'date', 'start_time', 'end_time', 'subject', 'related_org', 'location', 'user_id', 'ampm'
    ];

    protected $dates = ['date'];

    public static function rules()
    {
        return [
            'date' => 'required|date',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
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
        return $this->attributes['date'] = Carbon::parse($this->attributes['date'])->format('d-m-Y');
    }

    /**
     * @return string
     */
    public function getStartTimeAttribute()
    {
        return $this->attributes['start_time'] = Carbon::parse($this->attributes['start_time'])->format('H:i');
    }

    /**
     * @return string
     */
    public function getEndTimeAttribute()
    {
        return $this->attributes['end_time'] = Carbon::parse($this->attributes['end_time'])->format('H:i');
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

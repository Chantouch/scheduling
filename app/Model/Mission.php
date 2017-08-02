<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Mission extends Model
{
    use SoftDeletes;
    protected $appends = ['hashid'];
    protected $fillable = [
        'start_date', 'end_date', 'leader', 'mission', 'offer_to', 'user_id', 'created', 'updated', 'location'
    ];
    protected $dates = ['end_date', 'start_date'];

    public static function rules()
    {
        return [
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date'
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
    public function getEndDateAttribute()
    {
        return $this->attributes['end_date'] = Carbon::parse($this->attributes['end_date']);
    }

    /**
     * @return string
     */
    public function getStartDateAttribute()
    {
        return $this->attributes['start_date'] = Carbon::parse($this->attributes['start_date']);
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

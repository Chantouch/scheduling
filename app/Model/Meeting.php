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
    protected $dates = ['meeting_date'];
    protected $fillable = [
        'meeting_date', 'start_time', 'end_time', 'subject', 'related_org', 'location', 'user_id', 'ampm', 'created', 'updated'
    ];

    public static function rules()
    {
        return [
            'meeting_date' => 'required|date',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
        ];
    }

    public static function messages()
    {
        return [
            'meeting_date.required' => 'ថ្ងៃប្រជុុំ ត្រូវតែបញ្ចូល',
            'start_time.required' => 'ថ្ងៃចាប់ផ្តើម ត្រូវតែបញ្ចូល',
            'start_time.before' => 'ថ្ងៃចាប់ផ្តើម ត្រូវតែចាប់ផ្តើមមុន ថ្ងៃបញ្ចប់',
            'end_time.required' => 'ថ្ងៃបញ្ចប់ ត្រូវតែបញ្ចូល',
            'end_time.after' => 'ថ្ងៃបញ្ចប់ ត្រូវតែបញ្ចប់ក្រោយ ថ្ងៃចាប់ផ្តើម',
        ];
    }

    /**
     * @param $date
     * @return string
     */
//    public function getMeetingDateAttribute($date)
//    {
//        return Carbon::parse($date)->diffForHumans();
//    }

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

    public function displayHumanTimeLeft()
    {
        $now = Carbon::now();
        if ($now->diffInMinutes($this->start_time) > 0) {
            return $now->diffInMinutes($this->start_time) . str_plural(' minutes', $now->diffInMinutes($this->start_time)) . ' left';
        }
    }
}

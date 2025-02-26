<?php

namespace App\Models;

use App\Enums\LectureType;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    use WithHashId;

    protected $fillable = [
        'duration_in_minutes',
        'course_id',
        'section_id',
        'sort_order',
        'title',
        'type',
        'body',
    ];

    protected $casts = [
        'type' => LectureType::class,
        'duration_in_minutes' => 'float',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function getDurationHMSAttribute()
    {
        if ($this->duration_in_minutes) {
            return convert_minutes_to_duration($this->duration_in_minutes);
        }

        return '00:00:00';
    }

    public function hasContent()
    {
        if ($this->type == LectureType::TEXT && !empty($this->body))
        {
            return true;
        }

        if ($this->type == LectureType::VIDEO && !empty($this->video))
        {
            return true;
        }

        return false;
    }
}

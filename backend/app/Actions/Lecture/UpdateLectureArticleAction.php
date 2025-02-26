<?php

namespace App\Actions\Lecture;

use App\Data\Lecture\LectureArticleContentData;
use App\Enums\LectureType;
use App\Models\Lecture;

class UpdateLectureArticleAction
{

    public static function run(LectureArticleContentData $data, Lecture $lecture)
    {
        return tap($lecture)->update([
            'body' => $data->body,
            'type' => LectureType::TEXT,
            'duration_in_minutes' => self::calculateArticleReadingTime($data->body),
        ]);
    }

    protected static function calculateArticleReadingTime(string $text)
    {
        $wordCount = str_word_count(strip_tags($text));
        return round($wordCount / 200, 2);
    }
}

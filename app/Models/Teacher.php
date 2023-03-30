<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use App\Models\Scopes\TeacherScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends User
{
    use HasFactory;

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new BusinessScope);
        static::addGlobalScope(new TeacherScope);
    }

    public function setRoleAttribute()
    {
        $this->attributes["role"] = "teacher";
    }

    public function Grades()
    {
        return $this->belongsToMany(Grade::class, "teacher_grade", "teacher_id", "grade_id");
    }

    public function setCvAttribute($value)
    {
        $attribute_name = "cv";
        $disk = "public";
        $destination_path = "/uploads";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path, $fileName = $value->getClientOriginalName());

        return $this->attributes["cv"] = route("download", ['url' => $value->getClientOriginalName()]); // uncomment if this is a translatable field
    }

    public function calendar()
    {
        $calendar = new \stdClass();
        $calendar->monday = [];
        $calendar->tuesday = [];
        $calendar->wednesday = [];
        $calendar->thursday = [];
        $calendar->friday = [];
        $calendar->saturday = [];
        $calendar->sunday = [];
        $grades = $this->Grades()->get();
        foreach ($grades as $grade) {
            $times = $grade->times;
            foreach ($times as $time) {
                $item = new \stdClass();
                $item->id = $grade->id;
                $item->name = $grade->name;
                $item->start = $time["start"];
                $item->end = $time["end"];
                switch ($time["day"]){
                    case "monday":
                        $calendar->monday[] = $item;
                        break;
                    case "tuesday":
                        $calendar->tuesday[] = $item;
                        break;
                    case "wednesday":
                        $calendar->wednesday[] = $item;
                        break;
                    case "thursday":
                        $calendar->thursday[] = $item;
                        break;
                    case "friday":
                        $calendar->friday[] = $item;
                        break;
                    case "saturday":
                        $calendar->saturday[] = $item;
                        break;
                    case "sunday":
                        $calendar->sunday[] = $item;
                        break;
                }

            }
        }
        return $calendar;
    }
}

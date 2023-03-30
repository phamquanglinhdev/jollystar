<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    public static function students()
    {
        return Student::count();
    }

    public static function teachers()
    {
        return Teacher::count();
    }

    public static function grades()
    {
        return Grade::count();
    }

    public static function logs()
    {
        return Log::count();
    }
}

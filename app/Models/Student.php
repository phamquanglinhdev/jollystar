<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use App\Models\Scopes\StudentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends User
{
    use HasFactory;

    protected $table = "users";

    public static function boot()
    {
        parent::boot();
//        static::addGlobalScope(new BusinessScope);
        static::addGlobalScope(new StudentScope);
    }

    public
    function setRoleAttribute()
    {
        $this->attributes["role"] = "student";
    }

    public function Staff()
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function Grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, "student_grade", "student_id", "grade_id");
    }

    public function CurrentGrade()
    {
        if ($this->CurrentInvoice() != null) {
            return $this->CurrentInvoice()->Grade()->first()->name;
        } else {
            return "-";
        }
    }

    public function CurrentStatus()
    {
        if ($this->CurrentInvoice() != null) {
            switch ($this->CurrentInvoice()->Grade()->first()->status) {
                case 0:
                    return "Đang học";
                case 1:
                    return "Đã kết thúc";
                case 2:
                    return "Đang bảo lưu";
            }
        } else {
            return "-";
        }

    }

    public function CurrentPayment()
    {
        if ($this->CurrentInvoice() != null) {
            switch ($this->CurrentInvoice()->payment) {
                case 0:
                    return "Đã đóng đủ";
                case 1:
                    return "Còn thiếu";
            }
        } else {
            return "-";
        }

    }

    public function CurrentInvoice()
    {
        return $this->Invoices()->where("status", 0)->orderBy("created_at", "DESC")->first();
    }

    public function Invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, "student_id", "id");
    }

    public function Carings(): HasMany
    {
        return $this->hasMany(Caring::class, "student_id", "id");
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
                switch ($time["day"]) {
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

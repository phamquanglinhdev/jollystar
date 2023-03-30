<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class Finance extends Model
{
    use HasFactory;

    public static function TotalInvoice()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        return Invoice::whereHas("student", function (Builder $builder) {
            $builder->where("origin", backpack_user()->origin);
        })->where("created_at", ">=", $start)->where("created_at", "<=", $end)->sum("current");
    }

    public static function TotalIncome()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        return Income::where("created_at", ">=", $start)->where("created_at", "<=", $end)->sum("value");
    }

    public static function TotalTeacherSalary()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $value = 0;
        $teacher_salary = TeacherSalary::where("created_at", ">=", $start)->where("created_at", "<=", $end)->get();
        foreach ($teacher_salary as $salary) {
            $value += $salary->salary_count();
        }
        return $value;
    }

    public static function TotalPayment()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        return Payment::where("created_at", ">=", $start)->where("created_at", "<=", $end)->sum("value");
    }

    public static function Sum()
    {
        return self::TotalInvoice() + self::TotalIncome() - self::TotalTeacherSalary() - self::TotalPayment();
    }

    public static function MonthInvoice()
    {

        $dates = [];
        $invoices = [];
        $teacherSalary = [];
        $incomes = [];
        $payments = [];
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $dates[] = $date->isoFormat("D");
            $invoices[] = Invoice::whereHas("student", function (Builder $builder) {
                $builder->where("origin", backpack_user()->origin);
            })->whereDate("created_at", "=", Carbon::parse($date))->sum("current");
            $incomes[] = Income::where("date", "=", Carbon::parse($date))->sum("value");
            $total = 0;
            foreach (TeacherSalary::where("date", Carbon::parse($date))->get() as $salary) {
                $total += $salary->salary_count();
            }
            $teacherSalary[] = $total;
            $payments[] = Payment::where("date", Carbon::parse($date))->sum("value");
        }
        return [
            'dates' => implode(",", $dates),
            'invoices' => implode(",", $invoices),
            'incomes' => implode(",", $incomes),
            'salary' => implode(",", $teacherSalary),
            'payments' => implode(",", $payments)
        ];
    }
}

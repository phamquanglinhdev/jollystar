<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $table = "student_grade";
    protected $guarded = ["id"];

    /**
     * @param int|mixed $sol
     */
    public function debt()
    {

        return number_format(round($this->pricing - $this->promotion - $this->current));
    }


    public function Student(): BelongsTo
    {
        return $this->belongsTo(Student::class, "student_id", "id");
    }

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, "grade_id", "id");
    }


}

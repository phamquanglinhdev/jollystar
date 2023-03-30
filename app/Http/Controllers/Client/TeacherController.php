<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();
        $skills = $request->skills ?? [];
        $origin = $request->origin ?? [];
        $price = $request->price ?? 2000;
        if ($skills != []) {
            $query = $query->whereHas("skills", function (Builder $builder) use ($skills) {
                $builder->whereIn("id", $skills);
            });
        }
        if ($price != null) {
            $query = $query->where(function (Builder $builder) use ($price) {
                $builder->where("users.price", "<=", $price * 1000)
                    ->orWhere("price", "=", null);
            });
        }
        if ($origin != []) {
            $query->whereIn("origin", $origin);
        }
        $count = $query->count();
        $bag = [
            'page' => $request->page ?? 1,
            'teachers' => $query->offset(($request->page - 1) * 10)->limit(10)->get(),
            'skills' => Skill::all(),
            'select_skills' => $skills,
            'select_origin' => $origin,
            'price' => $price,
            'max_page' => $count % 10 != 0 ? round($count / 10) : (int)($count / 10) + 1
        ];
        $_SESSION["teachers_bag"] = $bag;
//        dd($query->get());
        return view("teachers", $bag);
    }
}

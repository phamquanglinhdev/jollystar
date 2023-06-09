<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
//        $categoryId = $request->category ?? null;
//        if ($categoryId == null) {
//            $courses = Course::all();
//        } else {
//            $curentCategory = Category::find($categoryId);
//            $courses = Category::find($categoryId)->Courses()->get();
//        }
//        $tags = Tag::all();
//        $categories = Category::all();
        $bag = [
//            'tags' => $tags,
            'courses' => $courses,
//            'curentCategory' => $curentCategory ?? null,
//            'categories' => $categories,
        ];
        return view("courses", $bag);
    }

    public function show($id = null)
    {
        if ($id == null) {
            return view("errors.404");
        }
        $course = Course::where("id", $id)->firstOrFail();
        $bag = [
//            'categories' => Category::all(),
//            'tags' => Tag::all(),
            'course' => $course
        ];
        return view("course", $bag);
//        dd($course);
    }
}

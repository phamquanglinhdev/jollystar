<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        if (backpack_user()->role == "staff") {
            $tasks = Task::whereHas("staffs", function (Builder $staffs) {
                $staffs->where("id", backpack_user()->id);
            })->where("status", "waiting")->orderBy("pos", "ASC")->get();
            $done = Task::whereHas("staffs", function (Builder $staffs) {
                $staffs->where("id", backpack_user()->id);
            })->where("status", "done")->orderBy("pos", "ASC")->get();
            $cancel = Task::whereHas("staffs", function (Builder $staffs) {
                $staffs->where("id", backpack_user()->id);
            })->where("status", "cancel")->orderBy("pos", "ASC")->get();
        } else {
            $tasks = Task::where("status", "waiting")->orderBy("pos", "ASC")->get();
            $done = Task::where("status", "done")->orderBy("pos", "ASC")->get();
            $cancel = Task::where("status", "cancel")->orderBy("pos", "ASC")->get();
        }

        return view("task.index", ['tasks' => $tasks, 'done' => $done, 'cancel' => $cancel]);
    }

    public function sorted(Request $request)
    {
        $tasks = [];
        $items = $request->list ?? null;
        if ($items != null) {
            foreach ($items as $key => $item) {
                $id = str_replace("task-", "", $item);
                $tasks[$key] = Task::find($id)->update([
                    'pos' => $key
                ]);
            }
            return $tasks;
        }
        return null;
    }

    public function detail(Request $request)
    {
        $id = $request->id ?? null;
        if ($id != null) {
            $id = str_replace("task-", "", $id);
            $task = Task::find($id);
            return response()->json([
                'html' => (string)view("task.detail", ['task' => $task]),
                'title' => $task->title,
            ]);
        }
    }

    public function action(Request $request)
    {
        $id = $request->id ?? null;
        $method = $request->action ?? null;
        if ($id != null && $method != null) {
            $id = str_replace("task-", "", $id);
            $task = Task::find($id)->update([
                'status' => $method
            ]);
        }
        return true;
    }

    public function comment(Request $request)
    {
        $id = $request->task ?? null;
        $text = $request->comment ?? null;
        if ($id != null && $text != null) {
            $answer = Answer::create([
                'task_id' => $id,
                'user_id' => backpack_user()->id,
                'text' => $text
            ]);
            return (string)view("task.comment", ['answer' => $answer]);
        }
        return null;
    }
}

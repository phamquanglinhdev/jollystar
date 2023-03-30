<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function switchBranch(Request $request)
    {
        $origin = $request->origin ?? null;
        if ($origin != null) {
            if (backpack_user()->id == 1) {
                DB::table("users")->where("id", 1)->update(
                    ['origin' => $origin]
                );
                return redirect()->back();
            }
        }
    }
}

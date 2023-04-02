<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

class SuperAdminController extends Controller
{
    public function switchBranch(Request $request)
    {
        $origin = $request->origin ?? null;
        if ($origin != null) {
            Cookie::queue("origin", $request->origin ?? null);
            Alert::success("Thành công");
            if (backpack_user()->role == "super") {
                User::find(backpack_user()->id)->update([
                    'origin' => $request->origin ?? 1
                ]);
            }
            return redirect()->back();

        }
        Alert::error("Thất bại");
        return redirect()->back();
    }
}

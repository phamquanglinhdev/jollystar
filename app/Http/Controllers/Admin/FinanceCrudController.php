<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceCrudController extends Controller
{
    public function index()
    {

        return view("finance");
    }
}

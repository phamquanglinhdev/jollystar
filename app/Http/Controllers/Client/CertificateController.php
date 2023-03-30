<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {

    }

    public function all()
    {
        $bag = [
            'certificates' => Certificate::all()
        ];
        return view('certificates', $bag);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;

class DashboardController extends Controller
{
    //
   public function index()
    {
    	return view('layout.dashboard.index' );
    }
}

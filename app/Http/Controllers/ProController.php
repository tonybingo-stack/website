<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pro;

class ProController extends Controller
{
    public function index()
    {
        $pros = Pro::all();
        return response()->json($pros);
    }
}

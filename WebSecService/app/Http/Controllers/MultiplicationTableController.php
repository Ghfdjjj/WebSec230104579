<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultiplicationTableController extends Controller
{
    public function index()
    {

        $table = [];
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                $table[$i][$j] = $i * $j;
            }
        }

        return view('multiplication-table', compact('table'));
    }
}

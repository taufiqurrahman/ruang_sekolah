<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassListController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $class = DB::table('class')
        ->select('id as class_id', 'rows', 'columns', \DB::raw('(CASE 
        WHEN teacher = "" THEN "out" 
        ELSE "in" 
        END) AS teacher'))
        ->get();

        return response()->json(
            [
                'class' => $class
            ]
            );
    }
}

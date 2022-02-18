<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassByIdController extends Controller
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
        ->select('id as class_id', 'rows', 'columns', 'teacher')
        ->where('id', $request->class_id)
        ->first();

        if(!$class){
            return response()->json(['message' => 'Data Not Found!'], 404);
        }

        $availableSeatsResult = DB::table('seats')
        ->select('seat')
        ->where('class_id', $request->class_id)
        ->where('student_name', '')
        ->get();
        $availableSeats = [];
        foreach($availableSeatsResult as $seat){
            $availableSeats[] = $seat->seat;
        }

        $occupied_seats = DB::table('seats')
        ->select('seat', 'student_name')
        ->where('class_id', $request->class_id)
        ->where('student_name','!=', '')
        ->get();
        
         return response()->json(
            [
                "class_id" => $class->class_id,
                "rows" => $class->rows,
                "columns" => $class->columns,
                "teacher" => $class->teacher == '' ? 'out':'in',
                "available_seats" => $availableSeats,
                "occupied_seats" => $occupied_seats,
                "message" => "",
            ],
         );

        return response()->json(
            [
                'class' => $class
            ]
            );
    }
}

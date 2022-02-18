<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'id_no' => 'required',
        ]);

        $user = auth('sanctum')->user();
        if($user->tokenCan('admin')) {
            $class = DB::table('class')
            ->select('id as class_id', 'rows', 'columns', 'teacher')
            ->where('id', $request->class_id)
            ->first();

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
        }
        else if($user->tokenCan('pengajar')){
            $class = DB::table('class')
            ->select('id')
            ->where('id', $request->class_id)
            ->where('teacher', $user['name'])
            ->first();

            if($class){
                 DB::table('class')
                 ->where('id', $request->class_id)
                 ->where('teacher', $user['name'])
                    ->update(['teacher' => ""]);
            }

            $class = DB::table('class')
            ->select('id as class_id', 'rows', 'columns', 'teacher')
            ->where('id', $request->class_id)
            ->first();

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
        }
        else if($user->tokenCan('murid')){
            $message = "";
            $check = DB::table('seats')
            ->select('seat')
            ->where('class_id', $request->class_id)
            ->where('student_name', $user['name'])
            ->first();
            if($check){
                DB::table('seats')
                ->where('seat', $check->seat)
                ->where('class_id', $request->class_id)
                    ->update(['student_name' => ""]);
                    $message = "Hi ".$user['name'].", ".$check->seat." is now available for other students";
            }

            $class = DB::table('class')
            ->select('id as class_id', 'rows', 'columns', 'teacher')
            ->where('id', $request->class_id)
            ->first();

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
                    "message" => $message,
                ],
             );
        }
    }
}



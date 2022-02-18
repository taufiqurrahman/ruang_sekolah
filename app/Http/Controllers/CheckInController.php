<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInController extends Controller
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
            ->select('id as class_id', 'rows', 'columns', 'teacher')
            ->where('id', $request->class_id)
            ->first();
            if($class->teacher == ''){
                 DB::table('class')
                    ->where('id', $request->class_id)
                    ->update(['teacher' => $user['name']]);
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
            ->select('student_name')
            ->where('class_id', $request->class_id)
            ->where('student_name', $user['name'])
            ->first();
            if(!$check){
                 $available = DB::table('seats')
                    ->select('seat')
                    ->where('class_id', $request->class_id)
                    ->orderBy('seat', 'asc')
                    ->where('student_name', '')->first();
                if($available){
                    DB::table('seats')
                    ->where('seat', $available->seat)
                    ->where('class_id', $request->class_id)
                        ->update(['student_name' => $user['name']]);
                        $message = "Hi ".$user['name'].", your seat  is ".$available->seat;
                }else{
                    $message = "Hi ".$user['name'].", the class is fully seated";
                }
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





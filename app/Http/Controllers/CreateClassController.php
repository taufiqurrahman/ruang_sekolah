<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateClassController extends Controller
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
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        $alphabet = range('A', 'Z');

        $user = auth('sanctum')->user();
        if ($user->tokenCan('admin')) {
            $class_id = DB::table('class')->insertGetId(
                [
                    'rows' => $request->y,
                    'columns' => $request->x,
                    'teacher' => '',
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            );

            $seats = [];

           for($i=1;$i<=$request->y;$i++){
               for($j=0;$j<$request->x;$j++){
                    $seats[] = [             
                        "seat" =>  $i.$alphabet[$j],
                        "student_name" =>  '',
                        "class_id" => $class_id,
                        'created_at' =>  date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
               }
           }
           DB::table('seats')->insert($seats);
           return response()->json(
            [
                'message' => "Success"
            ]
            );
        }else{
            return response()->json(
                [
                    "metaData" => "Unauthorized action."
                ], 
            403);
        }
    }
}

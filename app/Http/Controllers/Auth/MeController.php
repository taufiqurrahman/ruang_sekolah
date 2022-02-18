<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $user = auth('sanctum')->user();

        if ($user) {
            return response()->json(
                [
                    'user_details' => [
                        "username" => $user['username'],
                    ]
                ]
            );
        }
    }
}

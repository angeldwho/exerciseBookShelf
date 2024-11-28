<?php

namespace App\Utils;

class ApiCustomResponse{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public static function sendResponse($result,$message = 'Success', $code = 200)
    {
        return $response = [
            'success'=>true,
            'data'=>$result,
            'message'=>$message,
        ];
        return response()->json($response,$code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}

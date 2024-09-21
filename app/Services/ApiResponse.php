<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
class ApiResponse
{
    /**
     * Summary of rollback
     * @param mixed $e
     * @param mixed $message
     * @return void
     */
    public static function rollback($e, $message ="Something went wrong! Process not completed"){
        DB::rollBack();
        self::throw($e, $message);
    }

    /**
     * Summary of throw
     * @param mixed $e
     * @param mixed $message
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        throw new HttpResponseException(response()->json([
            'data' => $e->getMessage(),
            'message'=>$message,
            'status'=>false,
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }

    /**
     * Summary of sendResponse
     * @param mixed $result
     * @param mixed $message
     * @param mixed $code
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function sendResponse($result , $message ,$code=200): \Illuminate\Http\JsonResponse {
        $response=[
            'success' => true,
            'data'    => $result
        ];
        if(!empty($message)){
            $response['message'] =$message;
        }
        return response()->json($response, $code);
    }

}

<?php
namespace App\Http\Traits;

trait MessagesTrait {
    public function sendError($msg) {
        return response()->json([
            'status'=> false,
            'errNum'=> 404,
            'msg' => $msg,
            'category' => []
        ]);
    }

    public function sendSuccessMessage($msg, $data) {
        return response()->json([
            'status'=> true,
            'errNum'=> 200,
            'msg' => $msg,
            'category' => $data
        ]);
    }
}
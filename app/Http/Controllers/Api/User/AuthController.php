<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    use \App\Http\Traits\MessagesTrait;

    public function login(Request $req) {
        try {
            $credentials = $req->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
            $token = Auth::guard('user-api')->attempt($credentials);
            if(!$token) {
                return response($this->sendError('user not found'), 404);
            }
            $user = Auth::guard('user-api')->user();
            $user->api_token = $token;
            return response($this->sendSuccessMessage('logged in successfully', $user), 200);
        }catch (\Exception $e) {
            response($this -> returnError('something went wrongs'), 200);
        }
    }

    public function logout(Request $req) {
        $token = $req->header('auth-token');
        try {
            JWTAuth::setToken($token)->invalidate();
            return $this->sendSuccessMessage('logged out successfully', []);
        }catch(\Exception $e) {
            return $this->sendError('something went wrong!');
        }
    }
}

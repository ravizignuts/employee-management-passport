<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * API for Register user
     * @param Request $request
     * @return json data
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20|confirmed'
        ]);
        // $request['password'] = Hash::make($request->password);
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->only('name', 'email', 'password'));
        $success['token'] = $user->createToken('API Token')->accessToken;

        return response()->json([
            'success' => $user['name'],
            'token'   => $success
        ]);
    }
    /**
     * API for Login user
     * @param Request $request
     * @return json data
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:8|max:20'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Model\User $user */
            $user = Auth::user();
            $success['token'] = $user->createToken('MyAPP')->accessToken;
            return response()->json([
                'success' => true,
                'user'    => $user['name'],
                'token'   => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "User Credentials are Invalid"
            ]);
        }
    }
    /**
     * API for View user
     * @return json data
     */
    public function view()
    {
        $user = Auth::user();
        return response()->json([
            'success' => $user
        ]);
    }
    /**
     * API for logout user
     * @return json data
     */
    public function logout()
    {
        /** @var \App\Model\User $user */
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'user'    => $user,
            'message' => 'User Logout'
        ]);
    }
}

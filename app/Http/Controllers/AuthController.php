<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class AuthController extends Controller
{
    use HttpResponses;

  public function login (LoginUserRequest $request){
    $request->validated($request->all());
    if(!Auth::attempt($request->only(['email','password']))){
        return $this->error('','Invalid credentials',401);
    }

    $user = User::where('email',$request->email)->first();
    return $this->success([
        'user' => $user,
        'token' => $user->createToken('API Token of '.$user->name)
    ]);

    }


    public function register(StoreUserRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);



        return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of '.$user->name)->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return $this->success(
            ['message' => 'You have successfully logged out and your token has been deleted']
        );
    }

}

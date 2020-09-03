<?php
namespace App\Http\Controllers;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\Http\Resources\UserResource;
class AuthController extends BaseController 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Create a new token.
     * 
     * @param  \App\Models\Member   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */

    public function authenticate(Request $user) {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'     => 'required',
        ]);
        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->where('password', $this->request->input('password'))->first();

        // Verify the password and generate the token
        if ($user) {
            $data = new UserResource(User::find($user->id));
            return response()->json([
                'result' => true,
                'message' => 'Login Successfull',
                'token' => $this->jwt($user),
                'data' => $data,
            ], 200);
        }else{
            $response = [
                'result' => false,
                'message' => 'Email or Password is wrong!',
            ];
            return response()->json($response);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ]);
    }
}
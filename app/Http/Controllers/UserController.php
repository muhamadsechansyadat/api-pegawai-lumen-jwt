<?php

namespace App\Http\Controllers;

// use App\User;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Company;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\User;
// use Str;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserDetailResource;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $token = $request->get('token');
        $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

        $user = UserResource::collection(User::where('id', '!=', $credentials->sub)->get());
        return response()->json([
            'result' => true,
            'data' => $user
        ]);
    
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
                
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->date_birth = $request->input('date_birth');


        if ($user && $user->update()) {
            $data = new UserResource(User::find($user->id));
            return response()->json([
                'result' => true,
                'message' => 'Data berhasil diupdate',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'gagal update!',
            ]);
        }
    }

    public function updateImage(Request $request,$id){
        $user = User::where('id', $id)->first();
        $path = base_path('public/files');

        $current_images_path = $path . '/' . $user->photo_profile;
        if (file_exists($current_images_path)) {
            unlink($current_images_path);
        }
        $now = \Carbon\Carbon::now()->format('dmy_His');
        $file = $request->file('photo_profile');
        $fileName = $now . "_" . $file->getClientOriginalName();
        $file->move($path, $fileName);

        $user->photo_profile = $fileName;

        $user->update();

        return response()->json([
            'result' => true,
            'message' => 'success',
            'image_link' => url('files/'.$user->photo_profile),
        ]);
    }

    public function showProfile($id)
    {
        // for get data all profile user and link photo local
        $user = new UserDetailResource(User::find($id));
        return response()->json([
            'result' => true,
            'user' => $user,
        ]);
    }

    // public function myProfile(Request $request)
    // {
    //     // get data by token
    //     $token = $request->get('token');
    //     $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        
    //     $user = new UserResource(User::find($credentials->sub));

    //     return response()->json([
    //         'result' => true,
    //         'data' => $user
    //     ]);
    // }

    public function dataFilter()
    {
        $companies = Company::all();
        $divisions = Division::all();

        return response()->json([
            'result' => true,
            'companies' => $companies,
            'divisions' => $divisions,
        ]);
    }

    public function filter(Request $request)
    {
        $token = $request->get('token');
        $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        $users = User::where('id', '!=', $credentials->sub)->get();

        if ($request->company_id != 0)
            $users = $users->where('company_id', $request->company_id);
        if ($request->division_id != 0)
            $users = $users->where('division_id', $request->division_id);
        if ($request->gender != "")
            $users = $users->where('gender', $request->gender);

        $users =  UserResource::collection($users);

        // $users->where('gender', 'P')->get();

        return response()->json([
            'result' => true,
            'data' => $users
        ]);
    }

    public function search(Request $req)
    {
        $token = $req->get('token');
        $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        $users = User::where('name','like','%'.$req->key.'%') ->orWhere('nip','like','%'.$req->key.'%') ->orWhere('email','like','%'.$req->key.'%')->get();
        $users = UserResource::collection($users);

        $user = UserResource::collection(User::where('id', '!=', $credentials->sub)->get());
        return response()->json([
            'result' => true,
            'data' => $users,
            'user'  =>  $user
        ]);
    }
}

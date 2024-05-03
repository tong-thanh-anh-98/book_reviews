<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function register()
    {
        return view('account.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->passes()) {
            /* register new user */
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect()->route('account.login')->with('success', 'You have registered successfully');
        } else {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }

    public function login()
    {
        return view('account.login');
    }

    public function authenticate(Request $request)
    {
        $valadator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($valadator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($valadator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'The email or password you entered is incorrect');
        }
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);
        
        return view('account.profile', [
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        /*upload file image*/
        if (!empty($request->image)) {
            
            // delete image
            File::delete(public_path('uploads/profile/'.$user->image));
            File::delete(public_path('uploads/profile/thumbnail/'.$user->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $profileImage = time().'.'.$ext;
            $image->move(public_path('uploads/profile'),$profileImage);

            $user->image = $profileImage;
            $user->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/profile/'.$profileImage));

            $img->cover(450, 450);
            $img->save(public_path('uploads/profile/thumbnail/'.$profileImage));
        }

        return redirect()->route('account.profile')->with('success', 'You have updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}

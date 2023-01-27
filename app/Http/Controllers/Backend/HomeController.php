<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users      = User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->paginate(5);
        $user_name  = Auth::user()->name;
        $total_user = User::all()->count();

        return view('backend.pages.users.manage', [
            'users'         => $users,
            'user_name'     => $user_name,
            'total_user'    => $total_user
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ( !is_null($user) )
        {
            if (Auth::id() == $id)
            {
                echo "login user id";
            }
            else {
                if ($user->profile != 'default.png')
                {
                    if ( File::exists('backend/uploads/users/' . $user->profile) )
                    {
                        File::delete('backend/uploads/users/' . $user->profile);
                    }
                }
                $user->delete();

                return redirect()->route('user.manage')->with('delete_user', 'default');
            }
        }
        else {
            return redirect()->route('home');
        }
    }

    public function dashboard()
    {
        return view('backend.pages.index');
    }

    public function profile()
    {
        return view('backend.pages.users.profile');
    }

    public function edit($id)
    {
        $user_info = User::find($id);

        return view('backend.pages.users.edit', compact('user_info'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => ['required', Rule::unique('users')->ignore($request->user_id)],
            'user_img'  => ['image', 'file', 'max:1500']
        ]);

        $user           = User::find($request->user_id);
        $error_msg      = [];

        if ((!is_null($request->password) || !is_null($request->con_password)) && is_null($request->old_password))
        {
            $request->validate([
                'old_password'  => 'required',
            ]);
        }
        elseif ((!is_null($request->password) || !is_null($request->con_password)) && !is_null($request->old_password))
        {
            if (!Hash::check($request->old_password, $user->password))
            {
                $error_msg['old_password'] = "Old Password does not match";
                return redirect()->route('user.edit', $request->user_id)->with($error_msg);
            }
            elseif (strlen($request->password) < 8 || Hash::check($request->password, $user->password))
            {
                $request->validate([
                    'password'  => [ Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()],
                ]);
                $error_msg['pass_notUpdate'] = "This Password has already used.Try another..";
                return redirect()->route('user.edit', $request->user_id)->with($error_msg);
            }
            elseif ($request->password !== $request->con_password)
            {
                $error_msg['pass_error'] = "Password does not match";
                return redirect()->route('user.edit', $request->user_id)->with($error_msg);
            }
        }
        elseif ((is_null($request->password) || is_null($request->con_password)) && !is_null($request->old_password))
        {
            $request->validate([
                'password'      => 'required',
                'con_password'  => 'required'
            ]);
        }

        if (!is_null($request->user_img))
        {
            $image              = $request->user_img;
            $image_extention    = $image->getClientOriginalExtension();
            $image_name         = $request->user_id.'.'.$image_extention;
            $location           = public_path('backend/uploads/users/'. $image_name);
        }

        if (count($error_msg) == 0)
        {
            if (!empty($request->user_img) && !empty($request->password))
            {
                if ($user->profile != 'default.png')
                {
                    if ( File::exists('backend/uploads/users/' . $user->profile) )
                    {
                        File::delete('backend/uploads/users/' . $user->profile);
                    }
                }
                Image::make($image)->save($location);

                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                    'profile'       => $image_name,
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
            elseif (!empty($request->user_img) && empty($request->password))
            {
                if ($user->profile != 'default.png')
                {
                    if ( File::exists('backend/uploads/users/' . $user->profile) )
                    {
                        File::delete('backend/uploads/users/' . $user->profile);
                    }
                }
                Image::make($image)->save($location);

                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'profile'       => $image_name,
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
            elseif (empty($request->user_img) && empty($request->password))
            {
                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
            elseif (empty($request->user_img) && !empty($request->password))
            {
                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
        }
        else {
            if (!empty($request->user_img))
            {
                if ($user->profile != 'default.png')
                {
                    if ( File::exists('backend/uploads/users/' . $user->profile) )
                    {
                        File::delete('backend/uploads/users/' . $user->profile);
                    }
                }
                Image::make($image)->save($location);

                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'profile'       => $image_name,
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
            else {
                $user->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'updated_at'    => Carbon::now(),
                ]);

                if (Auth::id() == $user->id)
                {
                    return redirect()->route('user.profile')->with('update', 'User information has now updated');
                }
                else {
                    return redirect()->route('user.manage')->with('update', 'User information has now updated');
                }
            }
        }
    }
}

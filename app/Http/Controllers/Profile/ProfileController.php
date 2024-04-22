<?php

namespace App\Http\Controllers\Profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index($userEncodedId)
    {
        $decodedId = decrypt($userEncodedId);

        if (!is_numeric($decodedId)) throw new \App\Exceptions\CustomException('The profile\'s encoded unique string should be number.');

        $user = User::find($decodedId);

        if ($user->id == auth()->id())
            return view('profile.index', compact('user'));

        return view('errors.403');
    }

    public function changePassword(Request $request, $enc_user)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $decodedId = decrypt($enc_user);

        if (!is_numeric($decodedId)) throw new \App\Exceptions\CustomException('The profile\'s encoded unique string should be number.');

        $user = User::find($decodedId);

        if ($user->id == auth()->id()){
            if (\Hash::check($request->input('old_password'),\Auth::user()->password)){
                $user->password = bcrypt($request->input('password'));
                $user->save();

                return redirect(route('profile', [encrypt($user->id)]))
                    ->with([
                        'alert'=>'performed',
                        'message'=> __('global.changed_password'),
                        'class'=>'alert-info'
                    ]);
            }
        }else{
            return view('errors.403');
        }
    }

    public function update(Request $request, $userEncodedId)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'name_dr' => 'required|min:3',
            'email' => 'required|email',
            'img_path' => 'max:10000',
        ]);

        $decodedId = decrypt($userEncodedId);

        if (!is_numeric($decodedId)) throw new \App\Exceptions\CustomException('The profile\'s encoded unique string should be number.');

        $user = User::find($decodedId);

        if ($user->id != auth()->id()) return view('errors.403');

        $user->update($request->except(['_token','_method','img_path']));

        if ($request->hasFile('img_path'))
            $user->img_path = $request->img_path->move('user_pic',  $request->email.'.'. $request->img_path->getClientOriginalExtension());
            
        $user->save();

        return redirect(route('profile', [encrypt($user->id)]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }
}

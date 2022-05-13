<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\Notification;
use Auth;
use App\Events\NotificationEvent;

class LoginController extends Controller
{
  public function login(Request $request) {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
      }

      $user = User::where('email', $request->email)->first();

      if (!$user) {
        return response()->json([
          'error_login' => true,
          'err_message' => 'Data user tidak ditemukan / belum terdaftar'
        ]);
      } else {
        if ($user->login % 2 == 1) {
          return response()->json([
            'userhaslogin' => true,
            'message' => 'User sedang login / digunakan'
          ]);
        }

        if ($user->status == "INACTIVE"):
        return response()->json([
          'activated' => true,
          'message' => 'Silahkan check inbox anda !'.$user->email.' untuk mengaktivasi akun anda.'
        ]);
        else :
        if (!Hash::check($request->password, $user->password)) {
          return response()->json([
            'success' => false,
            'message' => 'Wrong email or password !'
          ]);
        }
        $login = User::findOrFail($user->id);
        $login->login = 1;
        $login->save();

        $event_context = [
          'notif' => true,
          'message' => $user->name.' Sedang Login !',
          'name' => 'login',
          'route' => '/logs'
        ];

        $new_notif = new Notification;
        $new_notif->name = 'login';
        $new_notif->content = $event_context['message'];
        $new_notif->route = $event_context['route'];
        $new_notif->save();

        $data_event = broadcast(new NotificationEvent($event_context));

        return response()->json([
          'success' => true,
          'message' => 'Login success!',
          'data' => $login,
          'token' => $user->createToken('authToken')->accessToken
        ]);
        endif;
      }
    }catch(Exception $e) {
      return response()->json([
        'error-network' => true,
        'message' => 'Error Network'
      ]);
    }
  }

  public function logout(Request $request) {
    $id = $request->id;
    $user = User::findOrFail($id);
    $user->login = 0;
    $removeToken = $request->user()->tokens()->delete();
    if ($removeToken) {
      $event_context = [
        'notif' => true,
        'message' => $user->name.' telah logout!',
        'name' => 'logout',
        'route' => '/logs'
      ];
      $new_notif = new Notification;
      $new_notif->name = 'logout';
      $new_notif->content = $event_context['message'];
      $new_notif->route = $event_context['route'];
      $new_notif->save();

      $data_event = broadcast(new NotificationEvent($event_context));

      return response()->json([
        'success' => true,
        'message' => 'Logout success!',
        'data' => $user
      ]);

    }
  }
}
<?php

namespace App\Http\Controllers\Auth\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ManagerLoginRequest;
//use App\Mail\Manager\ManagerResetPassword;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Mail};

class ManagerAuthenticatedSessionController extends Controller
{
    protected $redirectRouteName = 'manager.dashboard';
    protected $loginViewPath = 'dashboard.manager.auth.login';
    protected $forgotPasswordViewPath = 'dashboard.manager.auth.forgot-password';
    protected $LogoutRidirectRouteName = 'manager.login';

    public function create()
    {
        return view($this->loginViewPath);
    }

    public function store(ManagerLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (manager_guard()->attempt($credentials)) {
            $manager = manager_guard()->user();
            if ($manager->status === 'active') {
                toastr()->success(trans('dashboard/auth.success_login_msg'));
                return redirect()->route($this->redirectRouteName);
            } else {
                manager_guard()->logout();
                toastr()->warning(trans('dashboard/auth.not_active_account_msg'));

                return redirect()->back();
            }
        }
        toastr()->error(trans('dashboard/auth.login_credential_failure'));

        return redirect()->back();
    }

    public function forgot_password()
    {
        return view($this->forgotPasswordViewPath);
    }

    /*public function forgot_password_post() {
        $admin = Admin::where('email', request('email'))->first();
        if(!empty($admin)) {
            $newToken = app('auth.password.broker')->createToken($admin);
            $data = DB::table('admin_password_resets')->insert([
                'email' => $admin->email,
                'token' => $newToken,
                'created_at' => now()
            ]);
            Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin, 'token' => $newToken]));
            return back()->with(['success' => 'تم ارسال البريد الالكتروني بنجاح']);
        }
        return back();
    }

    public function reset_password($token) {
        $checkToken = DB::table('admin_password_resets')->where('token', $token)->where('created_at', '>', now()->subHours(2))->first();
        if(!empty($checkToken))
            return view('dashboard.Admin.auth.reset-password', ['data' => $checkToken]);
        return redirect()->route('admin.forgot.password');
    }

    public function do_reset_password($token) {
        $this->validate(request(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ],[], [
            'password.required' => 'يجب ادخال كلمة المرور',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'password_confirmation' => 'يجب ادخال تأكيد كلمة المرور'
        ]);
        $checkToken = DB::table('admin_password_resets')->where('token', $token)->where('created_at', '>', now()->subHours(2))->first();
        if(!empty($checkToken)) {
            $admin = Admin::where('email', $checkToken->email)->update([
                    'email' => $checkToken->email,
                    'password' => bcrypt(request('password'))
                ]);
            DB::table('admin_password_resets')->where('email', $checkToken->email)->delete();
            admin_guard()->attempt(['email' => $checkToken->email, 'password' => request('password')]);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.forgot.password');
        }
    }*/

    public function destroy(Request $request)
    {
        manager_guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($this->LogoutRidirectRouteName);
    }
}

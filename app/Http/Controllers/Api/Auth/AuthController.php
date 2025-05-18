<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiTrait;
use App\Services\Services\Auth\MultiAuthService;
use Illuminate\Http\Request;
use App\Http\Resources\Auth;
use Illuminate\Support\Facades\{Hash, Validator, DB};
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiTrait;
    protected $authService;
    public function __construct(MultiAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        //dd($rrquest->all());
        $credentials = $request->only(['email', 'password']);
        $type = $request->input('type');
        $response = $this->authService->login($credentials, $type);
        if (isset($response['error'])) {
            return $this->errorResponse('Unauthorized', 401);
        }
        $guard = $type === 'admin' ? 'admin-api' : 'user-api';
        $user = auth($guard)->user();
        if (!$user) {
            return $this->notFoundResponse('User not found');
        }
        $user->load('profile');
        $resource = $guard === 'admin-api' ? new Auth\AdminResource($user) : new Auth\UserResource($user);
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user); // create a refresh token

        return $this->successResponse([
            'token' => $response['token'],
            'refresh_token' => $refreshToken,
            'user' => $resource
        ], "$type Login successful");
    }

    public function logout(Request $request)
    {
        $guard = $request->input('type') === 'admin' ? 'admin-api' : 'user-api';
        auth($guard)->logout();
        return $this->successResponse(null, 'Successfully logged out');
    }

    public function me(Request $request)
    {
        $type = ucfirst($request->input('type'));
        $guard = 'user-api';
        $user = auth($guard)->user();
        if (!$user) {
            return $this->notFoundResponse('User not found');
        }
        $user->load('profile');
        $resource = new Auth\UserResource($user);
        return $this->successResponse($resource, "$type profile retrieved successfully");
    }

    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'first_name.max' => 'يجب ألا يتجاوز الاسم الأول 255 حرفًا.',

            'last_name.required' => 'الاسم الأخير مطلوب.',
            'last_name.string' => 'يجب أن يكون الاسم الأخير نصًا.',
            'last_name.max' => 'يجب ألا يتجاوز الاسم الأخير 255 حرفًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'address.string' => 'يجب أن يكون العنوان نصًا.',
            'address.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا.',

            'street.string' => 'يجب أن يكون اسم الشارع نصًا.',
            'street.max' => 'يجب ألا يتجاوز اسم الشارع 255 حرفًا.',

            'area.string' => 'يجب أن يكون الحي نصًا.',
            'area.max' => 'يجب ألا يتجاوز الحي 255 حرفًا.',

            'city.string' => 'يجب أن يكون اسم المدينة نصًا.',
            'city.max' => 'يجب ألا يتجاوز اسم المدينة 255 حرفًا.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            $user->profile()->create([
                'user_id' => $user->id,
                'address' => $request->address,
                'street' => $request->street,
                'area' => $request->area,
                'city' => $request->city,
            ]);
            DB::commit();
            $user->load('profile');
            $token = auth('user-api')->login($user);
            return $this->successResponse([
                'token' => $token,
                'user' => new Auth\UserResource($user)
            ], "$user->first_name registered successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*public function updateProfile(Request $request)
    {
        $user = auth('user-api')->user();

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'first_name.max' => 'يجب ألا يتجاوز الاسم الأول 255 حرفًا.',

            'last_name.required' => 'الاسم الأخير مطلوب.',
            'last_name.string' => 'يجب أن يكون الاسم الأخير نصًا.',
            'last_name.max' => 'يجب ألا يتجاوز الاسم الأخير 255 حرفًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',

            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور.',
            'new_password.required_with' => 'كلمة المرور الجديدة مطلوبة.',
            'new_password.string' => 'يجب أن تكون كلمة المرور الجديدة نصًا.',
            'new_password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 6 أحرف.',
            'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
            'new_password.different' => 'يجب أن تكون كلمة المرور الجديدة مختلفة عن كلمة المرور الحالية.',

            'address.string' => 'يجب أن يكون العنوان نصًا.',
            'street.string' => 'يجب أن يكون اسم الشارع نصًا.',
            'street.max' => 'يجب ألا يتجاوز اسم الشارع 255 حرفًا.',
            'area.string' => 'يجب أن يكون الحي نصًا.',
            'area.max' => 'يجب ألا يتجاوز الحي 255 حرفًا.',
            'city.string' => 'يجب أن يكون اسم المدينة نصًا.',
            'city.max' => 'يجب ألا يتجاوز اسم المدينة 255 حرفًا.',
            'bio.string' => 'يجب أن تكون السيرة الذاتية نصًا.',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'address' => 'nullable|string',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'current_password' => 'required_with:new_password|string',
            'new_password' => 'required_with:current_password|string|min:6|confirmed|different:current_password',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update user data
            $user->update([
                'name' => $request->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update profile data
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address,
                    'street' => $request->street,
                    'area' => $request->area,
                    'city' => $request->city,
                    'bio' => $request->bio,
                ]
            );

            // Update password if provided
            if ($request->has('current_password') && $request->has('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'كلمة المرور الحالية غير صحيحة',
                    ], 401);
                }

                $user->password = Hash::make($request->new_password);
                $user->save();
            }

            DB::commit();

            $user->load('profile');
            return $this->successResponse(
                new Auth\UserResource($user),
                'تم تحديث الملف الشخصي بنجاح'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'فشل تحديث الملف الشخصي',
                'error' => $e->getMessage(),
            ], 500);
        }
    }*/

    public function updateProfile(Request $request) {
        $user = auth('user-api')->user();
        if (!$user) {
            return $this->notFoundResponse('User not found');
        }
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'address.string' => 'يجب أن يكون العنوان نصًا.',
            'street.string' => 'يجب أن يكون اسم الشارع نصًا.',
            'street.max' => 'يجب ألا يتجاوز اسم الشارع 255 حرفًا.',
            'area.string' => 'يجب أن يكون الحي نصًا.',
            'area.max' => 'يجب ألا يتجاوز الحي 255 حرفًا.',
            'city.string' => 'يجب أن يكون اسم المدينة نصًا.',
            'city.max' => 'يجب ألا يتجاوز اسم المدينة 255 حرفًا.',
        ];
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'address' => 'nullable|string',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل في التحقق من البيانات',
                'errors' => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address,
                    'street' => $request->street,
                    'area' => $request->area,
                    'city' => $request->city,
                ]
            );

            DB::commit();
            $token = JWTAuth::fromUser($user);
            $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);
            $user->load('profile');
            return $this->successResponse([
                'token' => $token,
                'refresh_token' => $refreshToken,
                'user' => new \App\Http\Resources\Auth\UserResource($user),
            ], 'تم تحديث الملف الشخصي بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'فشل تحديث الملف الشخصي',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

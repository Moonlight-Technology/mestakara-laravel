<?php

namespace Modules\User\Controllers\Auth;

use App\Helpers\ReCaptchaEngine;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Modules\User\Events\SendMailUserRegistered;

class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{
    public function register(Request $request)
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255'
            ],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'   => [
                'required',
                'string',
                'min:8', // Ensure password has a minimum length
            ],
            'phone' => [
                'required', 
                'regex:/^0\d{9,15}$/', // Ensure phone number starts with 0 and has 10 to 16 digits
                'unique:users',
            ],
            'term'       => ['required'],
        ];

        $messages = [
            'phone.required'      => __('Phone is a required field'),
            'phone.regex'         => __('The phone number must start with 0'),
            'email.required'      => __('Email is a required field'),
            'email.email'         => __('Email is invalid'),
            'password.required'   => __('Password is a required field'),
            'first_name.required' => __('The first name is a required field'),
            'last_name.required'  => __('The last name is a required field'),
            'term.required'       => __('You must accept the terms and conditions'),
        ];

        // ReCaptcha validation if enabled
        if (ReCaptchaEngine::isEnable() and setting_item("user_enable_register_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                $errors = new MessageBag(['message_error' => __('Please verify the captcha')]);
                return response()->json([
                    'error'    => true,
                    'messages' => $errors
                ], 200);
            }
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors()
            ], 200);
        } else {
            // Create user
            $user = \App\User::create([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'email'      => $request->input('email'),
                'password'   => Hash::make($request->input('password')),
                'status'     => $request->input('publish', 'publish'),
                'phone'      => $request->input('phone'),
            ]);

            // Fire the registered event
            event(new Registered($user));

            // Log the user in
            Auth::loginUsingId($user->id);

            try {
                event(new SendMailUserRegistered($user));
            } catch (\Exception $exception) {
                Log::warning("SendMailUserRegistered: " . $exception->getMessage());
            }

            // Assign the 'customer' role to the new user
            $user->assignRole('customer');

            // Redirect the user
            return response()->json([
                'error'    => false,
                'messages' => false,
                'redirect' => $request->input('redirect') ?? $request->headers->get('referer') ?? url(app_get_locale(false, '/'))
            ], 200);
        }
    }
}

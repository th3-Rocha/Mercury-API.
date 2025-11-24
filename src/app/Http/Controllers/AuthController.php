<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.',
            ], 401);
        }

        // evita DoS limitando os tokens        
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login efetuado com sucesso',
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\p{N}\s\-\']+$/u'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ]);


        $user = User::create([
            'name' => strip_tags($validated['name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Registered',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ], 200);
    }

    public function validate(Request $request)
    {


        $user = $request->user();

        if (!$user || !$request->bearerToken()) {
            return response()->json([
                'valid' => false,
                'message' => 'Token inválido ou expirado.'
            ], 401);
        }

        return response()->json([
            'valid' => true,
            'user' => new UserResource($user)
        ], 200);
    }


    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $validated['email']],
                [
                    'email' => $validated['email'],
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            if (config('app.env') === 'local') {
                Log::info('Password Reset Token', [
                    'email' => $validated['email'],
                    'token' => $token,
                    'expires_at' => now()->addMinutes(60)
                ]);
            }
        }

        return response()->json([
            'message' => 'Se o email existir em nossa base, você receberá um link de recuperação.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Senha atual incorreta.'
            ], 422);
        }

        $user->forceFill([
            'password' => Hash::make($validated['password'])
        ])->setRememberToken(Str::random(60));

        $user->save();

        $user->tokens()->delete();

        event(new PasswordReset($user));

        return response()->json([
            'message' => 'Senha alterada com sucesso!'
        ]);
    }
}

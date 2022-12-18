<?php

namespace App\Http\Controllers;

use App\Exceptions\User\UserException;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\PasswordUpdateRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\type;

class UserController extends Controller
{
    public function show(ShowUserRequest $request)
    {
        $user = Auth::user();

        $result = [
            'status' => true,
            'data' => $user->toArray(),
        ];

        return response($result, 200);
    }

    public function create(CreateUserRequest $request)
    {
        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->local = $request->local ?? 'GMT+3';
            $user->save();

            $result = [
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user->toArray(),
            ];

            return response($result, 200);
        } catch (Exception $e) {
            throw new UserException('User could not be created', 400);
        }
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->update($request->all());
            if (!$user) {
                throw new UserException('User could not be updated', 400);
            }
            $user = User::find(Auth::user()->id);

            $result = [
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user->toArray(),
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new UserException($e->getMessage(), 400);
        }
    }

    public function destroy(DeleteUserRequest $request)
    {
        try {
            Token::where('user_id', Auth::user()->id)->delete();
            $user = User::where('id', Auth::user()->id)->delete();
            if (!$user) {
                throw new UserException('User could not be deleted', 400);
            }
            $result = [
                'status' => true,
                'message' => 'User deleted successfully'
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new UserException($e->getMessage(), 400);
        }
    }

    public function password_update(PasswordUpdateRequest $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            if (!$user) {
                throw new UserException('User password could not be changed', 400);
            }

            $result = [
                'status' => true,
                'message' => 'User password change successful'
            ];

            return response($result, 200);
        } catch (Exception $e) {
            throw new UserException($e->getMessage(), 400);
        }
    }
}

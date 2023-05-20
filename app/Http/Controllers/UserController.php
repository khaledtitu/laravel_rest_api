<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    /**
     * Retrieve all user data with a list of all cars that are related to the user.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $users = User::with('cars')->get();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(UserRequest $request)
    {
        try {
            $user = new User;
            $user->fill($request->validated())->save();
            return new UserResource($user);

        } catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UserRequest $request, $id)
    {

        try {
            $user = User::findOrFail($id);
            $user->fill($request->validated())->save();
            return new UserResource($user);
        } catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }

    /**
     * Delete the user with all related cars.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try { 
            $user->cars()->delete();
            $user->delete();
            return response($user,JsonResponse::HTTP_NO_CONTENT);
        }catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }
}

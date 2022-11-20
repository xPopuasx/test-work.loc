<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\User\GetUsersRequest;
use App\Http\Requests\Api\Admin\User\StoreUserRequest;
use App\Http\Requests\Api\Admin\User\UpdateUserRequest;
use App\Http\Resources\Api\User\UserCollection;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @param  GetUsersRequest  $request
     * @return UserCollection
     */
    public function index(GetUsersRequest $request): UserCollection
    {
        $list = $this->userService->getWithPaginate($request->validated(), null);
        $list->load(['userCar']);

        return new UserCollection($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return UserResource
     *
     * @throws Exception
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->userService->create($request->validated(), null);
        $user->load(['userCar']);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        $user->load(['userCar']);

        return new UserResource($user);
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     *
     * @throws Exception
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user = $this->userService->update($user, $request->validated());
        $user->load(['userCar']);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);

        return response()->json('ok');
    }
}

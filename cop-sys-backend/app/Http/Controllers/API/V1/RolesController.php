<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Role\CreateRoleRequest;
use App\Http\Requests\API\V1\Role\UpdateRoleRequest;
use App\Http\Resources\API\V1\RolesResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;


class RolesController extends APIController
{
    public function addRole(CreateRoleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $roleData = Role::query()->create($data);

        return $this->respondWithSuccess(RolesResource::make($roleData));
    }

    public function updateRole(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $data = $request->validated();

        $role = Role::find($role->role_id)->firstOrFail();

        $role->update($data);

        return $this->respondWithSuccess(RolesResource::make($role));
    }

    public function removeRole(Role $role): JsonResponse
    {
        $role->delete();

        return $this->respondWithSuccess(null, __('app.role.deleted'));
    }

    public function getRole(Role $role): JsonResponse{

        return $this->respondWithSuccess($role);
    }
    public function getAllRoles(): JsonResponse{

        return $this->respondWithSuccess(Role::all());
    }

}

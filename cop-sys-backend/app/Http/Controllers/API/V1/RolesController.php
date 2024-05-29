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

    /**
     * @OA\Post(
     *     path="/api/v1/role",
     *     summary="Add a new role",
     *     tags={"Role"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function addRole(CreateRoleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $roleData = Role::query()->create($data);

        return $this->respondWithSuccess(RolesResource::make($roleData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/role/{id}",
     *     summary="Update an existing role",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role updated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateRole(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $data = $request->validated();

        $role = Role::find($role->role_id);

        $role->update($data);

        return $this->respondWithSuccess(RolesResource::make($role));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/role/{id}",
     *     summary="Remove a role",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     )
     * )
     */

    public function removeRole(Role $role): JsonResponse
    {
        $role->delete();

        return $this->respondWithSuccess(null, __('app.role.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/role/{id}",
     *     summary="Get a role by ID",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     )
     * )
     */

    public function getRole(Role $role): JsonResponse{

        return $this->respondWithSuccess($role);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/role",
     *     summary="Get all roles",
     *     tags={"Role"},
     *     @OA\Response(
     *         response=200,
     *         description="Role list retrieved successfully",
     *     )
     * )
     */
    public function getAllRoles(): JsonResponse{

        return $this->respondWithSuccess(Role::all());
    }

}

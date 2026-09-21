<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/AdminUserController.php

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetUserPasswordRequest;
use App\Http\Resources\AdminUserDetailResource;
use App\Http\Resources\AdminUserListResource;
use App\Models\User;
use App\Services\AdminUserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct(protected AdminUserService $users)
    {
    }

    public function index(Request $request)
    {
        $paginated = $this->users->list($request->only(['role', 'status']), (int) $request->input('per_page', 10));

        return AdminUserListResource::collection($paginated);
    }

    public function reactivate(Request $request, User $user)
        {
            $this->users->reactivate($user, $request->user()->id);

            return new AdminUserDetailResource($this->users->findWithHistory($user->id));
        }

    public function show(int $id)
    {
        return new AdminUserDetailResource($this->users->findWithHistory($id));
    }

    public function suspend(Request $request, User $user)
    {
        $this->users->suspend($user, $request->user()->id);

        return new AdminUserDetailResource($this->users->findWithHistory($user->id));
    }

    public function resetPassword(ResetUserPasswordRequest $request, User $user)
    {
        $this->users->resetPassword($user, $request->validated()['password']);

        return response()->json(['message' => 'Password reset successfully.']);
    }

    public function destroy(User $user)
    {
        $this->users->delete($user);

        return response()->json(['message' => 'User deleted.']);
    }
}
<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class RoleAdminMiddleware
{
    /**
     *
     *
     * @param Request $request
     * @param Closure $next
     * @param ...$roles
     *
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user_admin = auth()->user();

        // Проверяем, соответствует ли роль пользователя одной из разрешенных ролей
        foreach ($roles as $user_role) {
            $role_enum = UserAdminRole::tryFrom($user_role);
            if ($role_enum && $user_admin->role->name === $role_enum->value) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}

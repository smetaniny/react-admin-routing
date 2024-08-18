<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Enums\UserAdminRole;
use Smetaniny\ReactAdminRouting\Exceptions\UnauthorizedAdminException;

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
     * @throws UnauthorizedAdminException
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user_admin = auth()->user();

        if ($user_admin !== null) {
            // Проверяем, соответствует ли роль пользователя одной из разрешенных ролей
            foreach ($roles as $user_role) {
                $role_enum = UserAdminRole::tryFrom($user_role);
                if ($role_enum && $user_admin->role->name === $role_enum->value) {
                    return $next($request);
                }
            }
        }

//        return response()->json(['message' => 'Unauthorized'], 403);
        throw new UnauthorizedAdminException('Нет разрешения на получение данного ресурса!');
    }
}

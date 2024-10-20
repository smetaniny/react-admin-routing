<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smetaniny\ReactAdminRouting\Models\PagesModel;
use Smetaniny\ReactAdminRouting\Models\UsersAdminModel;
use Smetaniny\ReactAdminRouting\Policies\PagesPolicy;

/**
 *
 *
 * @author Smetanin Sergey
 */
class AuthReactAdminServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        PagesModel::class => PagesPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Настройка анонимного охранника аутентификации
        Auth::viaRequest('admin_token', function (Request $request) {

            // Получаем токен из заголовка Authorization
            $token = $request->bearerToken();

            // Проверяем, существует ли пользователь с данным токеном
            if ($token) {
                return UsersAdminModel::where('api_token', $token)->first();
            }

            return null;
        });
    }
}

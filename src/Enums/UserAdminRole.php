<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Enums;

/**
 * Перечисление ролей пользователей.
 *
 * Определяет различные роли, которые могут быть присвоены:
 * - ADMIN: Полные права администратора.
 * - EDITOR: Права на редактирование.
 * - VIEWER: Права только на просмотр.
 */

enum UserAdminRole: string
{
    // Администратор
    case ADMIN = 'admin';

    // Редактор
    case EDITOR = 'editor';

    // Наблюдатель
    case VIEWER = 'viewer';
}

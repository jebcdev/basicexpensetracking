<?php

/*
     para usarlo, importar el trait :
    use App\Filament\Traits\SuperAdminOrAdminOnlyResourceTrait;
    y dentro de la clase del resource darle uso
    class CompanyResource extends Resource
    {
        use SuperAdminOrAdminOnlyResourceTrait;
 */

namespace App\Filament\Traits;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;

trait OnlyAdminTrait
{
    /**
     * Determinar si el usuario puede ver el recurso en la navegación
     */
    public static function canViewAny(): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede acceder al listado
     */
    public static function canAccess(): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede ver un registro específico
     */
    public static function canView(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede crear registros
     */
    public static function canCreate(): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede editar un registro específico
     */
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede eliminar un registro específico
     */
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Determinar si el usuario puede realizar eliminaciones masivas
     */
    public static function canDeleteAny(): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Ocultar completamente de la navegación si no tiene permisos
     */
    public static function shouldRegisterNavigation(): bool
    {
        return static::hasAdminAccess();
    }

    /**
     * Lógica centralizada para verificar acceso de admin
     */
    protected static function hasAdminAccess(): bool
    {
        $user = Auth::user();
        // return $user && $user->role == Role::admin->value;
        return $user && $user->isAdmin();
    }
}

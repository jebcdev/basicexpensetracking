<?php


namespace App\Enums;

enum CashMovementRecurrentPeriod: string
{
    case daily = "daily"; // Diario
    case weekly = "weekly"; // Semanal
    case monthly = "monthly"; // Mensual
    case yearly = "yearly"; // Anual

    public static function names(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}

?>

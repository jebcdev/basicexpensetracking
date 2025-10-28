<?php


namespace App\Enums;

enum CashMovementType: string
{
    case income = "income"; // Ingreso
    case expense = "expense"; // Gasto

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

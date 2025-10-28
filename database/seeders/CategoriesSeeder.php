<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $food = Category::create([
            'name' => 'Alimentación',
            'description' => 'Gastos en comestibles y comidas',
            'color' => '#FF5733',
            'is_active' => true,
        ]);

        $transportation = Category::create([
            'name' => 'Transporte',
            'description' => 'Costos relacionados con viajes y vehículos',
            'color' => '#33FF57',
            'is_active' => true,
        ]);

        $housing = Category::create([
            'name' => 'Vivienda',
            'description' => 'Alquiler, hipoteca y mantenimiento del hogar',
            'color' => '#3357FF',
            'is_active' => true,
        ]);

        $utilities = Category::create([
            'name' => 'Servicios Públicos',
            'description' => 'Facturas mensuales de servicios públicos',
            'color' => '#F033FF',
            'is_active' => true,
        ]);

        $health = Category::create([
            'name' => 'Salud',
            'description' => 'Gastos médicos y de atención médica',
            'color' => '#FF33A1',
            'is_active' => true,
        ]);

        $education = Category::create([
            'name' => 'Educación',
            'description' => 'Escuela, cursos y materiales de aprendizaje',
            'color' => '#33FFF5',
            'is_active' => true,
        ]);

        $entertainment = Category::create([
            'name' => 'Entretenimiento',
            'description' => 'Películas, juegos y actividades de ocio',
            'color' => '#FFA133',
            'is_active' => true,
        ]);

        $clothing = Category::create([
            'name' => 'Ropa',
            'description' => 'Ropa y accesorios personales',
            'color' => '#A133FF',
            'is_active' => true,
        ]);

        $savings = Category::create([
            'name' => 'Ahorros',
            'description' => 'Dinero apartado para uso futuro',
            'color' => '#33FFA1',
            'is_active' => true,
        ]);

        $income = Category::create([
            'name' => 'Ingresos',
            'description' => 'Fuentes de ingresos y ganancias',
            'color' => '#FF3333',
            'is_active' => true,
        ]);
    }
}

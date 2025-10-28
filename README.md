# Basic Expense Tracking

## Descripción del Proyecto

Basic Expense Tracking es una aplicación web desarrollada con Laravel para el seguimiento básico de ingresos y gastos personales. Permite a los usuarios gestionar sus movimientos de efectivo, categorizarlos, y configurar movimientos recurrentes. La aplicación incluye un panel de administración construido con Filament para gestionar usuarios, categorías y movimientos.

### Características Principales

-   **Gestión de Usuarios**: Autenticación con roles (admin/usuario estándar)
-   **Categorías**: Creación y gestión de categorías con colores personalizados
-   **Movimientos de Efectivo**: Registro de ingresos y gastos con títulos, descripciones y fechas
-   **Movimientos Recurrentes**: Soporte para movimientos diarios, semanales, mensuales o anuales
-   **Panel de Administración**: Interfaz administrativa con Filament para gestión completa
-   **Interfaz Moderna**: UI construida con Tailwind CSS y Alpine.js

## Tecnologías Utilizadas

-   **Backend**: Laravel 12.x
-   **Frontend**: Tailwind CSS, Alpine.js, Vite
-   **Base de Datos**: SQLite (configurable para MySQL/PostgreSQL)
-   **Panel Admin**: Filament 4.x
-   **Autenticación**: Laravel Breeze
-   **Tests**: Pest PHP
-   **Lenguaje**: PHP 8.2+

## Requisitos del Sistema

-   PHP >= 8.2
-   Composer
-   Node.js >= 18
-   NPM o Yarn
-   SQLite (o MySQL/PostgreSQL si se configura)

## Instalación

### 1. Clonación del Repositorio

```bash
git clone https://github.com/jebcdev/basicexpensetracking
cd basicexpensetracking
```

### 2. Instalación de Dependencias

Instala las dependencias de PHP con Composer:

```bash
composer install
```

Instala las dependencias de JavaScript con NPM:

```bash
npm install
```

### 3. Configuración del Entorno

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

Genera la clave de aplicación:

```bash
php artisan key:generate
```

### 4. Configuración de la Base de Datos

Por defecto, la aplicación usa SQLite. Si deseas usar otra base de datos, modifica las variables en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Migraciones de Base de Datos

Ejecuta las migraciones para crear las tablas:

```bash
php artisan migrate
```

### 6. Seeders (Datos de Prueba)

Ejecuta los seeders para poblar la base de datos con datos de ejemplo:

```bash
php artisan db:seed
```

Esto creará:

-   Usuarios de prueba (incluyendo un admin)
-   Categorías predefinidas (Alimentación, Transporte, Vivienda, etc.)
-   Movimientos de efectivo de ejemplo (opcional, descomentado en DatabaseSeeder)

### 7. Construcción de Assets

Construye los assets del frontend:

```bash
npm run build
```

Para desarrollo con hot reload:

```bash
npm run dev
```

## Ejecución de la Aplicación

### Modo Desarrollo

Para ejecutar la aplicación en modo desarrollo con todos los servicios:

```bash
php artisan serve
```

Esto iniciará:

-   Servidor de Laravel (http://localhost:8000)
-   Queue worker
-   Logs en tiempo real
-   Vite dev server

## Estructura de la Base de Datos

### Tablas Principales

-   **users**: Usuarios del sistema con roles (admin/user)
-   **categories**: Categorías para clasificar movimientos (con colores y estado activo)
-   **cash_movements**: Movimientos de efectivo (ingresos/gastos) con soporte para recurrentes

### Enums

-   **CashMovementType**: income/expense
-   **CashMovementRecurrentPeriod**: daily/weekly/monthly/yearly
-   **Role**: admin/user

## Comandos Útiles

### Setup Completo

```bash
composer run setup
```

Este comando ejecuta automáticamente:

-   Instalación de dependencias PHP
-   Copia de .env
-   Generación de clave
-   Migraciones
-   Instalación de dependencias JS
-   Build de assets

### Limpieza de Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Generar Link de Storage (para archivos)

```bash
php artisan storage:link
```

## Panel de Administración (Filament)

Accede al panel admin en `/admin` con credenciales de usuario admin.

Funcionalidades del panel:

-   Gestión de usuarios
-   Gestión de categorías
-   Gestión de movimientos de efectivo
-   Dashboard con estadísticas

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agrega nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT.

## Soporte

Para soporte o preguntas, abre un issue en el repositorio de GitHub.

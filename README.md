# README - Instalación del Proyecto Laravel SAT

Este documento describe los pasos necesarios para configurar y ejecutar el proyecto Laravel SAT en tu entorno local.

## Requisitos del Sistema

Antes de comenzar, asegúrate de tener instalados los siguientes componentes:

### Herramientas Necesarias

#### 1. Visual Studio Code
- **Descargar desde:** https://code.visualstudio.com/download
- Editor de código recomendado para el desarrollo

#### 2. XAMPP 8.2.12
- **Descargar desde:** https://www.apachefriends.org/es/download.html
- Paquete que incluye Apache, MySQL, PHP y phpMyAdmin
- Versión específica requerida: 8.2.12

#### 3. Composer
- **Descargar desde:** https://getcomposer.org/download/
- Gestor de dependencias para PHP

#### 4. Git Bash
- **Descargar desde:** https://git-scm.com/downloads/win
- Cliente Git para Windows con terminal Bash

## Instalación del Proyecto

### 1. Preparar el Entorno XAMPP

1. Navega hasta la carpeta de XAMPP:
   ```
   C:\xampp\htdocs
   ```

2. Abre Git Bash en esta ubicación (clic derecho → "Git Bash Here")

### 2. Clonar el Repositorio

```bash
git clone https://github.com/alexandro63/sat.git
cd sat
```

### 3. Instalar Dependencias

```bash
composer update
```

### 4. Configurar Variables de Entorno

1. Copia el archivo de configuración de ejemplo:
   ```bash
   cp .env.example .env
   ```

2. Edita el archivo `.env` y modifica la siguiente variable:
   ```
   DB_DATABASE=sat
   ```
   *Cambia "sat" por el nombre de tu base de datos*

### 5. Configurar Laravel

Ejecuta los siguientes comandos en orden:

```bash
# Generar clave de aplicación
php artisan key:generate

# Limpiar caché
php artisan optimize:clear

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Iniciar servidor de desarrollo
php artisan serve
```

### 6. Configurar XAMPP

1. Ejecuta el panel de control de XAMPP:
   ```
   C:\xampp\xampp-control.exe
   ```

2. Activa los siguientes servicios:
   - **Apache**
   - **MySQL**

### 7. Acceder a phpMyAdmin

- **URL:** http://localhost/phpmyadmin
- Aquí podrás administrar tu base de datos MySQL

## Acceso a la Aplicación

### Credenciales de Login

- **Usuario:** `admin`
- **Contraseña:** `123456`

### URL de la Aplicación

Una vez que ejecutes `php artisan serve`, la aplicación estará disponible en:
- **URL:** http://localhost:8000

## Solución de Problemas Comunes

### Error de Conexión a Base de Datos
- Verifica que MySQL esté ejecutándose en XAMPP
- Confirma que el nombre de la base de datos en `.env` sea correcto
- Asegúrate de que la base de datos existe en phpMyAdmin

### Error de Composer
- Verifica que Composer esté instalado correctamente
- Ejecuta `composer --version` para confirmar la instalación

### Error de Permisos
- En Windows, ejecuta Git Bash como administrador si encuentras problemas de permisos

## Estructura del Proyecto

```
sat/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env
├── .env.example
├── artisan
├── composer.json
└── README.md
```

## Comandos Útiles

```bash
# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de rutas
php artisan route:clear

# Limpiar caché de vistas
php artisan view:clear

# Ver rutas disponibles
php artisan route:list

# Crear nuevo controlador
php artisan make:controller NombreController

# Crear nueva migración
php artisan make:migration nombre_migracion
```

## Soporte

Si encuentras problemas durante la instalación, verifica que:
- Todas las herramientas estén instaladas correctamente
- Los servicios de XAMPP estén ejecutándose
- Las variables de entorno estén configuradas correctamente
- Los permisos de carpeta sean adecuados

---

**Nota:** Este proyecto requiere PHP 8.2 o superior. XAMPP 8.2.12 incluye la versión correcta de PHP.

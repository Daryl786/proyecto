# Mini Framework MVC Educativo

## Estructura

- `app/Core`: Clases principales del framework
- `app/Controllers`: Controladores de la aplicación
- `app/Models`: Modelos de datos
- `app/Views`: Vistas y componentes
- `config`: Configuraciones
- `public`: Archivos accesibles públicamente

## Requisitos

- PHP >= 7.4
- Composer
- Apache con mod_rewrite habilitado

## Instalación

1. Clonar el repositorio
2. Ejecutar `composer install` dentro del directorio mini-framework
3. Configurar el servidor web para que apunte a `mini-framework/public`

## Uso rápido con PHP incorporado

Para probar rápidamente el framework sin configurar un servidor web completo:

```bash
cd mini-framework/public
php -S localhost:8000
```

Luego visita http://localhost:8000 en tu navegador.

## Credenciales de prueba

- Email: admin@example.com
- Contraseña: 1234

## Rutas disponibles

- `/`: Página de inicio
- `/login`: Formulario de login
- `/logout`: Cerrar sesión
- `/dashboard`: Área privada (requiere autenticación)
- `/dashboard/:id`: Detalles de usuario (requiere autenticación)

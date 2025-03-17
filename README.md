# CONCEJOSG - Sistema del Concejo Deliberante de San Genaro

Este repositorio contiene el código fuente del sitio web y sistema de administración del Concejo Deliberante de San Genaro, Santa Fe, Argentina.

## Características

- Sitio web público con información institucional
- Sistema de noticias y actualizaciones
- Gestión de sesiones y ordenanzas
- Panel de administración para la gestión de contenidos
- Información sobre concejales y bloques políticos

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

## Instalación

1. Clonar el repositorio:
   ```
   git clone https://github.com/emirovetto/CONCEJOSG.git
   ```

2. Configurar la base de datos:
   - Crear una base de datos en MySQL
   - Importar el archivo `database_setup.sql`
   - Configurar los parámetros de conexión en `app/config/config.php`

3. Configurar el servidor web:
   - Configurar el documento raíz al directorio del proyecto
   - Asegurarse de que el módulo de reescritura (mod_rewrite) esté habilitado

4. Permisos:
   - Asignar permisos de escritura a la carpeta `app/public/uploads`

## Estructura del Proyecto

- `/app`: Código principal de la aplicación
  - `/admin`: Archivos específicos del panel de administración
  - `/config`: Archivos de configuración
  - `/controllers`: Controladores de la aplicación
  - `/includes`: Archivos de funciones y utilidades
  - `/models`: Modelos de datos
  - `/public`: Archivos públicos (imágenes, CSS, JS)
  - `/views`: Plantillas y vistas

- `/admin`: Punto de entrada para el panel de administración

## Acceso al Panel de Administración

- URL: `/admin`
- Usuario por defecto: `admin`
- Contraseña por defecto: `admin123`

## Mantenimiento

Para reportar problemas o sugerir mejoras, por favor abrir un issue en este repositorio.

## Licencia

Todos los derechos reservados - Concejo Deliberante de San Genaro 
# Inventario · PHP / Laravel + MySQL

CRUD de productos desarrollado en **Laravel 11 (PHP 8.3)** con base de datos **MySQL 8.4**, desplegado en el PaaS multi-tenant sobre Kubernetes (inquilino `tenant-alpha`).

**URL:** http://inventario.paas.local

## Funcionalidad

| Ruta | Acción |
|---|---|
| `GET /productos` | Listado con búsqueda, filtro por categoría, paginación y resumen del inventario |
| `GET /productos/create` · `POST /productos` | Crear producto |
| `GET /productos/{id}` | Ver detalle |
| `GET /productos/{id}/edit` · `PUT /productos/{id}` | Editar producto |
| `DELETE /productos/{id}` | Eliminar producto |
| `GET /up` | Salud de la aplicación |

## Estructura

Este repositorio contiene sólo el código propio de la aplicación. El `Dockerfile` parte del esqueleto oficial de Laravel 11 (`composer create-project`) y copia encima estos archivos:

```
app/Models/Producto.php                    Modelo Eloquent
app/Http/Controllers/ProductoController.php  CRUD y validaciones
database/migrations/                        Tabla productos
database/seeders/ProductoSeeder.php         Datos iniciales
resources/views/                            Vistas Blade
routes/web.php                              Rutas
bootstrap/app.php                           Confianza en el Ingress (proxies)
docker/                                     Apache, PHP y script de arranque
paas/values.yaml                            Lo que el cliente entrega al PaaS
.github/workflows/desplegar.yml             Despliegue automático
```

## Variables de entorno

No hay credenciales en este repositorio. Las variables llegan al contenedor desde la plataforma:

| Variable | Origen |
|---|---|
| `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `LOG_CHANNEL`, `DB_CONNECTION`, `SESSION_DRIVER`, `CACHE_STORE` | `paas/values.yaml` → ConfigMap |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Secret `bd-credenciales`, generado por la plataforma |
| `APP_KEY` | Secret `app-secretos`, generado por la plataforma |

## Despliegue continuo

Cada `git push` a `main` ejecuta el workflow `Desplegar en el PaaS` en el runner de la plataforma:

1. Descarga el código.
2. Construye la imagen desde el `Dockerfile`, etiquetada con el commit (`<sha>-<número de ejecución>`).
3. Despliega con el CLI del PaaS (`paas-deploy.sh`), que aplica el plan del inquilino.
4. Espera a que los pods nuevos estén listos y comprueba `GET /up`.

Al arrancar, el contenedor ejecuta las migraciones pendientes, así que los cambios de esquema se aplican con el mismo push.

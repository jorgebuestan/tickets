# Tickets Alfa

Aplicacion Laravel para seleccionar un numero unico entre 1 y 1000.

La aplicacion usa PostgreSQL. En desarrollo local se esperan los valores habituales de PostgreSQL (`127.0.0.1:5432`, usuario `postgres`). En Render deben configurarse las credenciales de la base PostgreSQL como variables de entorno, sin subirlas a GitHub.

## Configuracion local con Laragon

1. Inicia Apache y MySQL desde Laragon.
2. Crea una base de datos MySQL llamada `tickets_alfa`.
3. Revisa las credenciales en `.env`.
4. Ejecuta:

```bash
php artisan migrate
php artisan serve
```

Abre `http://127.0.0.1:8000`.

La tabla `ticket_selections` tiene una restriccion `UNIQUE` sobre `ticket_number`; esto evita duplicados incluso cuando dos solicitudes llegan simultaneamente. La IP se registra automaticamente. La geolocalizacion debe conectarse posteriormente a un proveedor GeoIP y no debe sustituir la politica de privacidad.
"# tickets" 

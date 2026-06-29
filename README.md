# Vivero — Backend

API REST del e-commerce de plantas. Proyecto universitario. Gestiona productos, clientes, autenticación y ventas.

## Enlaces

- **App en producción:** https://aplicaciones-web-2urn.vercel.app/login
- **Repositorio del frontend:** https://github.com/R4WR-XD/aplicaciones-web

---

## Tecnologías

- PHP 8.2 + Laravel 11
- Laravel Sanctum (autenticación con tokens)
- MySQL
- Faker (seeders)

---

## Funcionalidades

- CRUD de productos con soft deletes y stock
- Categorización de productos por tags
- Registro e inicio de sesión de clientes con token Bearer
- Historial de ventas por cliente
- Registro de ventas con detalle por producto

---

## Endpoints (`/api`)

### Públicos

| Método | Ruta | Descripción |
|--------|------|-------------|
| `GET` | `/api/productos` | Listar productos |
| `GET` | `/api/productos/{id}` | Detalle de un producto |
| `GET` | `/api/tags` | Listar categorías |
| `POST` | `/api/clientes/register` | Registrar nuevo cliente |
| `POST` | `/api/clientes/login` | Login → devuelve Bearer token |

### Autenticados (`Authorization: Bearer <token>`)

| Método | Ruta | Descripción |
|--------|------|-------------|
| `POST` | `/api/clientes/logout` | Logout |
| `GET` | `/api/clientes/me` | Datos del cliente autenticado |
| `GET` | `/api/clientes/me/ventas` | Historial de compras del cliente |
| `POST` | `/api/ventas` | Registrar una venta |



## Tablas

| Tabla | Columnas principales |
|-------|---------------------|
| `users` | `id`, `name`, `email`, `password` |
| `cliente` | `id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `direccion` |
| `productos` | `id`, `nombre`, `nombre_cientifico`, `precio`, `stock` (soft deletes) |
| `tags` | `id`, `nombre` |
| `producto_tag` | `producto_id`, `tag_id` (pivot) |
| `venta` | `id`, `fecha`, `idcliente` |
| `detalleventa` | `id`, `idventa`, `idproducto`, `cantidad`, `preciounitario` |

---

## Usuarios de prueba.

### Clientes (tabla `cliente`)

| Campo | Valor |
|-------|-------|
| Email | `test@test.com` |
| Contraseña | `testtest` |


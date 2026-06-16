# API Reference — Vivero

Base URL: `/v1`

Todas las respuestas son JSON. Las rutas protegidas requieren el header:

```
Authorization: Bearer {token}
```

El token se obtiene haciendo login en `POST /v1/clientes/login`.

---

## Autenticación

### POST /v1/clientes/register
Registro de un cliente nuevo. No requiere token.

**Body**
```json
{
  "nombre":    "Ana",
  "apellido":  "García",
  "email":     "ana@email.com",
  "password":  "minimo8caracteres",
  "telefono":  "1234567890",
  "direccion": "Calle Falsa 123"
}
```

**Respuesta 201**
```json
{
  "id": 5,
  "nombre": "Ana",
  "apellido": "García",
  "email": "ana@email.com"
}
```

---

### POST /v1/clientes/login
Inicia sesión y devuelve un token. No requiere token.

**Body**
```json
{
  "email":    "ana@email.com",
  "password": "minimo8caracteres"
}
```

**Respuesta 200**
```json
{
  "token": "1|abc123...",
  "cliente": {
    "id":       5,
    "nombre":   "Ana",
    "apellido": "García",
    "email":    "ana@email.com"
  }
}
```

**Respuesta 401** — credenciales incorrectas
```json
{ "message": "Credenciales incorrectas." }
```

---

### POST /v1/clientes/logout
Invalida el token actual. **Requiere token.**

**Respuesta 200**
```json
{ "message": "Sesión cerrada." }
```

---

## Productos — Público

### GET /v1/productos
Lista todos los productos con sus categorías y stock.

**Respuesta 200**
```json
[
  {
    "id":               1,
    "nombre":           "Rosa",
    "nombre_cientifico":"Rosa gallica",
    "precio":           1500,
    "stock":            5,
    "img_url":          "https://...",
    "tags": [
      { "id": 2, "nombre": "Exterior" }
    ]
  }
]
```

---

### GET /v1/productos/{id}
Detalle de un producto específico.

**Respuesta 200** — mismo formato que el objeto individual de arriba.

**Respuesta 404** — producto no encontrado.

---

## Tags / Categorías — Público

### GET /v1/tags
Lista todas las categorías disponibles. Útil para armar filtros en el frontend.

**Respuesta 200**
```json
[
  { "id": 1, "nombre": "Interior" },
  { "id": 2, "nombre": "Exterior" }
]
```

---

## Cliente — Requiere token

### GET /v1/clientes/me
Devuelve los datos del cliente autenticado.

**Respuesta 200**
```json
{
  "id":        5,
  "nombre":    "Ana",
  "apellido":  "García",
  "email":     "ana@email.com",
  "telefono":  "1234567890",
  "direccion": "Calle Falsa 123"
}
```

---

### GET /v1/clientes/me/ventas
Devuelve el historial de compras del cliente autenticado.

**Respuesta 200**
```json
[
  {
    "id":     12,
    "fecha":  "2026-06-07",
    "detalles": [
      {
        "idproducto":     1,
        "cantidad":       2,
        "preciounitario": 1500,
        "producto": {
          "id":     1,
          "nombre": "Rosa"
        }
      }
    ]
  }
]
```

---

## Resumen de endpoints

| Acceso    | Método | Ruta                      | Descripción                        |
|-----------|--------|---------------------------|------------------------------------|
| Público   | GET    | `/v1/productos`           | Listar productos con stock y tags  |
| Público   | GET    | `/v1/productos/{id}`      | Detalle de un producto             |
| Público   | GET    | `/v1/tags`                | Listar categorías                  |
| Público   | POST   | `/v1/clientes/register`   | Registro de nuevo cliente          |
| Público   | POST   | `/v1/clientes/login`      | Login — devuelve token             |
| Con token | POST   | `/v1/clientes/logout`     | Cerrar sesión                      |
| Con token | GET    | `/v1/clientes/me`         | Perfil del cliente autenticado     |
| Con token | GET    | `/v1/clientes/me/ventas`  | Historial de compras del cliente   |

# Pendientes - Back Final

## Alta Prioridad

### 1. CRUD completo de Ventas
- [ ] `VentaController@store` — crear venta con sus detalles (idcliente, productos, cantidades)
- [ ] `VentaController@destroy` — eliminar venta
- [ ] Rutas POST/DELETE en `web.php`
- [ ] Vista/modal para crear venta desde el front

### 2. Stock en Producto
- [ ] Migración: agregar columna `stock` (integer, default 0) a `productos`
- [ ] Actualizar `ProductoController@store` y `@update` para manejar stock
- [ ] Descontar stock automáticamente al registrar una venta (`VentaController@store`)
- [ ] Mostrar estado "Sin stock" / "Bajo stock" en la vista de productos

### 3. CRUD completo de Clientes
- [ ] Migración: agregar campos a `clientes` (nombre, email, teléfono, dirección)
- [ ] Crear `ClienteController` con index / store / update / destroy
- [ ] Rutas resource en `web.php`
- [ ] Vista con tabla + modales (igual que usuarios/productos)

### 4. Historial de compras por Cliente
- [ ] `ClienteController@show` — devuelve ventas asociadas al cliente
- [ ] Vista de detalle del cliente con sus compras

---

## Media Prioridad

### 5. Endpoints JSON (API REST)
- [ ] Crear `routes/api.php` con rutas para el frontend del cliente
- [ ] `GET /api/productos` — listado de productos con stock y tags
- [ ] `GET /api/clientes/{id}/ventas` — historial de un cliente
- [ ] Instalar Laravel Sanctum para autenticación por token (clientes del front)

### 6. Reportes en Dashboard
- [ ] Total facturado (mes actual vs mes anterior)
- [ ] Producto más vendido
- [ ] Cliente que más compró
- [ ] Ventas por período (filtro por fecha)

### 7. Roles: Admin vs Cliente
- [ ] Agregar campo `rol` a `users` (o separar con modelo `Cliente` autenticable)
- [ ] Middleware que restrinja rutas de admin

---

## Fácil / Quick Wins

### 8. Soft Deletes
- [ ] Agregar `SoftDeletes` trait en `Producto`, `Cliente`, `Venta`
- [ ] Migración: columna `deleted_at` en cada tabla

### 9. Filtros y búsqueda
- [ ] Búsqueda de productos por nombre o nombre científico
- [ ] Filtrar ventas por fecha o por cliente
- [ ] Filtrar productos por tag

### 10. Validaciones robustas
- [ ] Crear `FormRequest` para Producto (precio > 0, stock >= 0, nombre requerido)
- [ ] Crear `FormRequest` para Cliente (email único, teléfono opcional)
- [ ] Crear `FormRequest` para Venta (cliente existente, productos con stock disponible)

---

## Orden sugerido de implementación

1. Stock en Producto (migración simple, alto impacto)
2. CRUD Clientes (modelo ya existe, falta todo lo demás)
3. CRUD Ventas completo (depende de clientes y stock)
4. Historial por cliente (sale solo con lo anterior)
5. Validaciones (se agregan sobre lo ya construido)
6. Reportes en dashboard
7. API REST + Sanctum
8. Soft Deletes
9. Roles
10. Filtros y búsqueda

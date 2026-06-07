# Seeders

Scripts para poblar la base de datos con datos de prueba.

## Ejecución

```bash
# Correr todos los seeders
php artisan db:seed

# Correr uno específico
php artisan db:seed --class=TagsSeeder
php artisan db:seed --class=ProductosSeeder
php artisan db:seed --class=ClientesSeeder
php artisan db:seed --class=UsersSeeder
php artisan db:seed --class=VentasSeeder

# Resetear toda la BD y resembrar (solo desarrollo)
php artisan migrate:fresh --seed
```

## Seeders disponibles

### UsersSeeder
Crea 3 usuarios fijos (personal del sistema).

| Nombre | Email | Contraseña |
|--------|-------|------------|
| Admin | admin@vivero.com | admin1234 |
| Juan Vendedor | juan@vivero.com | vendedor1234 |
| Ana Vendedora | ana@vivero.com | vendedor1234 |

Usa `insertOrIgnore` por email — no duplica si ya existen.

---

### TagsSeeder
Crea 7 categorías fijas: `Suculentas`, `Cactus`, `Tropicales`, `Aromáticas`, `Flores`, `Árboles`, `Helechos`.

Usa `insertOrIgnore` por nombre — no duplica si ya existen.

---

### ProductosSeeder
Crea 15 productos fijos con nombre científico, precio y categoría asignada.

Usa `insertOrIgnore` por nombre — no duplica si ya existen.

---

### ClientesSeeder
Genera **15 clientes** con datos aleatorios en español (Faker `es_AR`): nombre, apellido, email, teléfono y dirección. La contraseña de todos es `password123`.

Usa `insertOrIgnore` por email — si Faker genera un email ya existente, lo omite.

---

### VentasSeeder
Genera **50 ventas** con entre 1 y 4 productos cada una, distribuidas aleatoriamente en los últimos 2 años.

- El precio unitario se toma del precio real del producto.
- Los clientes y productos se asignan al azar entre los existentes en la BD.
- **Hace `truncate` de `venta` y `detalleventa` antes de insertar** — cada vez que se corre, borra las ventas anteriores y genera 50 nuevas.

> Requiere que ya existan productos y clientes en la BD.

## Comportamiento ante datos existentes

| Seeder | Si ya hay datos |
|--------|----------------|
| UsersSeeder | No duplica (ignora por email) |
| TagsSeeder | No duplica (ignora por nombre) |
| ProductosSeeder | No duplica (ignora por nombre) |
| ClientesSeeder | No duplica (ignora por email) |
| VentasSeeder | Borra todo y regenera 50 ventas nuevas |

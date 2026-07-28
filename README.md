# PetFy Pet Shop — Laravel E-commerce

Sistema de e-commerce de productos para mascotas desarrollado con **Laravel 11**, **MySQL** y **Tailwind CSS** como Trabajo Final de la materia Desarrollo de Aplicaciones Web.

---

## Descripción del proyecto y alcance funcional

PetFy permite a los visitantes navegar un catálogo de productos para mascotas; a los clientes registrados realizar pedidos, gestionar su wishlist y dejar reseñas; y a los administradores gestionar el catálogo completo, los pedidos y los usuarios. Adicionalmente expone un subconjunto de la funcionalidad como **API REST**.

**Fuera del alcance:** pasarela de pago real, envío de emails (driver `log`), notificaciones en tiempo real, autenticación stateless con tokens.

Ver el relevamiento completo en [`docs/analisis.md`](docs/analisis.md).
Ver el cumplimiento de requisitos técnicos (punto 7) en [`docs/proyecto.md`](docs/proyecto.md).

---

## Instalación paso a paso

### Requisitos previos
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL / MariaDB

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/brodevr/EcommerceLaravel.git
cd EcommerceLaravel

# 2. Instalar dependencias PHP
composer install

# 3. Copiar y configurar el entorno
cp .env.example .env
php artisan key:generate

# 4. Editar .env con los datos de la base de datos
#    DB_DATABASE=ecommerce_laravel
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Instalar dependencias JS y compilar assets
npm install && npm run build

# 7. Levantar el servidor
php artisan serve
```

La aplicación estará disponible en **`http://localhost:8000`**.

---

## Credenciales de prueba

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@petfy.com | Admin1234 |
| Cliente | ana@petfy.com | Cliente1234 |
| Cliente | carlos@petfy.com | Cliente1234 |
| Cliente | maria@petfy.com | Cliente1234 |

---

## Diagrama E-R

Ver diagrama completo con Mermaid ERD en [`docs/er-diagram.md`](docs/er-diagram.md).

```
users ──1:N──► orders ──1:N──► order_items ◄──N:1── products
  │                                                      │
  ├──1:N──► addresses ◄──N:1── orders                   ├──N:M── categories
  ├──1:N──► reviews ────────────────────────────────────►│
  └──1:N──► wishlists ──────────────────────────────────►│
```

**Relaciones principales:**
- `users` → `orders` (1:N) — un usuario puede tener muchos pedidos
- `orders` → `order_items` (1:N) — un pedido contiene uno o más ítems con cantidad y precio
- `products` ↔ `categories` (N:M) — tabla pivote `category_product`
- `users` → `addresses` (1:N) — múltiples direcciones de envío por usuario
- `orders` → `addresses` (N:1) — el pedido guarda la dirección de envío seleccionada
- `users` ↔ `products` vía `reviews` (N:M con rating y comment)
- `users` ↔ `products` vía `wishlists` (N:M simple)

---

## Decisiones de diseño relevantes

- **OrderStatus como Enum PHP 8.1:** el campo `status` de `orders` usa un Enum de Laravel con transiciones válidas declaradas en el modelo. Las transiciones inválidas lanzan `DomainException` en la capa de negocio, no solo en la vista.
- **"Procesando" en lugar de "Pagado":** el flujo es `pendiente → procesando → enviado → entregado`. Se adoptó "procesando" porque no hay pasarela de pago real; semánticamente equivale a "pago confirmado y en preparación".
- **Carrito en sesión:** el carrito funciona sin autenticación (sesión PHP). Al hacer checkout se requiere login.
- **Middleware EnsureUserIsAdmin:** restringe todas las rutas `/admin/*` a usuarios con `role = admin`.
- **Form Requests para todas las validaciones:** ningún controller valida inline; toda la lógica de validación está en clases `FormRequest`.
- **API REST con sesión web:** los endpoints `/api/*` reutilizan la autenticación de sesión del sitio (no requieren Sanctum). Es suficiente para el alcance de la materia.
- **Tailwind CSS via Vite:** el CSS se compila con `npm run build`. Para entornos compartidos por ngrok, siempre usar el build de producción (no `npm run dev`).

---

## Rutas principales del sitio

| Método | Ruta | Descripción | Autenticación |
|--------|------|-------------|---------------|
| GET | `/` | Página de inicio | — |
| GET | `/productos` | Catálogo de productos | — |
| GET | `/productos/{product}` | Detalle de producto | — |
| GET | `/categorias/{category}` | Productos por categoría | — |
| GET | `/carrito` | Ver carrito | — |
| POST | `/carrito/agregar/{product}` | Agregar al carrito | — |
| GET | `/nosotros` | Página institucional | — |
| GET | `/contacto` | Formulario de contacto | — |
| GET | `/wishlist` | Lista de deseos | auth |
| GET | `/checkout` | Confirmar pedido | auth |
| POST | `/pedidos` | Crear pedido | auth |
| GET | `/pedidos` | Mis pedidos | auth |
| GET | `/pedidos/{order}` | Detalle de pedido | auth |
| POST | `/productos/{product}/resenas` | Dejar reseña | auth |
| GET/POST/PUT/DELETE | `/direcciones` | Gestión de direcciones | auth |
| GET | `/profile` | Editar perfil | auth |
| GET | `/admin/productos` | Panel — Productos | auth + admin |
| GET | `/admin/categorias` | Panel — Categorías | auth + admin |
| GET | `/admin/pedidos` | Panel — Pedidos | auth + admin |
| GET | `/admin/usuarios` | Panel — Usuarios | auth + admin |
| GET | `/admin/reportes` | Panel — Reportes | auth + admin |

---

## Endpoints de la API REST

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/products` | Listado paginado de productos activos con categorías | — |
| GET | `/api/products/{id}` | Detalle de producto con categorías y reseñas | — |
| GET | `/api/orders` | Pedidos del usuario autenticado con ítems | Sesión web |

Los endpoints devuelven JSON con los códigos HTTP correspondientes (200, 404, 401).

Para probar con **Postman**: importar `petfy-api.postman_collection.json`. Para el endpoint de pedidos, copiar la cookie `laravel_session` del navegador al header `Cookie` de Postman luego de iniciar sesión.

---

## Estructura del proyecto

```
app/
├── Enums/          — OrderStatus, Role
├── Http/
│   ├── Controllers/
│   │   ├── Admin/  — Panel de administración
│   │   └── Api/    — Endpoints REST (ProductController, OrderController)
│   ├── Middleware/ — EnsureUserIsAdmin
│   └── Requests/   — Form Requests para todas las validaciones
├── Models/         — User, Product, Category, Order, OrderItem, Review, Wishlist, Address
└── Policies/       — OrderPolicy (autoriza acceso al pedido propio)
database/
├── factories/      — UserFactory, ProductFactory, CategoryFactory, OrderFactory, AddressFactory, ReviewFactory
├── migrations/     — Todas las tablas con claves foráneas y onDelete
└── seeders/        — CategorySeeder, ProductSeeder, UserSeeder (admin + clientes + pedidos)
docs/
├── analisis.md     — Relevamiento de requisitos (actores, RF, RNF, casos de uso, alcance)
└── er-diagram.md   — Diagrama Entidad-Relación (Mermaid ERD)
routes/
├── web.php         — Rutas web (públicas, cliente, admin)
└── api.php         — Endpoints REST
petfy-api.postman_collection.json — Colección de Postman con pm.test()
```

# PetFy Pet Shop — Laravel E-commerce

Sistema de e-commerce de productos para mascotas desarrollado con **Laravel 11**, **MySQL** y **Tailwind CSS** como Trabajo Final de la materia Desarrollo de Aplicaciones Web.

---

## Descripción del proyecto y alcance funcional

PetFy permite a los visitantes navegar un catálogo de productos para mascotas; a los clientes registrados realizar pedidos, gestionar su wishlist y dejar reseñas; y a los administradores gestionar el catálogo completo, los pedidos y los usuarios. Adicionalmente expone un subconjunto de la funcionalidad como **API REST**.

**Fuera del alcance:** pasarela de pago real, envío de emails (driver `log`), notificaciones en tiempo real, autenticación stateless con tokens.

Ver el relevamiento completo en [`docs/analisis.md`](docs/analisis.md).

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

## Cumplimiento de requisitos técnicos (Punto 7)

### 7.1 Arquitectura MVC

| Requisito | Cómo se cumple |
|-----------|----------------|
| Controllers delgados — sin lógica de negocio inline | Todos los controllers delegan validaciones a Form Requests y reglas de negocio a los modelos. Ej: `OrderController::store()` usa `StoreOrderRequest`; la transición de estado se delega a `Order::changeStatus()`. |
| Separación Model / Controller / View | Models en `app/Models/`, lógica de presentación en `resources/views/` con Blade, controllers en `app/Http/Controllers/`. |
| Route Model Binding | Usado en todas las rutas que reciben un modelo: `products/{product}`, `orders/{order}`, `direcciones/{address}`, `admin/pedidos/{order}`, `api/products/{product}`. |
| Sin queries SQL crudas | Todo el acceso a datos usa Eloquent ORM: `where()`, `with()`, `paginate()`, relaciones. No hay ningún `DB::statement()` ni SQL raw. |
| Views con layouts reutilizables | Layout base `layouts/petfy.blade.php` (cliente) y `layouts/admin.blade.php` (panel). Partials: `partials/nav.blade.php`, `partials/footer.blade.php`, `partials/flash.blade.php`. Todas las vistas usan `@extends`, `@section` e `@include`. |

### 7.2 Configuración de entorno

| Requisito | Cómo se cumple |
|-----------|----------------|
| `.env` con todas las variables requeridas | `APP_URL`, `APP_ENV`, `APP_DEBUG`, `DB_*`, `MAIL_*`, `SESSION_*`, `TRUSTED_PROXIES` configurados. |
| `.env.example` en el repositorio | ✅ Incluido. El `.env` real está en `.gitignore`. |
| `.gitignore` correcto | ✅ Excluye `.env`, `/vendor`, `/node_modules`, `/public/build`, `/public/hot`, `*.log`. |
| `config()` en lugar de `env()` fuera de config/ | Ningún controller ni modelo llama a `env()` directamente. Se usan helpers de config donde corresponde. |

### 7.3 Base de datos y ORM

| Requisito | Cómo se cumple |
|-----------|----------------|
| Migraciones con claves foráneas y `onDelete` | 10 migraciones en `database/migrations/`. Todas usan `foreignId()->constrained()` con `onDelete('cascade')` o `nullOnDelete()` explícito. |
| Relaciones Eloquent completas | `belongsTo`, `hasMany`, `belongsToMany` declaradas en todos los modelos. `withPivot` donde hay atributos propios (no aplica en este caso ya que `order_items` es un modelo propio). |
| Seeders y Factories | Seeders: `CategorySeeder`, `ProductSeeder`, `UserSeeder` (crea admin + 3 clientes + pedidos en distintos estados). Factories: `UserFactory`, `CategoryFactory`, `ProductFactory`, `OrderFactory`, `AddressFactory`, `ReviewFactory`. |
| Accessors / Casts | `Product::$formatted_price` (Accessor formateado). `Order::status` casteado a `OrderStatus` (Enum). `Order::total` casteado a `decimal:2`. `User::role` casteado a `Role` (Enum). `Address::is_default` casteado a `boolean`. |

### 7.4 Middleware

| Requisito | Cómo se cumple |
|-----------|----------------|
| Middleware `auth` en rutas protegidas | Todas las rutas de cliente (wishlist, pedidos, checkout, direcciones, perfil) y admin están dentro de `Route::middleware('auth')->group(...)`. |
| Middleware de rol personalizado (`EnsureUserIsAdmin`) | `app/Http/Middleware/EnsureUserIsAdmin.php` registrado como alias `admin` en `bootstrap/app.php`. Aplicado a todo el grupo `Route::middleware(['auth', 'admin'])->prefix('admin')`. |
| Policies de Laravel | `app/Policies/OrderPolicy.php` — métodos `view()` y `update()` verifican que `$user->id === $order->user_id`. Invocada con `$this->authorize('view', $order)` en `OrderController::show()`. Auto-descubierta por Laravel por convención de nombres. |

### 7.5 Estilos y front-end

| Requisito | Cómo se cumple |
|-----------|----------------|
| Framework CSS vía Vite | **Tailwind CSS** integrado con `@vite(['resources/css/app.css', 'resources/js/app.js'])` en los layouts. Build de producción: `npm run build`. |
| Diseño responsive | Clases `sm:`, `md:`, `lg:` de Tailwind en todas las vistas. Catálogo en grid responsive (`grid-cols-1 sm:grid-cols-2 lg:grid-cols-3`). Nav con menú hamburguesa en mobile. |
| Layout consistente según rol | Nav de cliente (celeste) para visitantes y clientes. Nav de admin (oscuro con badge ADMIN) para administradores. Footer en todas las páginas públicas. Detectado automáticamente en `partials/nav.blade.php` con `@if(auth()->check() && auth()->user()->isAdmin())`. |

### 7.6 Validaciones

| Requisito | Cómo se cumple |
|-----------|----------------|
| Form Requests — sin validación inline | Todos los formularios usan clases dedicadas en `app/Http/Requests/`: `StoreProductRequest`, `UpdateProductRequest`, `StoreCategoryRequest`, `UpdateCategoryRequest`, `StoreOrderRequest`, `StoreReviewRequest`, `StoreContactRequest`, `UpdateOrderStatusRequest`, `UpdateUserRequest`, `ProfileUpdateRequest`. |
| Mensajes de error en vistas | Errores mostrados con `@error('campo')` en todos los formularios. Mensajes de éxito/error globales via `session('success')` / `session('error')` en el layout. |

### 7.7 API REST

| Requisito | Cómo se cumple |
|-----------|----------------|
| Mínimo 3 endpoints | `GET /api/products`, `GET /api/products/{id}`, `GET /api/orders`. Definidos en `routes/api.php`, implementados en `app/Http/Controllers/Api/`. |
| JSON con códigos HTTP correctos | 200 en respuestas exitosas, 404 para producto no encontrado o inexistente, 401/302 si `/api/orders` se llama sin sesión. |
| Autenticación por sesión (sin Sanctum) | `/api/orders` usa `middleware(['web', 'auth'])` — reutiliza la cookie de sesión del sitio. No requiere tokens. |
| Colección Postman con `pm.test()` | `petfy-api.postman_collection.json` en la raíz del proyecto. Incluye 4 requests con múltiples `pm.test()` por endpoint validando status code, Content-Type y estructura del JSON. |

### 7.8 Documentación

| Requisito | Dónde está |
|-----------|------------|
| Descripción del proyecto y alcance funcional | Este README, sección "Descripción del proyecto". Detalle completo en `docs/analisis.md`. |
| Instrucciones de instalación paso a paso | Este README, sección "Instalación paso a paso". |
| Credenciales de prueba | Este README, sección "Credenciales de prueba". |
| Diagrama E-R con explicación de relaciones | `docs/er-diagram.md` (Mermaid ERD). Resumen en sección "Diagrama E-R" de este README. |
| Decisiones de diseño relevantes | Este README, sección "Decisiones de diseño relevantes". |
| Lista de rutas y endpoints API | Este README, secciones "Rutas principales del sitio" y "Endpoints de la API REST". |

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

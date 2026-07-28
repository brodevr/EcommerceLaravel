# Cumplimiento de requisitos técnicos — Punto 7

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
| Descripción del proyecto y alcance funcional | `README.md`, sección "Descripción del proyecto". Detalle completo en `docs/analisis.md`. |
| Instrucciones de instalación paso a paso | `README.md`, sección "Instalación paso a paso". |
| Credenciales de prueba | `README.md`, sección "Credenciales de prueba". |
| Diagrama E-R con explicación de relaciones | `docs/er-diagram.md` (Mermaid ERD). Resumen en `README.md`, sección "Diagrama E-R". |
| Decisiones de diseño relevantes | `README.md`, sección "Decisiones de diseño relevantes". |
| Lista de rutas y endpoints API | `README.md`, secciones "Rutas principales del sitio" y "Endpoints de la API REST". |

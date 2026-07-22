# PetFy Pet Shop — Documentación del Proyecto

> Laravel 11 · Breeze · Tailwind CSS · Vite · MySQL

---

## Cómo está armado Laravel

```
proyecto/
├── app/
│   ├── Enums/          ← tipos con valores fijos (Role, OrderStatus)
│   ├── Http/
│   │   ├── Controllers/  ← lógica de cada sección
│   │   └── Requests/     ← validaciones de formularios
│   ├── Models/           ← representan las tablas de la BD
│   └── View/             ← Composers (datos globales a vistas)
├── database/
│   ├── migrations/       ← crean/modifican las tablas
│   └── seeders/          ← cargan datos de prueba
├── resources/
│   ├── css/app.css       ← entrada de Tailwind
│   ├── js/app.js         ← entrada de JavaScript
│   └── views/            ← HTML con Blade (motor de plantillas)
├── routes/
│   ├── web.php           ← rutas públicas y de usuario
│   └── auth.php          ← rutas de login/registro (generadas por Breeze)
├── public/               ← única carpeta expuesta al browser
│   └── img/              ← imágenes del sitio
└── .env                  ← variables de entorno (BD, URL, etc.) — NO se sube a git
```

---

## Qué es Breeze y qué generó

**Laravel Breeze** es un starter kit oficial de autenticación. Con un solo comando
(`php artisan breeze:install`) generó automáticamente:

| Qué generó | Dónde vive |
|---|---|
| Controladores de auth | `app/Http/Controllers/Auth/` |
| Vistas de login, registro, email, etc. | `resources/views/auth/` |
| Ruta group de auth | `routes/auth.php` |
| Layout para invitados | `resources/views/layouts/guest.blade.php` |
| Layout para usuarios | `resources/views/layouts/app.blade.php` |
| Componentes Blade reutilizables | `resources/views/components/` |
| Config de Tailwind + Vite | `tailwind.config.js`, `vite.config.js` |

> Nosotros **no tocamos** nada de lo que generó Breeze. Creamos nuestro propio
> layout `layouts/petfy.blade.php` para el sitio público, y dejamos el de Breeze
> para el dashboard y el perfil.

---

## Cómo funciona el ciclo Request → Response

```
Browser  →  routes/web.php  →  Controller  →  Model  →  BD
                                    ↓
                              view('home', $datos)
                                    ↓
                          resources/views/home.blade.php
                                    ↓
                               HTML al browser
```

1. El browser hace GET `/`
2. Laravel busca en `routes/web.php` y encuentra `HomeController@index`
3. El controlador consulta `Product::paginate(6)`
4. El modelo habla con MySQL y devuelve una colección
5. El controlador llama `view('home', compact('productos'))`
6. Blade mezcla la vista con los datos y devuelve HTML

---

## Blade — sistema de plantillas

Blade es el motor de vistas de Laravel. Permite usar PHP dentro del HTML con
sintaxis limpia.

```blade
{{-- Herencia de layout --}}
@extends('layouts.petfy')
@section('content')
    ...
@endsection

{{-- Incluir un partial --}}
@include('partials.nav')

{{-- Variables --}}
{{ $producto->name }}

{{-- Condicionales por autenticación --}}
@guest ... @endguest
@auth  ... @endauth

{{-- Bucles --}}
@foreach ($productos as $producto) ... @endforeach

{{-- Directiva Vite (inyecta CSS y JS compilados) --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

## Modelos y relaciones actuales

```
User ──────────┬── hasMany ──▶ Order
               ├── hasMany ──▶ Address
               ├── hasMany ──▶ Review
               └── hasMany ──▶ Wishlist

Product ───────┬── belongsToMany ──▶ Category   (tabla pivot: category_product)
               ├── hasMany ──────▶ OrderItem
               ├── hasMany ──────▶ Review
               └── hasMany ──────▶ Wishlist

Order ──────────── hasMany ──▶ OrderItem
```

Cada modelo en `app/Models/` tiene:
- `$fillable` — campos que se pueden asignar masivamente
- `$casts` — convierte tipos automáticamente (ej: `price` → decimal, `role` → Enum)
- métodos de relación (`hasMany`, `belongsToMany`, etc.)

---

## Enums

Los Enums (`app/Enums/`) son tipos PHP con valores fijos. Evitan "magic strings".

```php
// En vez de comparar $user->role === 'admin'  (frágil)
// usamos:
$user->role === Role::Admin   // tipado, seguro

// OrderStatus define los estados posibles de un pedido:
// Pendiente → Procesando → Enviado → Entregado → Cancelado
```

---

## Migraciones

Cada archivo en `database/migrations/` es una versión de la BD.
Se corren con `php artisan migrate`. Para reiniciar todo:

```bash
php artisan migrate:fresh --seed
# migrate:fresh  → borra todas las tablas y las recrea
# --seed         → corre los seeders después
```

Las nuestras (numeradas `2025_01_01_...`) agregan todo lo del ecommerce
encima de las tablas base que Laravel crea por defecto.

---

## Seeders

Los seeders cargan datos de prueba. Están en `database/seeders/`.

| Seeder | Qué carga |
|---|---|
| `DatabaseSeeder` | Llama a todos los demás. Crea 2 usuarios (admin + cliente) |
| `CategorySeeder` | 5 categorías (Alimentos Perros, Gatos, Accesorios, Juguetes, Higiene) |
| `ProductSeeder` | 13 productos con imágenes reales y categorías asignadas |

**Usuarios de prueba** (password: `password`):
- `admin@petfy.com` — rol Admin
- `cliente@petfy.com` — rol Cliente

---

## Vite + Tailwind

**Vite** es el bundler que compila y empaqueta el CSS y JS.

```bash
npm run dev    # modo desarrollo: hot reload, NO genera archivos en public/build/
npm run build  # modo producción: genera public/build/manifest.json + assets
```

**Tailwind** se configura en `tailwind.config.js`. Nosotros agregamos la paleta
propia del proyecto:

```js
colors: {
    petfy: {
        light:   '#6dd5ed',  // celeste claro (gradiente navbar)
        DEFAULT: '#2193b0',  // turquesa principal
        dark:    '#176b87',  // hover y footer
        accent:  '#ffe082',  // amarillo para CTA y links
    }
}
```

Esto permite usar clases como `bg-petfy`, `text-petfy-dark`, `bg-petfy-accent`.

> **Regla con ngrok:** siempre `npm run build` antes de compartir.
> El archivo `public/hot` indica a `@vite` que use el dev server —
> si queda ese archivo con el dev server muerto, no cargan los estilos.

---

## Lo que está hecho ✅

| Área | Estado |
|---|---|
| Instalación Laravel 11 + Breeze | ✅ |
| Autenticación completa (login, registro, recuperar password, verificar email) | ✅ |
| Migraciones de todas las tablas | ✅ |
| Modelos con relaciones y casts | ✅ |
| Enums (Role, OrderStatus) | ✅ |
| Seeders (categorías + 13 productos reales) | ✅ |
| Layout público `layouts/petfy.blade.php` | ✅ |
| Navbar con roles (guest / cliente / admin) | ✅ |
| Footer | ✅ |
| Vista Home (banner + beneficios + grid paginado) | ✅ |
| Paleta de colores Tailwind personalizada | ✅ |
| Form Requests (validaciones) | ✅ (estructura creada) |

---

## Lo que falta ❌

### Vistas públicas
| Vista | Ruta | Descripción |
|---|---|---|
| Listado de productos | `/productos` | Grid con filtro por categoría y búsqueda |
| Detalle de producto | `/productos/{id}` | Imagen grande, precio, stock, botón agregar al carrito, reseñas |
| Categoría | `/categorias/{slug}` | Productos filtrados por categoría |
| Nosotros | `/nosotros` | Página estática |
| Contacto | `/contacto` | Formulario con validación |

### Funcionalidades de cliente (requieren login)
| Feature | Controlador | Descripción |
|---|---|---|
| Carrito de compras | (pendiente) | Agregar/quitar productos, ver total |
| Checkout | `OrderController` | Formulario de envío + confirmación |
| Mis pedidos | `OrderController` | Historial con estados |
| Wishlist | `WishlistController` | Guardar productos favoritos |
| Reseñas | `ReviewController` | Calificar productos comprados |
| Perfil | `ProfileController` | ✅ Ya generado por Breeze |
| Direcciones | `AddressController` | CRUD de domicilios de envío |

### Panel de administración (`/admin`)
| Feature | Controlador | Descripción |
|---|---|---|
| Dashboard admin | `Admin/DashboardController` | Métricas (ventas, pedidos, usuarios) |
| CRUD Productos | `Admin/ProductController` | Crear/editar/eliminar productos con imagen |
| CRUD Categorías | `Admin/CategoryController` | Gestión de categorías |
| Gestión de pedidos | `Admin/OrderController` | Ver y cambiar estado de pedidos |
| Gestión de usuarios | `Admin/UserController` | Ver usuarios, cambiar rol |

### Middleware y seguridad
- Middleware `IsAdmin` para proteger `/admin/*`
- Middleware de verificación de email ya está (Breeze lo incluye)
- Validación de stock al hacer checkout

### Otros
- Paginación con estilos Tailwind (actualmente usa los estilos default de Breeze)
- Mensajes flash de éxito/error (`session('success')`)
- Imágenes con `Storage::disk('public')` en vez de `public/img/` directo
- Tests unitarios y de feature para los flujos críticos

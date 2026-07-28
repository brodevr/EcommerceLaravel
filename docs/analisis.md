# Relevamiento de Requisitos — PetFy Pet Shop

## 3.1 Actores del sistema

| Actor | Descripción |
|-------|-------------|
| **Visitante** | Usuario no autenticado. Puede navegar el catálogo de productos y ver información pública del sitio. |
| **Cliente** | Usuario autenticado con rol `cliente`. Puede realizar pedidos, gestionar su wishlist, dejar reseñas y administrar sus direcciones de envío. |
| **Administrador** | Usuario autenticado con rol `admin`. Tiene acceso completo al panel de administración: gestiona productos, categorías, pedidos y usuarios. |

---

## 3.2 Requisitos funcionales (RF)

| ID | Requisito | Actor |
|----|-----------|-------|
| RF01 | El sistema debe permitir a un visitante registrarse con nombre, email y contraseña. | Visitante |
| RF02 | El sistema debe permitir a un usuario autenticado iniciar y cerrar sesión. | Cliente / Administrador |
| RF03 | El sistema debe permitir a cualquier usuario navegar el catálogo de productos y filtrar por categoría. | Visitante / Cliente |
| RF04 | El sistema debe permitir a un cliente agregar y quitar productos de su lista de deseos (wishlist). | Cliente |
| RF05 | El sistema debe permitir agregar, actualizar y eliminar productos del carrito de compras (funciona sin login). | Visitante / Cliente |
| RF06 | El sistema debe permitir a un cliente confirmar un pedido seleccionando una dirección de envío. | Cliente |
| RF07 | El sistema debe calcular automáticamente el total del pedido en base a la cantidad y precio de cada ítem. | Sistema |
| RF08 | El sistema debe permitir a un cliente consultar el historial de sus pedidos y el detalle de cada uno. | Cliente |
| RF09 | El sistema debe permitir a un cliente dejar una reseña (rating 1–5 y comentario) sobre un producto que haya comprado. | Cliente |
| RF10 | El sistema debe permitir a un cliente gestionar sus direcciones de envío (crear, editar, eliminar, marcar como predeterminada). | Cliente |
| RF11 | El sistema debe permitir a un administrador crear, editar y eliminar productos del catálogo. | Administrador |
| RF12 | El sistema debe permitir a un administrador crear, editar y eliminar categorías. | Administrador |
| RF13 | El sistema debe permitir a un administrador ver todos los pedidos y actualizar su estado, respetando las transiciones válidas. | Administrador |
| RF14 | El sistema debe permitir a un administrador ver y editar los datos de los usuarios registrados. | Administrador |
| RF15 | El sistema debe exponer los endpoints `GET /api/products`, `GET /api/products/{id}` y `GET /api/orders` como API REST devolviendo JSON. | Sistema |

---

## 3.3 Requisitos no funcionales (RNF)

| ID | Requisito |
|----|-----------|
| RNF01 | **Rendimiento:** el tiempo de respuesta de cualquier página debe ser menor a 2 segundos en condiciones normales de uso local. |
| RNF02 | **Usabilidad responsive:** el catálogo y el carrito deben ser completamente usables en dispositivos móviles (viewport desde 375 px). Implementado con Tailwind CSS y clases responsive. |
| RNF03 | **Manejo uniforme de errores:** todos los formularios deben mostrar mensajes de error claros y asociados al campo correspondiente. Los errores de negocio (ej. transición de estado inválida) deben retornar mensajes descriptivos al usuario. |
| RNF04 | **Documentación:** el repositorio debe incluir un `README.md` con instrucciones de instalación, credenciales de prueba, diagrama E-R y lista de rutas; y un documento de análisis en `docs/analisis.md`. |
| RNF05 | **Seguridad:** las contraseñas se almacenan hasheadas con bcrypt. Todas las rutas de modificación están protegidas con autenticación de sesión y tokens CSRF. Las transiciones de estado de pedidos se validan en la capa de modelo (no solo en la vista). |
| RNF06 | **Separación de roles:** el panel de administración debe ser inaccesible para usuarios con rol `cliente`; las secciones de cliente (wishlist, pedidos, direcciones) deben estar ocultas para administradores. |
| RNF07 | **Mantenibilidad:** el código sigue el patrón MVC de Laravel: controllers delgados, lógica de validación en Form Requests, relaciones declaradas en modelos Eloquent, vistas en Blade con layouts reutilizables. |

---

## 3.4 Casos de uso principales

```
┌─────────────────────────────────────────────────────────────────┐
│                        SISTEMA PetFy                             │
│                                                                  │
│  VISITANTE                                                        │
│  ──────────── ──► CU01: Registrar cuenta                         │
│             └──► CU02: Navegar catálogo / filtrar por categoría  │
│                                                                  │
│  CLIENTE                                                          │
│  ──────────── ──► CU03: Agregar al carrito y realizar pedido     │
│             ├──► CU04: Gestionar wishlist                        │
│             ├──► CU05: Dejar reseña de producto comprado         │
│             ├──► CU06: Administrar direcciones de envío          │
│             └──► CU07: Consultar historial de pedidos            │
│                                                                  │
│  ADMINISTRADOR                                                    │
│  ──────────── ──► CU08: Gestionar catálogo (CRUD productos)      │
│             ├──► CU09: Gestionar categorías (CRUD)               │
│             ├──► CU10: Ver y actualizar estado de pedidos        │
│             └──► CU11: Gestionar usuarios                        │
│                                                                  │
│  SISTEMA / API                                                    │
│  ──────────── ──► CU12: Consultar productos vía API REST         │
│             └──► CU13: Consultar pedidos propios vía API REST    │
└─────────────────────────────────────────────────────────────────┘
```

### Detalle de casos de uso principales

| ID | Caso de uso | Actor | Descripción breve |
|----|-------------|-------|-------------------|
| CU01 | Registrar cuenta | Visitante | El visitante completa el formulario de registro y se crea un usuario con rol `cliente`. |
| CU03 | Realizar pedido | Cliente | El cliente agrega productos al carrito, va al checkout, selecciona dirección y confirma. El sistema crea el pedido con estado `pendiente` y calcula el total. |
| CU05 | Dejar reseña | Cliente | El cliente ingresa al detalle de un producto que compró y envía una reseña con rating y comentario. |
| CU10 | Actualizar estado de pedido | Administrador | El administrador selecciona un nuevo estado. El sistema valida la transición (pendiente → procesando → enviado → entregado / cancelado) y rechaza las inválidas. |
| CU12 | Consultar API REST | Sistema / Postman | Un cliente externo hace GET /api/products para obtener el catálogo en JSON, o GET /api/orders (autenticado) para ver sus pedidos. |

---

## 3.5 Alcance y supuestos

### Fuera del alcance
- No se implementa pasarela de pago real (el checkout simula la confirmación del pedido directamente).
- No se envían emails reales (se usa el driver `log`; la configuración MAIL_* está en `.env`).
- No se implementa sistema de notificaciones en tiempo real (WebSockets / broadcasting).
- No se implementa autenticación stateless con tokens (Sanctum / Passport) — la API reutiliza la sesión web.
- No se implementa recuperación de contraseña por email funcional en entorno local.
- No se gestiona la devolución o cancelación de pedidos desde el lado del cliente.

### Supuestos tomados
- Un producto puede pertenecer a múltiples categorías (relación N:M).
- El stock se muestra pero **no se descuenta automáticamente** al confirmar un pedido (queda fuera del alcance para mantener la simplicidad).
- El carrito persiste en sesión y funciona sin autenticación; al hacer checkout se requiere login.
- Las reseñas no tienen validación de "solo si compró el producto" a nivel de base de datos; se confía en la lógica de la vista y del controller.
- El rol `admin` se asigna directamente en la base de datos mediante seeders; no existe un flujo de auto-promoción.
- Las transiciones de estado de pedidos siguen el flujo: `pendiente → procesando → enviado → entregado`, con posibilidad de `cancelado` desde `pendiente` o `procesando`. El estado "procesando" equivale funcionalmente a "pagado" en el dominio del negocio (se adoptó "procesando" para reflejar mejor el flujo sin pasarela de pago real).

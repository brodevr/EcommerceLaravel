# Diagrama Entidad-Relación — PetFy Pet Shop

## Diagrama (Mermaid ERD)

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email
        string password
        string role
        string profile_photo
        timestamp email_verified_at
        timestamps created_at
    }
    categories {
        bigint id PK
        string name
        string slug
        text description
        timestamps created_at
    }
    products {
        bigint id PK
        string name
        text description
        decimal price
        string image
        int stock
        boolean is_active
        timestamps created_at
    }
    category_product {
        bigint category_id FK
        bigint product_id FK
    }
    addresses {
        bigint id PK
        bigint user_id FK
        string label
        string recipient
        string street
        string city
        string state
        string postal_code
        string phone
        boolean is_default
        timestamps created_at
    }
    orders {
        bigint id PK
        bigint user_id FK
        bigint shipping_address_id FK
        string status
        decimal total
        timestamps created_at
    }
    order_items {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        int quantity
        decimal unit_price
        timestamps created_at
    }
    reviews {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        int rating
        text comment
        timestamps created_at
    }
    wishlists {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        timestamps created_at
    }

    users ||--o{ orders        : "realiza"
    users ||--o{ reviews       : "escribe"
    users ||--o{ wishlists     : "agrega"
    users ||--o{ addresses     : "tiene"
    orders ||--o{ order_items  : "contiene"
    orders }o--o| addresses    : "se envía a"
    products ||--o{ order_items : "incluido en"
    products ||--o{ reviews    : "recibe"
    products ||--o{ wishlists  : "guardado en"
    products }o--o{ categories : "pertenece a (N:M)"
    category_product }o--|| categories : ""
    category_product }o--|| products   : ""
```

## Descripción de relaciones

| Relación | Tipo | Descripción |
|----------|------|-------------|
| `users` → `orders` | 1:N | Un usuario puede tener muchos pedidos. |
| `users` → `addresses` | 1:N | Un usuario puede tener múltiples direcciones de envío. |
| `users` → `reviews` | 1:N | Un usuario puede escribir reseñas de varios productos. |
| `users` → `wishlists` | 1:N | Un usuario puede tener muchos productos en su wishlist. |
| `orders` → `order_items` | 1:N | Un pedido contiene uno o más ítems. |
| `orders` → `addresses` | N:1 | Cada pedido referencia la dirección de envío al momento del pedido (nullable). |
| `products` → `order_items` | 1:N | Un producto puede estar en muchos ítems de pedidos. |
| `products` → `reviews` | 1:N | Un producto puede tener muchas reseñas. |
| `products` → `wishlists` | 1:N | Un producto puede estar en las wishlists de muchos usuarios. |
| `products` ↔ `categories` | N:M | Un producto puede pertenecer a varias categorías; una categoría agrupa varios productos. Tabla pivote: `category_product`. |

## Estados del pedido

```
pendiente ──► procesando ──► enviado ──► entregado
    │               │
    └───────────────┴──► cancelado
```

- Las transiciones se validan en `App\Enums\OrderStatus` — las inválidas lanzan `DomainException`.
- "procesando" equivale funcionalmente a "pagado" (adoptado porque no hay pasarela de pago real).

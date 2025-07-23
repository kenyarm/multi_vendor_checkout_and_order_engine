# Multi Vendor Checkout and Order Engine

A modular Laravel application for building a multi-vendor e-commerce platform with robust checkout and order management.

---

## Features

- User authentication (register, login, logout)
- Shopping cart management (add, remove, clear)
- Multi-vendor checkout process
- Order management for users and admins
- Admin dashboard for order oversight
- Role-based access control
- Modular code structure (Services, Events, Controllers, etc.)

---

## Main Routes

Defined in `routes/web.php`:

- `/` — Home page
- `/login` — Login form
- `/register` — Registration form
- `/cart` — View cart
- `/cart/add/{productId}` — Add product to cart
- `/cart/remove/{cartItem}` — Remove item from cart
- `/cart/clear` — Clear cart
- `/checkout` — Checkout (POST)
- `/orders` — User orders
- `/orders/{order}` — Order details
- `/admin` — Admin dashboard (admin only)
- `/admin/orders` — Admin order list (admin only)
- `/admin/orders/{order}` — Admin order details (admin only)

---

## Demo Credentials

You can use the following demo credentials to log in as an admin or a regular user (if seeded):

**Admin**
- Email: `admin1@yopmail.com`
- Password: `password`

**Customer**
- Email: `customer1@yopmail.com`
- Password: `password`

> _If these users do not exist, you can register a new account or seed your database accordingly._

---

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or compatible database

---

## Installation

1. **Clone the repository**
   ```sh
   git clone https://github.com/yourusername/multi_vendor_checkout_and_order_engine.git
   cd multi_vendor_checkout_and_order_engine
   ```

2. **Install PHP dependencies**
   ```sh
   composer install
   ```

3. **Install JavaScript dependencies**
   ```sh
   npm install
   ```

4. **Copy and configure environment**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
   Edit `.env` for your database and mail settings.

5. **Run migrations**
   ```sh
   php artisan migrate
   ```

6. **(Optional) Seed demo users**
   ```sh
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```sh
   npm run build
   ```

8. **Start the development server**
   ```sh
   php artisan serve
   ```

Visit [http://localhost:8000](http://localhost:8000) to view the app.

---

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

---

## License

[MIT](LICENSE)

---

*Built with ❤️ by Barathan Selvan*
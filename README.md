# Multi-Tenant Multi-Database Stock Management System

Welcome to the **Multi-Tenant Multi-Database Stock Management System**! This Laravel-based application is a comprehensive stock management solution designed with multi-tenancy architecture. This system is ideal for managing sales, inventory, expenses, payments, and much more, all within a tenant-isolated environment.

![image alt](https://github.com/raj5852/mypos/blob/main/pos-image.png?raw=true)


## Features

### Core Functionalities

- **Sale Management**: Manage sales transactions efficiently.
- **Stock Management**: Keep track of your inventory with real-time updates.
- **Expenses Management**: Record and monitor expenses across different categories.
- **Payments Management**: Handle incoming and outgoing payments seamlessly.
- **DUE Management**: Manage outstanding payments and due amounts with ease.

### Reports and Ledgers

- **Customer Report**: View detailed reports of customer activities and transactions.
- **Purchase Report**: Analyze purchase data for better decision-making.
- **Customer Ledger**: Maintain a clear record of customer accounts.
- **Supplier Ledger**: Track supplier transactions and balances.

### Administrative Controls

- **User Management**: Add, update, and manage users in the system.
- **Role and Permission**: Assign roles and set permissions for enhanced security.
- **Software Setting**: Customize the system settings as per your business needs.
- **Dynamic Unit Management**: Add and manage units dynamically for stock items.
- **Bank Accounts Management**: Manage and reconcile bank accounts within the system.
- **Damage Management**: Record and handle stock damages effectively.

## Technology Stack

- **Framework**: Laravel
- **Multi-Tenancy Package**: [Tenancy for Laravel](https://tenancyforlaravel.com/)
- **Database**: MySQL (multi-database architecture)
- **Frontend**: Blade templates
- **Backend**: PHP with Laravel

## Installation

Follow the steps below to set up the project on your local environment.

### Prerequisites

- PHP 8.0+
- Composer
- MySQL
- Node.js (for compiling assets)

### Steps

1. Clone the repository:
   ```bash
   git clone git@github.com:raj5852/mypos.git
   cd mypos
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. Set up the `.env` file:
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
     ```bash
   php artisan key:generate
   ```
5. Create a symlink to the storage:
    ```bash
    php artisan storage:link    
    ```

   Configure your database and other environment variables in the `.env` file.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:

   - If you are using Laravel Herd for your development server:
     ```
     http://mypos.test
     ```

## Usage

- Access the application via `http://mypos.test`.
- Use the admin panel to configure tenants and manage the stock management system.


---

**Author**: [Raj](https://github.com/raj5852)

For any inquiries, please contact [raj.web58@gmail.com](mailto:raj.web58@gmail.com).

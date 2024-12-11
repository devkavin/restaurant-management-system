
# **Restaurant Management System**

This application is a simple restaurant management system for kitchen staff to view and manage orders. It includes functionality for order queuing, status updates, and concession tracking.

---

## **Setup Instructions**

### 1. **Fork and Clone the Repository**
Click the Fork button to create your own copy of the project. Clone your forked repository:
```bash
git clone <your-forked-repository-url>
cd <repository-directory>
```

### 2. **Install Dependencies**
```bash
composer install
npm install
```

### 3. **Set Up Environment Variables**
Copy the `.env.example` file to `.env` and update the database and application configurations:
```bash
cp .env.example .env
```
(e.g. APP_NAME, APP_URL, DB_CONNECTION (mysql), DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.)

### 4. **Generate Application Key**
```bash
php artisan key:generate
```

### 5. **Run Database Migrations**
Ensure your database is set up and configured in `.env`. Then run:
```bash
php artisan migrate
```

### 6. **Seed the Database**
I've added factories and seeders for the application. You can seed the database with dummy data using:
```bash
php artisan db:seed
```

### 7. **Build Frontend Assets**
Compile the frontend assets using:
```bash
npm run dev
```

For production, use:
```bash
npm run build
```

### 8. **Start the Application**
Start the development server:
```bash
php artisan serve
```

Open your browser and visit [http://localhost:8000](http://localhost:8000).

---

## **Features**
- View and manage orders with detailed information.
- Assign orders to the kitchen queue.
- Track order statuses (Pending, In-Progress, Completed).
- Calculate total cost of orders based on concessions.

# **Completed Tasks**
### **Concession Management Operations**
- Add, Edit, Delete, View Concessions. :white_check_mark:

### **Order Management Operations**
- Create, View, and Delete Orders. :white_check_mark:
- Automate sending orders to the kitchen. :white_check_mark:
- Provide a button to manually send the orders to the kitchen. :white_check_mark:

### **Kitchen Management Operations**
- Display orders received. :white_check_mark:
- Update order status. :white_check_mark:

---

For further assistance, feel free to reach out! 😊

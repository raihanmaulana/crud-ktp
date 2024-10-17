
# Laravel 11 API KTP Project

This project implements a KTP management system using **Laravel 11**. The system includes CRUD operations and supports data import from CSV as well as data export to CSV and PDF.

---

## 1. Clone the Repository

Clone the project from the GitHub repository:

```bash
git clone https://github.com/username/repo-ktp.git
cd repo-ktp
```

---

## 2. Install Dependencies

Install the PHP dependencies with Composer:

```bash
composer install
```

If you use frontend tools, install the necessary packages using npm:

```bash
npm install
npm run dev
```

---

## 3. Configure the Environment

### 3.1. Create the `.env` File

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

### 3.2. Configure the Database

Open the `.env` file and update the following fields with your database configuration:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ktp_db
DB_USERNAME=root
DB_PASSWORD=
```

Create a new MySQL database:

```sql
CREATE DATABASE ktp_db;
```

---

## 4. Run Migrations

Run the following command to set up the database tables:

```bash
php artisan migrate
```

---

## 5. Generate 10,000 Dummy Data Records

Generate 10,000 KTP data records using the factory and seeder:

```bash
php artisan db:seed --class=KtpSeeder
```

---

## 6. Run the Laravel Server

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at:

```
http://127.0.0.1:8000
```

---

## 7. API Endpoints

Below are the available API endpoints:

- **Get all KTPs:**  
  `GET /api/ktps`

- **Get a specific KTP by ID:**  
  `GET /api/ktps/{id}`

- **Create a new KTP:**  
  `POST /api/ktps`  
  **Request Body (JSON):**
  ```json
  {
    "nama": "Raihan Maulana",
    "nik": "0386456849517521",
    "alamat": "Jalan Mawar No. 10",
    "tempat_lahir": "Surakarta",
    "tanggal_lahir": "2002-10-06"
  }
  ```

- **Update a KTP by ID:**  
  `PUT /api/ktps/{id}`

- **Delete a KTP by ID:**  
  `DELETE /api/ktps/{id}`

- **Import data from CSV:**  
  `POST /api/ktps/import`  
  **Form Data:**  
  - `file`: Upload a CSV file containing KTP data.

- **Export data to CSV:**  
  `GET /api/ktps/export/csv`

- **Export data to PDF:**  
  `GET /api/ktps/export/pdf`

---

## 8. Testing the API

Use tools like **Postman** or **Insomnia** to test the API endpoints.

---

## 9. Troubleshooting

If you encounter issues with caching, run the following commands:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
composer dump-autoload
```

---

## 10. License

This project is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).

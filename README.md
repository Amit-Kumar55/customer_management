# Laravel Customer Management API

This project is a **Customer Database Management Portal** built with Laravel. It includes a **REST API** with **OAuth2 authentication**, CRUD operations, a UI built with **Blade templates**, **automated API documentation**, and **unit testing with PHPUnit**.

---

## 📌 Setup & Installation

### 1️⃣ Clone the Repository

```sh
git clone -b master https://github.com/Amit-Kumar55/customer_management.git
cd laravel-customer-api

2️⃣ Install Dependencies
composer install

3️⃣ Configure Environment
Copy .env.example to .env:
cp .env.example .env

Update database details in .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=your_password

4️⃣ Generate App Key
php artisan key:generate

5️⃣ Migrate Database
php artisan migrate

6️⃣ Install Passport for Authentication
php artisan passport:install

Copy Personal Access Client ID & Secret from the output and update .env:
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=your_id
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=your_secret

7️⃣ Seed Database (Optional)
php artisan db:seed

8️⃣ Start Laravel Server
php artisan serve

Your API will now be available at:
http://127.0.0.1:8000

 Testing API in Postman
1️⃣ Login API (POST /api/login)
Open Postman.

Select POST request.

Enter URL:
http://127.0.0.1:8000/api/login

Go to the Headers section and add:
Accept: application/json
Content-Type: application/json

Go to Body > raw, select JSON, and enter:
{
  "email": "shiva@example.com",
  "password": "password"
}

Click Send.

If successful, you should get:

{
  "token": "your_generated_access_token"
}

Copy this token for authentication in other API requests.

2️⃣ Get All Customers (GET /api/customers)
Select GET request.

Enter URL:
http://127.0.0.1:8000/api/customers
In Headers, add:
Accept: application/json
Authorization: Bearer your_generated_access_token

Click Send.

Response example:

[
  {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "email": "johndoe@example.com"
  }
]

3️⃣ Create Customer (POST /api/customers)
Select POST request.

Enter URL:
http://127.0.0.1:8000/api/customers

In Headers, add:
Accept: application/json
Authorization: Bearer your_generated_access_token
Content-Type: application/json

In Body > raw, enter:
{
  "first_name": "Alice",
  "last_name": "Smith",
  "email": "alice@example.com",
  "age": 30,
  "dob": "1994-05-10"
}

Click Send.

You should receive:
{
  "message": "Customer created successfully",
  "customer": {
    "id": 2,
    "first_name": "Alice",
    "last_name": "Smith",
    "email": "alice@example.com"
  }
}

1️⃣ Run PHPUnit Tests
php artisan test

2️⃣ Example Customer API Test
Create a test file:
php artisan make:test CustomerApiTest --unit

Modify tests/Feature/CustomerApiTest.php:

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_creation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'age' => 30,
            'dob' => '1994-05-10'
        ]);

        $response->assertStatus(201)->assertJson([
            'message' => 'Customer created successfully',
            'customer' => ['first_name' => 'John']
        ]);

        $this->assertDatabaseHas('customers', [
            'first_name' => 'John',
            'email' => 'johndoe@example.com'
        ]);
    }
}

php artisan test --filter CustomerApiTest

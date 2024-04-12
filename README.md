### COP System Backend Documentation

Welcome to the documentation for the COP System Backend. This README.md file provides comprehensive insights into the implementation details, including the integration of the ORM, database migrations, and PHPUnit tests. The backend is developed using Laravel, a PHP framework known for its simplicity and expressive syntax.

---

### ORM Implementation

**Installation:**

Eloquent, Laravel's ORM, comes pre-installed with Laravel, making it readily available upon installation of the framework. No additional installation steps are required to use Eloquent in the project.

**Models:**

Eloquent models were extensively utilized in COP System Backend to represent database tables. These models serve as the bridge between the application and the database, encapsulating database logic and providing an expressive and fluent interface for querying the database.

For example, models such as User, Department, Equipment, and Personnel were created to correspond to their respective database tables.

**Relationships:**

Eloquent simplifies defining relationships between models, allowing for easy navigation and retrieval of related data. Relationships such as one-to-many, many-to-many, and polymorphic relationships were defined between models as per the application's requirements.

For instance, a one-to-many relationship might be defined between the Department model and the Personnel model, indicating that a department can have multiple personnel members.

**CRUD Operations:**

Eloquent provides a convenient and expressive syntax for performing Create, Read, Update, and Delete (CRUD) operations on database records. This includes methods such as ``create()``, ``update()``, ``delete()``, and ``find()`` among others.

---

### Database Migrations

**Implementation:**

Database migrations are implemented using Laravel's migration system, allowing for seamless management of changes to the database schema over time.

**Creating Migration Files:**

Migration files are created using Laravel's Artisan command-line interface ``php artisan make:migration``. Each migration file encapsulates a set of changes to the database schema, making it easy to track and apply modifications.


# Example: Creating a migration file
``php artisan make:migration create_roles_table``

Defining Schema Changes:

Within each migration file, schema changes are defined using Laravel's Schema Builder. This allows developers to expressively define the structure of the database tables, including columns, indexes, and constraints.

# Example: Defining schema changes in a migration file

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->text('role_title')->nullable();
            $table->text('role_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

# Executing Migrations:

Once migration files are created, they can be executed using the migrate command provided by Artisan. This applies all pending migrations to the database, ensuring that the schema remains synchronized with the application's codebase.

**Applying migrations**
``php artisan migrate``

**Rolling Back Migrations:**
``php artisan migrate:rollback``

In cases where it's necessary to revert schema changes, Laravel provides the migrate:rollback command. This allows developers to undo the last batch of migrations, effectively rolling back the database schema to its previous state.

---

### PHPUnit Tests

PHPUnit tests are essential for validating the functionality of controllers and ensuring the correctness of the COP System Backend. These tests automate the process of verifying that individual units of code perform as expected, helping detect and prevent bugs, regressions, and unexpected behavior.

**Testing with PHPUnit**
PHPUnit tests play a crucial role in ensuring the robustness and reliability of software applications. These tests automate the process of verifying that individual units of code perform as expected. By simulating different scenarios and inputs, PHPUnit tests help detect and prevent bugs, regressions, and unexpected behavior in the codebase.

**Purpose of PHPUnit Tests**
- Ensure Correctness: PHPUnit tests verify that each component of the COP System Backend behaves correctly according to its specifications. This includes validating input validation, data manipulation, and response generation in controllers.

- Catch Bugs Early: By running PHPUnit tests regularly, developers can catch bugs and regressions early in the development process. This proactive approach minimizes the likelihood of critical issues reaching production environments.

- Facilitate Refactoring: When refactoring or modifying code, PHPUnit tests act as a safety net, ensuring that existing functionality remains intact. Developers can refactor code with confidence, knowing that PHPUnit tests will catch any unintended side effects.

- Documentation: PHPUnit tests serve as executable documentation, providing insights into how various components of the COP System Backend are expected to behave. New developers can refer to these tests to understand the intended functionality of controllers and other modules.


# Example PHPUnit Test

Let's take a look at an example PHPUnit test for the EquipmentsController:

class EquipmentsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $app = require __DIR__.'/../../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->controller = $app->make(EquipmentsController::class);
    }
    public function testAddEquipment()
    {
        $token =  env('token');

        $request = new Request([
            'name' => 'Test Equipment',
            'quantity' => 5,
            'description' => 'Test description',
            'location_id' =>"1"
        ]);

        $request->headers->set('Authorization', 'Bearer ' . $token);

        $response = $this->controller->addEquipment($request);
        $this->assertEquals(200, $response->getStatusCode());


        $request = new Request([
            // Missing 'name' field
            'quantity' => 5,
            'description' => 'Test description',
            'location_id' =>"1"
        ]);

        $response = $this->controller->addEquipment($request);

        $this->assertEquals(422, $response->getStatusCode());

    }
}

This PHPUnit test validates the addEquipment method of the EquipmentsController. It sets up the test environment, creates mock requests, and asserts the expected behavior of the controller method.

**PHPUnit Test Examples:**

- [EquipmentsControllerTest.php](cop-sys-backend/cop-sys-backend/tests/Http/Controllers/API/V1/EquipmentsControllerTest.php)
- [DepartmentsControllerTest.php](cop-sys-backend/cop-sys-backend/tests/Http/Controllers/API/V1/DepartmentsControllerTest.php)
- [PersonnelControllerTest.php](cop-sys-backend/cop-sys-backend/tests/Http/Controllers/API/V1/PersonnelControllerTest.php)

---

### Usage

**Setup**

Clone the repository from GitHub.
Install Composer dependencies using ``composer install``.
Configure the database connection in the .env file.
Run database migrations with ``php artisan migrate``.
Serve the application with ``php artisan serve``.

**Running Tests**

Ensure PHPUnit is installed.
Run tests using ``phpunit``.

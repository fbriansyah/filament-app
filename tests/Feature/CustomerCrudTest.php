<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Filament\Resources\Customers\CustomerResource;
use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role
        $this->adminRole = Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        // Create user with admin role
        $this->user = User::factory()->create([
            'status' => Status::Active->value,
        ]);
        $this->user->roles()->attach($this->adminRole);
    }

    /**
     * Test that customer list page can be rendered.
     */
    public function test_customer_list_page_can_be_rendered(): void
    {
        $this->actingAs($this->user)
            ->get(CustomerResource::getUrl('index'))
            ->assertSuccessful();
    }

    /**
     * Test that customer list page shows customers.
     */
    public function test_customer_list_page_shows_customers(): void
    {
        $customers = Customer::factory()->count(3)->create();

        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->assertCanSeeTableRecords($customers);
    }

    /**
     * Test that customer list page can search by name.
     */
    public function test_customer_list_can_search_by_name(): void
    {
        $customer = Customer::factory()->create(['name' => 'John Doe']);
        $otherCustomer = Customer::factory()->create(['name' => 'Jane Smith']);

        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->searchTable('John Doe')
            ->assertCanSeeTableRecords([$customer])
            ->assertCanNotSeeTableRecords([$otherCustomer]);
    }

    /**
     * Test that customer list page can search by email.
     */
    public function test_customer_list_can_search_by_email(): void
    {
        $customer = Customer::factory()->create(['email' => 'johndoe@example.com']);
        $otherCustomer = Customer::factory()->create(['email' => 'janesmith@example.com']);

        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->searchTable('johndoe@example.com')
            ->assertCanSeeTableRecords([$customer])
            ->assertCanNotSeeTableRecords([$otherCustomer]);
    }

    /**
     * Test that customer create page can be rendered.
     */
    public function test_customer_create_page_can_be_rendered(): void
    {
        $this->actingAs($this->user)
            ->get(CustomerResource::getUrl('create'))
            ->assertSuccessful();
    }

    /**
     * Test that a customer can be created using the wizard.
     */
    public function test_customer_can_be_created_with_wizard(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
            ])
            ->goToNextWizardStep()
            ->fillForm([
                'phone' => '+628123456789',
                'address' => '123 Main Street',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+628123456789',
            'address' => '123 Main Street',
        ]);
    }

    /**
     * Test that a customer can be created without optional fields.
     */
    public function test_customer_can_be_created_without_optional_fields(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
            ])
            ->goToNextWizardStep()
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
        ]);
    }

    /**
     * Test that name is required when creating a customer.
     */
    public function test_name_is_required_when_creating_customer(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => '',
                'email' => 'johndoe@example.com',
            ])
            ->goToNextWizardStep()
            ->assertHasFormErrors(['name' => 'required']);
    }

    /**
     * Test that email is required when creating a customer.
     */
    public function test_email_is_required_when_creating_customer(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'John Doe',
                'email' => '',
            ])
            ->goToNextWizardStep()
            ->assertHasFormErrors(['email' => 'required']);
    }

    /**
     * Test that email must be valid email format.
     */
    public function test_email_must_be_valid_format(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'John Doe',
                'email' => 'invalid-email',
            ])
            ->goToNextWizardStep()
            ->assertHasFormErrors(['email' => 'email']);
    }

    /**
     * Test that email unique constraint is enforced at database level during creation.
     */
    public function test_email_must_be_unique_when_creating(): void
    {
        Customer::factory()->create(['email' => 'existing@example.com']);

        // The form doesn't have unique validation, so we test that the database
        // constraint enforces uniqueness by catching the exception
        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'John Doe',
                'email' => 'existing@example.com',
            ])
            ->goToNextWizardStep()
            ->call('create');
    }

    /**
     * Test that name cannot exceed max length.
     */
    public function test_name_cannot_exceed_max_length(): void
    {
        Livewire::actingAs($this->user)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => str_repeat('a', 101),
                'email' => 'johndoe@example.com',
            ])
            ->goToNextWizardStep()
            ->assertHasFormErrors(['name' => 'max']);
    }

    /**
     * Test that customer view page can be rendered.
     */
    public function test_customer_view_page_can_be_rendered(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->user)
            ->get(CustomerResource::getUrl('view', ['record' => $customer]))
            ->assertSuccessful();
    }

    /**
     * Test that customer view page shows customer data.
     */
    public function test_customer_view_page_shows_customer_data(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+628123456789',
            'address' => '123 Main Street',
        ]);

        $this->actingAs($this->user)
            ->get(CustomerResource::getUrl('view', ['record' => $customer]))
            ->assertSuccessful()
            ->assertSee('John Doe')
            ->assertSee('johndoe@example.com')
            ->assertSee('+628123456789')
            ->assertSee('123 Main Street');
    }

    /**
     * Test that customer edit page can be rendered.
     */
    public function test_customer_edit_page_can_be_rendered(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->user)
            ->get(CustomerResource::getUrl('edit', ['record' => $customer]))
            ->assertSuccessful();
    }

    /**
     * Test that customer edit page shows existing data in form.
     */
    public function test_customer_edit_page_shows_existing_data(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+628123456789',
            'address' => '123 Main Street',
        ]);

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->assertFormSet([
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone' => '+628123456789',
                'address' => '123 Main Street',
            ]);
    }

    /**
     * Test that a customer can be updated with valid data.
     */
    public function test_customer_can_be_updated_with_valid_data(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->fillForm([
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'phone' => '+628987654321',
                'address' => 'Updated Address',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+628987654321',
            'address' => 'Updated Address',
        ]);
    }

    /**
     * Test that name is required when updating a customer.
     */
    public function test_name_is_required_when_updating_customer(): void
    {
        $customer = Customer::factory()->create();

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->fillForm([
                'name' => '',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required']);
    }

    /**
     * Test that email is required when updating a customer.
     */
    public function test_email_is_required_when_updating_customer(): void
    {
        $customer = Customer::factory()->create();

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->fillForm([
                'email' => '',
            ])
            ->call('save')
            ->assertHasFormErrors(['email' => 'required']);
    }

    /**
     * Test that customer can keep same email when updating.
     */
    public function test_customer_can_keep_same_email_when_updating(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->fillForm([
                'name' => 'Updated John Doe',
                'email' => 'johndoe@example.com',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /**
     * Test that a customer can be soft deleted.
     */
    public function test_customer_can_be_deleted(): void
    {
        $customer = Customer::factory()->create();

        Livewire::actingAs($this->user)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->callAction(DeleteAction::class);

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }

    /**
     * Test that unauthenticated user cannot access customer list.
     */
    public function test_unauthenticated_user_cannot_access_customer_list(): void
    {
        $this->get(CustomerResource::getUrl('index'))
            ->assertRedirect('/admin/login');
    }

    /**
     * Test that unauthenticated user cannot access create page.
     */
    public function test_unauthenticated_user_cannot_access_create_page(): void
    {
        $this->get(CustomerResource::getUrl('create'))
            ->assertRedirect('/admin/login');
    }

    /**
     * Test that unauthenticated user cannot access edit page.
     */
    public function test_unauthenticated_user_cannot_access_edit_page(): void
    {
        $customer = Customer::factory()->create();

        $this->get(CustomerResource::getUrl('edit', ['record' => $customer]))
            ->assertRedirect('/admin/login');
    }

    /**
     * Test that unauthenticated user cannot access view page.
     */
    public function test_unauthenticated_user_cannot_access_view_page(): void
    {
        $customer = Customer::factory()->create();

        $this->get(CustomerResource::getUrl('view', ['record' => $customer]))
            ->assertRedirect('/admin/login');
    }

    /**
     * Test that user without proper role cannot view customers.
     */
    public function test_user_without_role_cannot_view_customers(): void
    {
        $userWithoutRole = User::factory()->create([
            'status' => Status::Active->value,
        ]);

        $this->actingAs($userWithoutRole)
            ->get(CustomerResource::getUrl('index'))
            ->assertForbidden();
    }

    /**
     * Test that user with staff role can view customers.
     */
    public function test_user_with_staff_role_can_view_customers(): void
    {
        $staffRole = Role::factory()->create([
            'name' => 'Staff',
            'slug' => 'staff',
        ]);

        $staffUser = User::factory()->create([
            'status' => Status::Active->value,
        ]);
        $staffUser->roles()->attach($staffRole);

        $this->actingAs($staffUser)
            ->get(CustomerResource::getUrl('index'))
            ->assertSuccessful();
    }

    /**
     * Test that non-admin user cannot delete customers.
     */
    public function test_non_admin_user_cannot_delete_customers(): void
    {
        $staffRole = Role::factory()->create([
            'name' => 'Staff',
            'slug' => 'staff',
        ]);

        $staffUser = User::factory()->create([
            'status' => Status::Active->value,
        ]);
        $staffUser->roles()->attach($staffRole);

        $customer = Customer::factory()->create();

        Livewire::actingAs($staffUser)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->assertActionHidden(DeleteAction::class);
    }
}

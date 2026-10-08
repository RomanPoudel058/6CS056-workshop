<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentMvcTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_create_and_list_work_via_resource_routes(): void
    {
        $response = $this->post('/students', [
            'name' => 'Hari Sharma',
            'email' => 'hari@example.com',
            'phone' => '9876543210',
            'address' => 'Kathmandu',
            'date_of_birth' => '2005-02-15',
        ]);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success', 'Student Hari Sharma created successfully!');
        $this->assertDatabaseHas('students', [
            'email' => 'hari@example.com',
            'phone' => '9876543210',
        ]);

        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('Hari Sharma')
            ->assertSee(route('students.show', Student::first()));
    }

    public function test_student_detail_and_update_use_route_model_binding(): void
    {
        $student = Student::create([
            'name' => 'Sita Rai',
            'email' => 'sita@example.com',
            'phone' => '9800000000',
            'address' => 'Pokhara',
            'date_of_birth' => '2004-05-10',
        ]);

        $this->get(route('students.show', $student))
            ->assertOk()
            ->assertSee('Sita Rai')
            ->assertSee('Pokhara');

        $this->put(route('students.update', $student), [
            'name' => 'Sita Gurung',
            'email' => 'sita.updated@example.com',
            'phone' => '9800000001',
            'address' => 'Lalitpur',
            'date_of_birth' => '2004-05-10',
        ])
            ->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Sita Gurung',
            'email' => 'sita.updated@example.com',
        ]);
    }

    public function test_student_validation_errors_are_displayed(): void
    {
        $response = $this->from(route('students.create'))
            ->post(route('students.store'), []);

        $response
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['name', 'email', 'phone']);
    }

    public function test_student_can_be_deleted(): void
    {
        $student = Student::create([
            'name' => 'Ram Thapa',
            'email' => 'ram@example.com',
            'phone' => '9811111111',
        ]);

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'))
            ->assertSessionHas('success', 'Student deleted successfully!');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}

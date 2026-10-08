<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseMvcTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_crud_uses_resource_routes_and_validation(): void
    {
        $this->post('/courses', [
            'name' => 'Laravel Fundamentals',
            'description' => 'Learn the Laravel framework.',
            'duration' => 6,
            'fee' => 150.00,
            'difficulty' => 'Easy',
            'is_active' => true,
        ])
            ->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Course Laravel Fundamentals created successfully!');

        $course = Course::firstOrFail();

        $this->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('Laravel Fundamentals');

        $this->put(route('courses.update', $course), [
            'name' => 'Laravel Fundamentals Advanced',
            'description' => 'Deepen Laravel knowledge.',
            'duration' => 8,
            'fee' => 180.00,
            'difficulty' => 'Medium',
            'is_active' => true,
        ])
            ->assertRedirect(route('courses.show', $course));

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Course deleted successfully!');

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_validation_errors_are_displayed(): void
    {
        $this->from(route('courses.create'))
            ->post(route('courses.store'), [])
            ->assertRedirect(route('courses.create'))
            ->assertSessionHasErrors(['name', 'duration', 'fee', 'difficulty']);
    }
}

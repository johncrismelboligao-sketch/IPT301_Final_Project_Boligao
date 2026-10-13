<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('School Attendance Management System')
            ->assertSee('John Crismel Boligao');

        $this->assertDatabaseCount('students', 4);
        $this->assertDatabaseCount('attendance_records', 56);
        $this->assertDatabaseHas('students', [
            'first_name' => 'John Crismel',
            'last_name' => 'Boligao',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'MAtt',
            'last_name' => 'Omus',
        ]);

        $this->seed(\Database\Seeders\StudentSeeder::class);
        $this->assertDatabaseCount('students', 4);
        $this->assertDatabaseCount('classes', 6);
        $this->assertDatabaseCount('teachers', 8);

        $this->seed(\Database\Seeders\AttendanceRecordSeeder::class);
        $this->assertDatabaseCount('attendance_records', 56);

        $this->get('/students')
            ->assertOk()
            ->assertSee('John Crismel Boligao')
            ->assertSee('Axl Montuya')
            ->assertSee('Klint Taylaran')
            ->assertSee('MAtt Omus');
    }
}

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
            ->assertSee('Jasmin Omus');

        $this->assertDatabaseCount('students', 8);
        $this->assertDatabaseCount('attendance_records', 112);
        $this->assertDatabaseHas('students', [
            'first_name' => 'John Crismel',
            'last_name' => 'Boligao',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'Matt',
            'last_name' => 'Omus',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'Jasmin',
            'last_name' => 'Omus',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'John Sarge',
            'last_name' => 'Andamon',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'Paya',
            'last_name' => 'Corsiga',
        ]);
        $this->assertDatabaseHas('students', [
            'first_name' => 'Jhon Mark',
            'last_name' => 'Orongan',
        ]);

        $this->seed(\Database\Seeders\StudentSeeder::class);
        $this->assertDatabaseCount('students', 8);
        $this->assertDatabaseCount('classes', 8);
        $this->assertDatabaseCount('teachers', 8);

        $this->seed(\Database\Seeders\AttendanceRecordSeeder::class);
        $this->assertDatabaseCount('attendance_records', 112);

        $this->get('/students')
            ->assertOk()
            ->assertSee('John Crismel Boligao')
            ->assertSee('Axl Montuya')
            ->assertSee('Klint Taylaran')
            ->assertSee('Matt Omus')
            ->assertSee('Jasmin Omus')
            ->assertSee('John Sarge Andamon')
            ->assertSee('Paya Corsiga')
            ->assertSee('Jhon Mark Orongan');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Admission;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_and_application_form_are_available(): void
    {
        $this->get('/')->assertOk()->assertSee('Amiru International School');
        $this->get('/admissions/apply')->assertOk()->assertSee('ONLINE APPLICATION');
        $this->get('/login')->assertOk()->assertSee('Sign in to Amiru');
    }

    public function test_a_prospective_family_can_submit_an_admission_application(): void
    {
        $response = $this->post('/admissions/apply', [
            'first_name' => 'Amina',
            'last_name' => 'Example',
            'date_of_birth' => '2018-05-10',
            'gender' => 'female',
            'applying_for' => 'Year 2',
            'guardian_name' => 'Parent Example',
            'guardian_email' => 'parent@example.test',
            'guardian_phone' => '+255 700 000 000',
            'previous_school' => 'Example Primary',
        ]);

        $response->assertRedirect('/admissions/apply');
        $this->assertDatabaseHas('admissions', [
            'first_name' => 'Amina',
            'last_name' => 'Example',
            'guardian_email' => 'parent@example.test',
            'status' => 'submitted',
        ]);
        $this->assertMatchesRegularExpression(
            '/^AMI-'.now()->format('Ymd').'-[A-Z0-9]{6}$/',
            session('application_number')
        );
    }

    public function test_admissions_staff_can_review_but_students_cannot_access_applications(): void
    {
        $admissionsStaff = User::create([
            'name' => 'Admissions Officer',
            'email' => 'admissions@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'admissions_officer',
        ]);
        $student = User::create([
            'name' => 'Student Example',
            'email' => 'student@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'student',
        ]);
        $application = Admission::create([
            'application_number' => 'AMI-20261110-ABC123',
            'first_name' => 'Learner',
            'last_name' => 'Example',
            'date_of_birth' => '2018-05-10',
            'gender' => 'female',
            'applying_for' => 'Year 2',
            'guardian_name' => 'Parent Example',
            'guardian_email' => 'parent@example.test',
            'guardian_phone' => '+255 700 000 000',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $this->actingAs($student)->get('/portal/admissions')->assertForbidden();

        $this->actingAs($admissionsStaff)
            ->get('/portal/admissions')
            ->assertOk()
            ->assertSee($application->application_number);

        $this->actingAs($admissionsStaff)
            ->patch("/portal/admissions/{$application->id}", [
                'status' => 'under_review',
                'review_notes' => 'Documents received.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('admissions', [
            'id' => $application->id,
            'status' => 'under_review',
            'review_notes' => 'Documents received.',
        ]);
    }

    public function test_users_can_sign_in_and_sign_out(): void
    {
        User::create([
            'name' => 'Teacher Example',
            'email' => 'teacher@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'teacher',
        ]);

        $this->post('/login', [
            'email' => 'teacher@example.test',
            'password' => 'ExamplePassword123!',
        ])->assertRedirect('/portal');

        $this->get('/portal')->assertOk()->assertSee('Teacher Example');

        $this->post('/logout')->assertRedirect('/');
        $this->get('/portal')->assertRedirect('/login');
    }

    public function test_administrator_dashboard_reflects_sql_records(): void
    {
        $administrator = User::create([
            'name' => 'School Administrator',
            'email' => 'admin@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'administrator',
        ]);
        SchoolClass::create([
            'name' => 'Year 4',
            'grade_level' => '4',
        ]);
        Student::create([
            'admission_number' => 'AMI-2026-0001',
            'first_name' => 'Amina',
            'last_name' => 'Example',
            'gender' => 'female',
            'date_of_birth' => '2016-05-10',
            'guardian_name' => 'Parent Example',
            'guardian_phone' => '+255 700 000 000',
            'status' => 'active',
        ]);
        Admission::create([
            'application_number' => 'AMI-20261110-ABC123',
            'first_name' => 'Learner',
            'last_name' => 'Example',
            'date_of_birth' => '2018-05-10',
            'gender' => 'female',
            'applying_for' => 'Year 2',
            'guardian_name' => 'Parent Example',
            'guardian_email' => 'parent@example.test',
            'guardian_phone' => '+255 700 000 000',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $this->actingAs($administrator)
            ->get('/portal')
            ->assertOk()
            ->assertSee('Amiru student records')
            ->assertSee('Submitted or under review')
            ->assertSee('Classes in the school database')
            ->assertSee('<strong>1</strong>', false)
            ->assertSee('AMI-20261110-ABC123')
            ->assertSee('Learner Example')
            ->assertSee('Year 2');
    }

    public function test_staff_can_view_timetable_attendance_and_report_cards(): void
    {
        $teacher = User::create([
            'name' => 'Teacher Example',
            'email' => 'teacher-portal@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'teacher',
        ]);

        $this->actingAs($teacher)
            ->get('/portal/timetable')
            ->assertOk()
            ->assertSee('Academic');

        $this->actingAs($teacher)
            ->get('/portal/attendance')
            ->assertOk()
            ->assertSee('Record attendance');

        $this->actingAs($teacher)
            ->get('/portal/report-cards')
            ->assertOk()
            ->assertSee('Report');
    }

    public function test_attendance_recording_writes_to_the_database(): void
    {
        $teacher = User::create([
            'name' => 'Teacher Example',
            'email' => 'teacher-attendance@example.test',
            'password' => 'ExamplePassword123!',
            'role' => 'teacher',
        ]);
        $class = SchoolClass::create([
            'name' => 'Grade 7A',
            'grade_level' => '7',
        ]);
        $student = Student::create([
            'school_class_id' => $class->id,
            'admission_number' => 'AMI-2026-0002',
            'first_name' => 'Leah',
            'last_name' => 'Example',
            'gender' => 'female',
            'date_of_birth' => '2016-05-10',
            'guardian_name' => 'Parent Example',
            'guardian_phone' => '+255 700 000 001',
            'status' => 'active',
        ]);

        $this->actingAs($teacher)
            ->post('/portal/attendance', [
                'class_id' => $class->id,
                'date' => '2026-03-10',
                'attendance' => [[
                    'student_id' => $student->id,
                    'status' => 'present',
                    'notes' => 'Checked in on time.',
                ]],
            ])
            ->assertRedirect('/portal/attendance');

        $this->assertDatabaseHas('attendance_records', [
            'student_id' => $student->id,
            'status' => 'present',
            'school_class_id' => $class->id,
        ]);
    }
}

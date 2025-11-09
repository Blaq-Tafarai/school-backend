<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Classroom;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming a classroom exists; if not, create one or use existing
        $classroom = Classroom::first();
        if (!$classroom) {
            $classroom = Classroom::create([
                'name' => 'Class A',
                'floor' => '1st Floor',
            ]);
        }

        $scheduleData = [
            ['period' => '1', 'time' => '8:00 - 8:55', 'course' => 'Advanced English', 'room' => '204', 'teacher' => 'Ms. Miller', 'day' => 'Monday'],
            ['period' => '2', 'time' => '9:00 - 9:55', 'course' => 'AP Biology', 'room' => 'Lab 3', 'teacher' => 'Dr. Thompson', 'day' => 'Monday'],
            ['period' => '3', 'time' => '10:00 - 10:55', 'course' => 'Spanish III', 'room' => '109', 'teacher' => 'Sr. Garcia', 'day' => 'Monday'],
            ['period' => '4', 'time' => '11:00 - 11:55', 'course' => 'Lunch', 'room' => 'Cafeteria', 'teacher' => '-', 'day' => 'Monday'],
            ['period' => '5', 'time' => '12:00 - 12:55', 'course' => 'Pre-Calculus', 'room' => '318', 'teacher' => 'Mr. Parker', 'day' => 'Monday'],
            ['period' => '6', 'time' => '1:00 - 1:55', 'course' => 'U.S. History', 'room' => '226', 'teacher' => 'Dr. Wilson', 'day' => 'Monday'],
            ['period' => '7', 'time' => '2:00 - 2:55', 'course' => 'Physical Education', 'room' => 'Gym', 'teacher' => 'Coach Davis', 'day' => 'Monday'],
            ['period' => '1', 'time' => '8:00 - 8:55', 'course' => 'Advanced English', 'room' => '204', 'teacher' => 'Ms. Miller', 'day' => 'Tuesday'],
            ['period' => '2', 'time' => '9:00 - 9:55', 'course' => 'AP Biology', 'room' => 'Lab 3', 'teacher' => 'Dr. Thompson', 'day' => 'Tuesday'],
            ['period' => '3', 'time' => '10:00 - 10:55', 'course' => 'Spanish III', 'room' => '109', 'teacher' => 'Sr. Garcia', 'day' => 'Tuesday'],
            ['period' => '4', 'time' => '11:00 - 11:55', 'course' => 'Lunch', 'room' => 'Cafeteria', 'teacher' => '-', 'day' => 'Tuesday'],
            ['period' => '5', 'time' => '12:00 - 12:55', 'course' => 'Pre-Calculus', 'room' => '318', 'teacher' => 'Mr. Parker', 'day' => 'Tuesday'],
            ['period' => '6', 'time' => '1:00 - 1:55', 'course' => 'U.S. History', 'room' => '226', 'teacher' => 'Dr. Wilson', 'day' => 'Tuesday'],
            ['period' => '7', 'time' => '2:00 - 2:55', 'course' => 'Physical Education', 'room' => 'Gym', 'teacher' => 'Coach Davis', 'day' => 'Tuesday'],
            ['period' => '1', 'time' => '8:00 - 8:55', 'course' => 'Advanced English', 'room' => '204', 'teacher' => 'Ms. Miller', 'day' => 'Wednesday'],
            ['period' => '2', 'time' => '9:00 - 9:55', 'course' => 'AP Biology', 'room' => 'Lab 3', 'teacher' => 'Dr. Thompson', 'day' => 'Wednesday'],
            ['period' => '3', 'time' => '10:00 - 10:55', 'course' => 'Spanish III', 'room' => '109', 'teacher' => 'Sr. Garcia', 'day' => 'Wednesday'],
            ['period' => '4', 'time' => '11:00 - 11:55', 'course' => 'Lunch', 'room' => 'Cafeteria', 'teacher' => '-', 'day' => 'Wednesday'],
            ['period' => '5', 'time' => '12:00 - 12:55', 'course' => 'Pre-Calculus', 'room' => '318', 'teacher' => 'Mr. Parker', 'day' => 'Wednesday'],
            ['period' => '6', 'time' => '1:00 - 1:55', 'course' => 'U.S. History', 'room' => '226', 'teacher' => 'Dr. Wilson', 'day' => 'Wednesday'],
            ['period' => '7', 'time' => '2:00 - 2:55', 'course' => 'Physical Education', 'room' => 'Gym', 'teacher' => 'Coach Davis', 'day' => 'Wednesday'],
            ['period' => '1', 'time' => '8:00 - 8:55', 'course' => 'Advanced English', 'room' => '204', 'teacher' => 'Ms. Miller', 'day' => 'Thursday'],
            ['period' => '2', 'time' => '9:00 - 9:55', 'course' => 'AP Biology', 'room' => 'Lab 3', 'teacher' => 'Dr. Thompson', 'day' => 'Thursday'],
            ['period' => '3', 'time' => '10:00 - 10:55', 'course' => 'Spanish III', 'room' => '109', 'teacher' => 'Sr. Garcia', 'day' => 'Thursday'],
            ['period' => '4', 'time' => '11:00 - 11:55', 'course' => 'Lunch', 'room' => 'Cafeteria', 'teacher' => '-', 'day' => 'Thursday'],
            ['period' => '5', 'time' => '12:00 - 12:55', 'course' => 'Pre-Calculus', 'room' => '318', 'teacher' => 'Mr. Parker', 'day' => 'Thursday'],
            ['period' => '6', 'time' => '1:00 - 1:55', 'course' => 'U.S. History', 'room' => '226', 'teacher' => 'Dr. Wilson', 'day' => 'Thursday'],
            ['period' => '7', 'time' => '2:00 - 2:55', 'course' => 'Physical Education', 'room' => 'Gym', 'teacher' => 'Coach Davis', 'day' => 'Thursday'],
            ['period' => '1', 'time' => '8:00 - 8:55', 'course' => 'Advanced English', 'room' => '204', 'teacher' => 'Ms. Miller', 'day' => 'Friday'],
            ['period' => '2', 'time' => '9:00 - 9:55', 'course' => 'AP Biology', 'room' => 'Lab 3', 'teacher' => 'Dr. Thompson', 'day' => 'Friday'],
            ['period' => '3', 'time' => '10:00 - 10:55', 'course' => 'Spanish III', 'room' => '109', 'teacher' => 'Sr. Garcia', 'day' => 'Friday'],
            ['period' => '4', 'time' => '11:00 - 11:55', 'course' => 'Lunch', 'room' => 'Cafeteria', 'teacher' => '-', 'day' => 'Friday'],
            ['period' => '5', 'time' => '12:00 - 12:55', 'course' => 'Pre-Calculus', 'room' => '318', 'teacher' => 'Mr. Parker', 'day' => 'Friday'],
            ['period' => '6', 'time' => '1:00 - 1:55', 'course' => 'U.S. History', 'room' => '226', 'teacher' => 'Dr. Wilson', 'day' => 'Friday'],
            ['period' => '7', 'time' => '2:00 - 2:55', 'course' => 'Physical Education', 'room' => 'Gym', 'teacher' => 'Coach Davis', 'day' => 'Friday'],
        ];

        foreach ($scheduleData as $data) {
            Schedule::create(array_merge($data, ['classroom_id' => $classroom->id]));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $latestDate = AttendanceRecord::max('date');
        $latestDate = $latestDate ? Carbon::parse($latestDate) : null;

        $stats = $latestDate
            ? AttendanceRecord::whereDate('date', $latestDate->toDateString())
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
            : collect();

        return view('dashboard', [
            'counts' => [
                'students' => Student::count(),
                'classes' => SchoolClass::count(),
                'subjects' => Subject::count(),
                'teachers' => Teacher::count(),
                'records' => AttendanceRecord::count(),
            ],
            'latestDate' => $latestDate,
            'stats' => $stats,
            'recent' => AttendanceRecord::with(['student', 'subject', 'teacher'])
                ->latest('date')
                ->latest('id')
                ->take(8)
                ->get(),
        ]);
    }
}

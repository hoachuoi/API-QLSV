<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Rfc4122\Validator;

class attendaceController extends Controller
{
    //
    public function getClassAttendance($courseId)
    {

        $students = Attendance::where('course_id', $courseId)
            ->with('student','course')
            ->select(
                'student_id',
                'course_id',
                DB::raw('count(*) as total_classes'),
                DB::raw('sum(case when status = 0 then 1 else 0 end) as total_absent'),
                DB::raw('sum(case when status = 1 then 1 else 0 end) as total_present'),
                DB::raw('sum(case when status = 2 then 1 else 0 end) as total_permission')
            )
            ->groupBy('student_id','course_id')
            ->get();

        $response = $students->map(function ($student) {
            return [
                'student_id' => $student->student_id,
                'student_name' => $student->student?$student->student->fullName:"Không đọc được",
                'MSSV'=>$student->student?$student->student->studentID:"Không đọc được",
                'course_name' => $student->course ? $student->course->name : "Không đọc được",
                'courseID' => $student->course ? $student->course->IDcourse : "Không đọc được",
                'total_classes' => $student->total_classes,
                'total_absent' => $student->total_absent,
                'total_present' => $student->total_present,
                'total_permission' => $student->total_permission,
            ];
        });

        return response()->json($response);
    }

    // Phương thức để điểm danh sinh viên
    public function markAttendance(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'attendances' => 'required|array',
//            'attendances.*.course_id' => 'required|integer|exists:courses,id',
//            'attendances.*.student_id' => 'required|integer|exists:students,id',
//            'attendances.*.date' => 'required|date',
//            'attendances.*.status' => 'required|integer|in:0,1,2' // 0: vắng mặt, 1: có mặt, 2: xin phép nghỉ
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 400);
//        }
        $attendancesData = $request->attendances;

        foreach ($attendancesData as $attendanceData) {
            $date = $attendanceData['date'];
            $dayOfWeek = date('l', strtotime($date)); // Lấy ngày trong tuần từ ngày học

            Attendance::updateOrCreate(
                [
                    'course_id' => $attendanceData['course_id'],
                    'student_id' => $attendanceData['student_id'],
                    'date' => $date,
                ],
                [
                    'status' => $attendanceData['status'],
                    'day_of_week' => $dayOfWeek,
                ]
            );
        }

        return response()->json(['message' => 'Attendance marked successfully'], 200);
    }

}

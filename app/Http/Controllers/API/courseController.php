<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\classroom;
use App\Models\course;
use App\Models\course_student;
use App\Models\faculty;
use App\Models\semester;
use App\Models\student;
use App\Models\subject;
use App\Models\user1;
use Illuminate\Http\Request;

class courseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$course1 =course::query()->get();
        $courses = Course::with(['faculty', 'teacher', 'subject', 'semester', 'classroom'])->get();
        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'ML-HP' => $course->IDcourse,
                'week'=>$course->week,
                'start' => $course->start_time,
                'end' => $course->end_time,
                'date_of_week' => $course->day_of_week, // Đảm bảo bạn sử dụng đúng tên thuộc tính
                'faculty' => $course->faculty->name,
                'teacher' => $course->teacher->fullName,
                'numberOfCredits' => $course->subject->numberOfCredits,
                'semester' => $course->name,
                'classroom' => $course->classroom->name,
            ];
        });

        return response()->json($formattedCourses);
        //return response()->json($course1);
    }

    /**
     * Show the form for creating a new resource.
     */
//    public function create()
//    {
//        //
//
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $course = Course::create($data);

        // Trả về phản hồi JSON
        return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy dữ liệu khóa học với các quan hệ
        $course = Course::with(['faculty', 'teacher', 'subject', 'semester', 'classroom'])->find($id);

        // Kiểm tra nếu khóa học không tồn tại
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Định dạng dữ liệu của khóa học
        $formattedCourse = [
            'id' => $course->id,
            'name' => $course->name,
            'ML-HP' => $course->IDcourse,
            'week'=>$course->week,
            'start' => $course->start_time,
            'end' => $course->end_time,
            'date_of_week' => $course->date_of_week, // Đảm bảo bạn sử dụng đúng tên thuộc tính
            'faculty' => $course->faculty->name ?? null,
            'teacher' => $course->teacher->fullName ?? null,
            'numberOfCredits' => $course->subject->numberOfCredits ?? null,
            'semester' => $course->semester->name ?? null,
            'classroom' => $course->classroom->name ?? null,
        ];

        // Trả về JSON response
        return response()->json($formattedCourse);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Tìm bản ghi cần cập nhật
        $course = Course::find($id);

        // Kiểm tra sự tồn tại của bản ghi
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Lấy dữ liệu từ request và cập nhật thông tin khóa học
        $course->name = $request->input('name');
        $course->IDcourse = $request->input('IDcourse');
        $course->start_time = $request->input('start_time');
        $course->week= $request->input('week');
        $course->end_time = $request->input('end_time');
        $course->day_of_week = $request->input('day_of_week');
        $course->faculty_id = $request->input('faculty_id');
        $course->teacher_id = $request->input('teacher_id');
        $course->subject_id = $request->input('subject_id');
        $course->semester_id = $request->input('semester_id');
        $course->classroom_id = $request->input('classroom_id');
        // Lưu các thay đổi vào cơ sở dữ liệu
        $course->save();

        // Trả về phản hồi JSON
        return response()->json($course);
    }
    public function search(Request $request)
    {
        // Lấy thông tin tìm kiếm từ yêu cầu
        $keyword = $request->input('search');

        // Thực hiện tìm kiếm trong cơ sở dữ liệu
        $courses = Course::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('IDcourse', 'like', '%' . $keyword . '%')
            ->with(['faculty', 'teacher', 'subject', 'semester', 'classroom'])
            ->get();

        // Định dạng kết quả trả về

        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'ML-HP' => $course->IDcourse,
                'week'=>$course->week,
                'start' => $course->start_time,
                'end' => $course->end_time,
                'date_of_week' => $course->date_of_week, // Đảm bảo bạn sử dụng đúng tên thuộc tính
                'faculty' => $course->faculty->name ?? null,
                'teacher' => $course->teacher->fullName ?? null,
                'numberOfCredits' => $course->subject->numberOfCredits ?? null,
                'semester' => $course->semester->name ?? null,
                'classroom' => $course->classroom->name ?? null,
            ];
        });

        // Trả về phản hồi JSON
        return response()->json($formattedCourses);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm bản ghi cần xóa
        $course = Course::find($id);

        // Kiểm tra sự tồn tại của bản ghi
        if (!$course) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        // Xóa bản ghi
        $course->delete();

        // Trả về phản hồi JSON
        return response()->json(['message' => 'Resource deleted successfully']);
    }

// hiển thị các học sinh trong một lớp học
    public function studentofcourse(string $id)
    {
        // Tìm khóa học theo ID và nạp thông tin về sinh viên đã đăng ký
        $course = Course::with('students.user.role')->find($id);

        // Kiểm tra sự tồn tại của khóa học
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Lấy danh sách sinh viên trong khóa học
        //$students = $course->students
        if($course->students){
            $students = $course->students;
        } else{
            return response()->json(['message' => 'Course not found student'], 404);
        }

        // Định dạng thông tin về từng sinh viên
        $formattedStudents = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'userID' => $student->userID,
                'studentID' => $student->studentID,
                'fullName' => $student->fullName,
                'gender' => $student->gender,
                'dateOfBirth' => $student->dateOfBirth,
                'nickName' => $student->nickName,
                'avatar' => $student->avatar,
                'ethnicity' => $student->ethnicity,
                'religion' => $student->religion,
                'educationalLevel' => $student->educationalLevel,
                'DateOffAdmissionToDTNCS' => $student->DateOffAdmissionToDTNCS,
                'policyBeneficiary' => $student->policyBeneficiary,
                'contactAddress' => $student->contactAddress,
                'hometown' => $student->hometown,
                'email' => optional($student->user)->email,
                'phoneNumber' => optional($student->user)->phoneNumber,
                'roleID' => optional($student->user)->roleID,
                'created_at' => optional($student->user)->created_at,
                'updated_at' => optional($student->user)->updated_at,
                'roleName' => optional(optional($student->user)->role)->roleName,
            ];
        });

        // Trả về danh sách sinh viên trong khóa học với thông tin đã được định dạng
        return response()->json(['message' => 'OK', 'students' => $formattedStudents], 200);
    }
    //hiển thị tất cả lơp shọc của sinh viên
    public function courseofstudent(string $id)
    {
        // Tìm sinh viên theo ID và nạp thông tin về các khóa học đã đăng ký
        $student = Student::with('courses')->find($id);

        // Kiểm tra sự tồn tại của sinh viên
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Lấy danh sách các khóa học của sinh viên
        $courses = $student->courses;

        // Kiểm tra xem sinh viên có khóa học nào không
        if ($courses->isEmpty()) {
            return response()->json(['message' => 'Student has no courses'], 404);
        }

        // Định dạng thông tin về từng khóa học của sinh viên
        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'ML-HP' => $course->IDcourse,
                'week'=>$course->week,
                'start' => $course->start_time,
                'end' => $course->end_time,
                'date_of_week' => $course->date_of_week, // Đảm bảo bạn sử dụng đúng tên thuộc tính
                'faculty' => $course->faculty->name ?? null,
                'teacher' => $course->teacher->fullName ?? null,
                'numberOfCredits' => $course->subject->numberOfCredits ?? null,
                'semester' => $course->semester->name ?? null,
                'classroom' => $course->classroom->name ?? null,
            ];
        });

        // Trả về thông tin về các khóa học của sinh viên
        return response()->json(['message' => 'OK', 'courses' => $formattedCourses], 200);
    }
    public function courseofteacher(Request $request)
    {
        // Lấy thông tin tìm kiếm từ yêu cầu
        $keyword = $request->input('idTeacher');

        // Thực hiện tìm kiếm trong cơ sở dữ liệu
        $courses = Course::where('teacher_id', 'like', '%' . $keyword . '%')
            ->with(['faculty', 'teacher', 'subject', 'semester', 'classroom'])
            ->get();

        // Định dạng kết quả trả về
        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'ML-HP' => $course->IDcourse,
                'week'=>$course->week,
                'start' => $course->start_time,
                'end' => $course->end_time,
                'date_of_week' => $course->date_of_week, // Đảm bảo bạn sử dụng đúng tên thuộc tính
                'faculty' => $course->faculty->name ?? null,
                'teacher' => $course->teacher->fullName ?? null,
                'numberOfCredits' => $course->subject->numberOfCredits ?? null,
                'semester' => $course->semester->name ?? null,
                'classroom' => $course->classroom->name ?? null,
            ];
        });
        return response()->json($formattedCourses,201);
    }
    public function addStudentsToCourse($course_id, Request $request): \Illuminate\Http\JsonResponse
    {
        $student_ids = $request->input('student_ids');

        $existingStudents = [];
        $newEntries = [];

        // Attach each student to the course
        foreach ($student_ids as $student_id) {
            $existingEntry = course_student::where('course_id', $course_id)
                ->where('student_id', $student_id)
                ->first();

            if ($existingEntry) {
                $existingStudents[] = $student_id;
            } else {
                course_student::create([
                    'course_id' => $course_id,
                    'student_id' => $student_id,
                ]);
                $newEntries[] = $student_id;
            }
        }

        // Prepare response data
        $response = ['message' => 'Students processed successfully.'];
        if (!empty($existingStudents)) {
            $response['existing_students'] = $existingStudents;
        }
        if (!empty($newEntries)) {
            $response['new_entries'] = $newEntries;
        }

        return response()->json($response, 201);
    }

    //api laays thoong tin cac bang mac dinh
    public function listFaculty()
    {
        $faculty = faculty::query()->get();
        return response()->json($faculty,201);
    }
    public function listClassRoom()
    {
        $listClassRoom = classroom::query()->get();
        return response()->json($listClassRoom,201);
    }
    public function listSemester()
    {
        $listSemester = semester::query()->get();
        return response()->json($listSemester,201);
    }
    public function listSubject()
    {
        $listSubject = subject::query()->get();
        return response()->json($listSubject,201);
    }
}

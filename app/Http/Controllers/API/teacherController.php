<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\teacher;
use App\Models\user1;

class teacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $teachers = Teacher::with(['user','faculty'])->get();
    //$demo = teacher::all();

    $formattedteachers = $teachers->map(function ($teacher) {
        return [
            'id'=>$teacher->id,
            'userID' => $teacher->userID,
            'fullName' => $teacher->fullName,
            'teacherID'=>$teacher->teacherID,
            'facultyname'=>$teacher->faculty?$teacher->faculty->name:null,
            'hometown'=> $teacher->hometown,
            'dateOfBirth'=>$teacher->date_of_birth,
            'gender'=>$teacher->gender,
            'avatar' => $teacher->avatar,
            'nationality' =>$teacher->nationality,
            'educationalLevel' => $teacher->educationalLevel,
            'email' => $teacher->user ? $teacher->user->email : null,
            'phoneNumber' => $teacher->user ? $teacher->user->phoneNumber : null,
            'roleID' => $teacher->user ? $teacher->user->roleID : null,
            'created_at' => $teacher->user ? $teacher->user->created_at : null,
            'updated_at' => $teacher->user ? $teacher->user->updated_at : null,
            'roleName' => $teacher->user && $teacher->user->role ? $teacher->user->role->roleName : null,
        ];
    });
    return response()->json($formattedteachers);
}

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        // Lấy thông tin từ request
        $email = $request->input('email');
        $phoneNumber = $request->input('phoneNumber');
        // Gọi hàm store của userController để tạo mới một bản ghi user
        $userController = new UserController();
        $a = $userController->store(new Request([
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'roleID'=> '102',
            'password'=>'12345'
        ]));

        $data = $request->all();
        $data['userID'] = 2;


        $facultyname = $request->input('facultyname');
        switch ($facultyname) {
            case 'FAST':
                $data['faculty_id'] = 1;
                break;
            case 'CNTT':
                $data['faculty_id'] = 2;
                break;
            case 'Điện':
                $data['faculty_id'] = 3;
                break;
            case 'Điện tử viễn thông':
                $data['faculty_id'] = 4;
                break;
            case 'Hóa':
                $data['faculty_id'] = 5;
                break;
            case 'Xây dựng':
                $data['faculty_id'] = 6;
                break;
            case 'Cơ khí':
                $data['faculty_id']= 7;
                break;
            case 'Môi trường':
                $data['faculty_id'] = 8;
                break;
            default:
                $data['faculty_id']= null; // Hoặc giá trị mặc định nào đó
            break;
      }

        teacher::create($data);

        return response()->json(['message' => $data,"ok"],201);

        // Tiếp tục xử lý logic tạo mới bản ghi student ở đây
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $teacher = Teacher::with(['user','faculty'])->find($id);

    if (!$teacher) {
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    $formattedTeacher = [
        'userID' => $teacher->userID,
        'fullName' => $teacher->fullName,
        'teacherID'=>$teacher->teacherID,
        'faculty_id'=>$teacher->faculty_id,
        'facultyname'=>$teacher->faculty?$teacher->faculty->name:null,
        'hometown'=> $teacher->hometown,
        'dateOfBirth'=>$teacher->date_of_birth,
        'gender'=>$teacher->gender,
        'avatar' => $teacher->avatar,
        'educationalLevel' => $teacher->educationalLevel,
        'nationality' =>$teacher->nationality,
        'email' => $teacher->user ? $teacher->user->email : null,
        'phoneNumber' => $teacher->user ? $teacher->user->phoneNumber : null,
        'roleID' => $teacher->user ? $teacher->user->roleID : null,
        'created_at' => $teacher->user ? $teacher->user->created_at : null,
        'updated_at' => $teacher->user ? $teacher->user->updated_at : null,
        'roleName' => $teacher->user && $teacher->user->role ? $teacher->user->role->roleName : null,
    ];

    return response()->json($formattedTeacher);
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
    public function update(Request $request, string $id)
    {
        // Tìm giáo viên cần cập nhật
        $teacher = teacher::find($id);

        // Kiểm tra nếu không tìm thấy giáo viên
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        // Cập nhật thông tin giáo viên từ dữ liệu yêu cầu
        $teacher->fullName = $request->input('fullName');
        $teacher->teacherID = $request->input('teacherID');
        $teacher->hometown = $request->input('hometown');
        $teacher->date_of_birth = $request->input('dateOfBirth');
        $teacher->gender = $request->input('gender');
        $teacher->avatar = $request->input('avatar');
        $teacher->educationalLevel = $request->input('educationalLevel');
        $teacher->nationality = $request->input('nationality');

        // Cập nhật faculty_id dựa trên facultyname
        $facultyname = $request->input('facultyname');
        switch ($facultyname) {
            case 'FAST':
                $teacher->faculty_id = 1;
                break;
            case 'CNTT':
                $teacher->faculty_id = 2;
                break;
            case 'Điện':
                $teacher->faculty_id = 3;
                break;
            case 'Điện tử viễn thông':
                $teacher->faculty_id = 4;
                break;
            case 'Hóa':
                $teacher->faculty_id = 5;
                break;
            case 'Xây dựng':
                $teacher->faculty_id = 6;
                break;
            case 'Cơ khí':
                $teacher->faculty_id = 7;
                break;
            case 'Môi trường':
                $teacher->faculty_id = 8;
                break;
            default:
                $teacher->faculty_id = null; // Hoặc giá trị mặc định nào đó
        }

        // Cập nhật thông tin người dùng liên quan nếu có
        if ($teacher->user) {
            $newEmail = $request->input('email');

            // Kiểm tra xem email mới có trùng lặp không
            if ($teacher->user->email !== $newEmail) {
                $existingUser = user1::where('email', $newEmail)->first();
                if (!$existingUser) {
//                    return response()->json(['message' => 'Email already exists'], 409); // HTTP 409 Conflict
//                } else {
                    $teacher->user->email = $newEmail;
                }
            }

            $teacher->user->phoneNumber = $request->input('phoneNumber');
            // $teacher->user->roleID = $request->input('roleID');

            // Lưu thông tin người dùng liên quan
            $teacher->user->save();
        }

        // Lưu các thay đổi vào cơ sở dữ liệu
        $teacher->save();

        // Trả về thông tin giáo viên sau khi cập nhật
        return response()->json($teacher,201);
    }

    // cap nhat mat khau giang vien
    public function updatepass(Request $request, string $id)
    {
        // Tìm giáo viên cần cập nhật
        $teacher = teacher::find($id);

        // Kiểm tra nếu không tìm thấy giáo viên
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }
        $user = user1::find($teacher->userID);

        $oldPass = $request->input('oldPass');
        $newPass = $request->input('newPass');
        $confirm = $request->input('confirmNewPass');

        if($user->password == $oldPass)
        {
            if($confirm==$newPass) {
                $user->password = $newPass;
                $user->save();
            }else return response()->json(['mess'=>"New pass not same Confirm pass"], 404);
        } else return response()->json(['mess'=>"Old pass incorect"], 404);



        // Trả về thông tin giáo viên sau khi cập nhật
        return response()->json(['mess'=>'update sucsess',$user],201);
    }


    public function search(Request $request)
{
    // Lấy thông tin tìm kiếm từ yêu cầu
    $keyword = $request->input('search');

    // Thực hiện tìm kiếm trong cơ sở dữ liệu
    $teachers = Teacher::where('fullName', 'like', '%' . $keyword . '%')
                       ->orWhere('educationalLevel', 'like', '%' . $keyword . '%')
                       ->get();

    // Định dạng kết quả trả về
    $formattedTeachers = $teachers->map(function ($teacher) {
        return [
            'id' => $teacher->id,
            'fullName' => $teacher->fullName,
            'avatar' => $teacher->avatar,
            'educationalLevel' => $teacher->educationalLevel,
            'nationality' => $teacher->nationality,
        ];
    });

    // Trả về kết quả dưới dạng JSON
    return response()->json($formattedTeachers);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm giáo viên cần xóa
        $teacher = Teacher::find($id);

        // Kiểm tra xem giáo viên có tồn tại không
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        try {
            // Xóa giáo viên
            $teacher->delete();
            return response()->json(['message' => 'Teacher deleted successfully'],201);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json(['message' => 'Failed to delete teacher'], 500);
        }
    }
}

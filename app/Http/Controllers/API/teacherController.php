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
    $teachers = Teacher::with(['user'])->get();
    
    $formattedteachers = $teachers->map(function ($teacher) {
        return [
            'userID' => $teacher->userID,
            'fullName' => $teacher->fullName,
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
        // Lấy thông tin từ request
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
        $data['userID'] = $a->id;
        $data['roleID'] = '102';

        teacher::create($data);
       
        return response()->json(['message' => 'ok']);
                   
    

        // Tiếp tục xử lý logic tạo mới bản ghi student ở đây
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $teacher = Teacher::with(['user'])->find($id);

    if (!$teacher) {
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    $formattedTeacher = [
        'userID' => $teacher->userID,
        'fullName' => $teacher->fullName,
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
    $teacher = Teacher::find($id);

    // Kiểm tra nếu không tìm thấy giáo viên
    if (!$teacher) {
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    // Cập nhật thông tin giáo viên từ dữ liệu yêu cầu
    $teacher->fullName = $request->input('fullName');
    $teacher->avatar = $request->input('avatar');
    $teacher->educationalLevel = $request->input('educationalLevel');
    // Cập nhật ngày cập nhật
    $teacher->updated_at = now(); // Giả sử sử dụng thời điểm hiện tại

    // Lưu các thay đổi vào cơ sở dữ liệu
    $teacher->save();

    // Trả về thông tin giáo viên sau khi cập nhật
    return response()->json($teacher);
}

public function search(Request $request)
{
    // Lấy thông tin tìm kiếm từ yêu cầu
    $keyword = $request->input('search');

    // Thực hiện tìm kiếm trong cơ sở dữ liệu
    $teachers = Teacher::where('fullName', 'like', '%' . $keyword . '%')
                       ->orWhere('avatar', 'like', '%' . $keyword . '%')
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
        //
    }
}

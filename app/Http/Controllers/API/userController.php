<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user1;
class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $users = User1::with(['role', 'student','teacher','admin'])->get();
    //$user = User1::with(['role', 'student'])
    $formattedUsers = $users->map(function ($user) {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'studentName' => $user->student ? $user->student->fullName : null,
            'teacherName' => $user->teacher ? $user->teacher->fullName : null,
            'adminName' => $user->admin ? $user->admin->fullname : null,
            'phoneNumber' => $user->phoneNumber,
            'password' => $user->password,
            'roleID' => $user->roleID,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'roleName' => $user->role ? $user->role->rolename : null,
            'studentID'=> $user->student?$user->student->id:null
        ];
    });

    return response()->json($formattedUsers);
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
        //echo"post data";
        $data = $request->all();
        return user1::create($data);

    }


    /**
     * Display the specified resource.
     */
//     public function show(string $id)
// {
//     $user = User1::with('role')->find($id);

//     if (!$user) {
//         return response()->json(['message' => 'Resource not found'], 404);
//     }

//     return response()->json([
//         'id' => $user->id,
//         'username' => $user->username,
//         'email' => $user->email,
//         'phoneNumber' => $user->phoneNumber,
//         'password' => $user->password,
//         'roleID' => $user->roleID,
//         'fullName' => $user->student ? $user->student->fullName : null,
//         'created_at' => $user->created_at,
//         'updated_at' => $user->updated_at,
//         'roleName' => $user->role ? $user->role->roleName : null,
//     ]);
// }
public function show(string $id)
{
    $user = User1::with(['role', 'student','teacher','admin'])->find($id);

    if (!$user) {
        return response()->json(['message' => 'Resource not found'], 404);
    }

    return response()->json([
        'id' => $user->id,
        'username' => $user->username,
        'email' => $user->email,
        'phoneNumber' => $user->phoneNumber,
        'password' => $user->password,
        'roleID' => $user->roleID,
        'studentName' => $user->student ? $user->student->fullName : null,
        'teacherName' => $user->teacher ? $user->teacher->name : null,
        'adminName' => $user->admin ? $user->admin->fullname : null,
        'created_at' => $user->created_at,
        'updated_at' => $user->updated_at,
        'roleName' => $user->role ? $user->role->roleName : null,
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User1::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Lấy dữ liệu từ request và cập nhật thông tin người dùng
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phoneNumber = $request->input('phoneNumber');
        $user->password = $request->input('password');
        $user->roleID = $request->input('roleID');
        // Lưu các thay đổi vào cơ sở dữ liệu
        $user->save();

        return response()->json($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User1::find($id);
        // Check if the brand exists
        if (!$user) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        // Delete the brand
        $user->delete();
        return response()->json(['message' => 'Resource deleted successfully']);
    }

    public function search(Request $request)
    {
    // Lấy thông tin tìm kiếm từ yêu cầu
    $keyword = $request->input('search');
    //return response()->json($keyword);
    // Thực hiện tìm kiếm trong cơ sở dữ liệu
    $users = User1::where('id', 'like', '%' . $keyword.'%' )
                  ->orWhere('username', 'like', '%' . $keyword . '%')
                   ->orWhere('email', 'like', '%' . $keyword . '%')
                   ->orWhere('roleId', 'like' ,'%'. $keyword . '%')
                 ->with('role')
                 ->get();

    //Định dạng kết quả trả về
    $formattedUsers = $users->map(function ($user) {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'phoneNumber' => $user->phoneNumber,
            'password' => $user->password,
            'roleID' => $user->roleID,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'roleName' => $user->role ? $user->role->roleName : null,
            'studentName' => $user->student ? $user->student->fullName : null,
            'teacherName' => $user->teacher ? $user->teacher->fullName : null,
        ];
    });
    // Trả về kết quả dưới dạng JSON
    return response()->json($formattedUsers);
}

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\faculty;
use http\QueryString;
use Illuminate\Http\Request;
use App\Models\student;
use App\Models\user1;
use App\Models\parents;

class sudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['parents', 'user','faculty'])->get();

        $formattedStudents = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'userID' => $student->userID,
                'studentID'=>$student->studentID,
                'facultyID'=>$student->faculty_id,
                    //?$student->faculty->name:null,
                'faculty' => $student->faculty ? $student->faculty->name : null,
                'fullName' => $student->fullName,
                'gender' => $student->gender,
                'dateOfBirth' => $student->dateOfBirth,
                'nickName' => $student->nickName,
                'placeOfBirth' => $student->placeOfBirth,
                'permanenAddress' => $student->permanenAddress,
                'avatar' => $student->avatar,
                'nationalIdentityCard' => $student->nationalIdentityCard,
                'ethnicity' => $student->ethnicity,
                'religion' => $student->religion,
                'educationalLevel' => $student->educationalLevel,
                'DateOffAdmissionToDTNCS' => $student->DateOffAdmissionToDTNCS,
                'policyBeneficiary' => $student->policyBeneficiary,
                'contactAddress' => $student->contactAddress,
                'hometown' => $student->hometown,
                'email' => $student->user ? $student->user->email : null,
                'phoneNumber' => $student->user ? $student->user->phoneNumber : null,
                'roleID' => $student->user ? $student->user->roleID : null,
                'created_at' => $student->user ? $student->user->created_at : null,
                'updated_at' => $student->user ? $student->user->updated_at : null,
                'roleName' => $student->user && $student->user->role ? $student->user->role->roleName : null,
            ];
        });

        return response()->json($formattedStudents);
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


  //       Gọi hàm store của userController để tạo mới một bản ghi user
        $userController = new UserController();
        $a = $userController->store(new Request([
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'roleID' => '103',
            'password' => '12345'
        ]));

        $data = $request->all();
        $data['userID'] = $a->id;
        $data['roleID'] = '103';

        $st=student::create($data);

        $fullNamefa = $request->input('fullNamefa');
        $phoneNumberfa = $request->input('phoneNumberfa');
        $professtionfa = $request->input('professtionfa');
        $genderfa = 'nam';
        // Tạo một mảng chứa dữ liệu để truyền vào đối tượng Request
        $datafa = [
            'fullName' => $fullNamefa,
            'phoneNumber' => $phoneNumberfa,
            'professtion' => $professtionfa,
            'gender' => $genderfa,
            'studentID' => $st->id
        ];
        // Tạo đối tượng Request với dữ liệu được truyền vào
        $requestForParent = new Request($datafa);
        // Gọi phương thức store của parentController và truyền đối tượng Request vào
        $father = new parentController();
        $father->store($requestForParent);


        $fullNameMo = $request->input('fullNameMo');
        $phoneNumberMo = $request->input('phoneNumberMo');
        $professtionMo = $request->input('professtionMo');
        $genderMo = 'nu'; // hoặc giá trị tương ứng với nữ
        // Tạo một mảng chứa dữ liệu để truyền vào đối tượng Request
        $dataMo = [
            'fullName' => $fullNameMo,
            'phoneNumber' => $phoneNumberMo,
            'professtion' => $professtionMo,
            'gender' => $genderMo,
            'studentID' => $st->id
        ];
        // Tạo đối tượng Request với dữ liệu được truyền vào
        $requestForMother = new Request($dataMo);

        // Gọi phương thức store của parentController và truyền đối tượng Request vào
        $mother = new parentController();
        $mother->store($requestForMother);
        return response()->json(['message' => $data]);



        // Tiếp tục xử lý logic tạo mới bản ghi student ở đây
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $student = Student::with(['parents', 'user','faculty'])->find($id);
        if (!$student) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        $father = $student->parents()->where('gender', 'nam')->first();
        $mother = $student->parents()->where('gender', 'nu')->first();

        return response()->json([
            'id' => $student->id,
            'userID' => $student->userID,
            'fullName' => $student->fullName,
            'studentID'=>$student->studentID,
            'facultyID'=>$student->faculty_id,
            //?$student->faculty->name:null,
            'faculty' => $student->faculty ? $student->faculty->name : null,
            'gender' => $student->gender,
            'dateOfBirth' => $student->dateOfBirth,
            'nickName' => $student->nickName,
            'placeOfBirth' => $student->placeOfBirth,
            'permanenAddress' => $student->permanenAddress,
            'avatar' => $student->avatar,
            'nationalIdentityCard' => $student->nationalIdentityCard,
            'ethnicity' => $student->ethnicity,
            'religion' => $student->religion,
            'educationalLevel' => $student->educationalLevel,
            'DateOffAdmissionToDTNCS' => $student->DateOffAdmissionToDTNCS,
            'policyBeneficiary' => $student->policyBeneficiary,
            'contactAddress' => $student->contactAddress,
            'hometown' => $student->hometown,
            'email' => $student->user ? $student->user->email : null,
            'phoneNumber' => $student->user ? $student->user->phoneNumber : null,
            'roleID' => $student->user ? $student->user->roleID : null,
            'created_at' => $student->user ? $student->user->created_at : null,
            'updated_at' => $student->user ? $student->user->updated_at : null,

            'namemother' => $mother?$mother->fullName:"Mồ côi",
            'profesmother' => $mother?$mother->professtion:null,
            'phoneNumbermo' => $mother?$mother->phoneNumber:null,

            'namefather' => $father ? $father->fullName:"Mồ côi" ,
            'profesfather' => $father?$father->professtion:null ,
            'phoneNumberfa' => $father?$father->phoneNumber:null ,
            // Thông tin cha và mẹ



            'roleName' => $student->user && $student->user->role ? $student->user->role->roleName : null,
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
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Lấy dữ liệu từ request và cập nhật thông tin sinh viên

        $student->fullName = $request->input('fullName');
        $student->gender = $request->input('gender');
        $student->studentID = $request->input('studentID');
        $student->dateOfBirth = $request->input('dateOfBirth');
        $student->nickName = $request->input('nickName');
        $student->placeOfBirth = $request->input('placeOfBirth');
        $student->permanentAddress = $request->input('permanentAddress');
        $student->avatar = $request->input('avatar');
        $student->nationalIdentityCard = $request->input('nationalIdentityCard');
        $student->ethnicity = $request->input('ethnicity');
        $student->religion = $request->input('religion');
        $student->educationalLevel = $request->input('educationalLevel');
        $student->DateOffAdmissionToDTNCS = $request->input('DateOffAdmissionToDTNCS');
        $student->policyBeneficiary = $request->input('policyBeneficiary');
        $student->contactAddress = $request->input('contactAddress');
        $student->hometown = $request->input('hometown');

        // Lưu các thay đổi vào cơ sở dữ liệu
        $student->save();
        $father = parents::where('studentID', $student->id)
            ->where('gender', 'nam')
            ->first();
        $father ->fullName = $request->input('fullNamefa');
        $father ->phoneNumber = $request->input('phoneNumberfa');
        $father ->professtion = $request->input('professtionfa');
        $father->save();

        $mother = parents::where('studentID', $student->id)
            ->where('gender', 'nu')
            ->first();
        $mother ->fullName = $request->input('fullNameMo');
        $mother ->phoneNumber = $request->input('phoneNumberMo');
        $mother ->professtion = $request->input('professtionMo');
        $mother->save();

        $user = user1::find($student->userID);
        $user->email = $request->input('email');
        $user->save();

       // return  response()->json(['fa'=>$father,'mo'=>@$mother,'us'=>$user],201);
        return response()->json($student);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = student::find($id);
        // Check if the brand exists
        if (!$student) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        // Delete the brand
        $student->delete();
        return response()->json(['message' => 'Resource deleted successfully']);
    }
    public function search(Request $request)
    {
        // Lấy thông tin tìm kiếm từ yêu cầu
        $keyword = $request->input('search');

        // Thực hiện tìm kiếm trong cơ sở dữ liệu
        $students = Student::where('id', 'like', '%' . $keyword . '%')
            ->orWhere('fullName', 'like', '%' . $keyword . '%')
            ->orWhere('nickName', 'like', '%' . $keyword . '%')
            ->orWhere('nationalIdentityCard', 'like', '%' . $keyword . '%')
            ->orWhere('religion', 'like', '%' . $keyword . '%')
            ->orWhere('educationalLevel', 'like', '%' . $keyword . '%')
            ->orWhere('contactAddress', 'like', '%' . $keyword . '%')
            ->orWhere('hometown', 'like', '%' . $keyword . '%')
            ->get();

        // Định dạng kết quả trả về
        $formattedStudents = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'fullName' => $student->fullName,
                "studentID" => $student->studentID,
                "email" => $student->user?$student->user->email:null,
                'phoneNumber' => $student->user ? $student->user->phoneNumber : null,
                'gender' => $student->gender,
                'dateOfBirth' => $student->dateOfBirth,
                'nickName' => $student->nickName,
                'placeOfBirth' => $student->placeOfBirth,
                'permanentAddress' => $student->permanentAddress,
                'avatar' => $student->avatar,
                'nationalIdentityCard' => $student->nationalIdentityCard,
                'ethnicity' => $student->ethnicity,
                'religion' => $student->religion,
                'educationalLevel' => $student->educationalLevel,
                'DateOffAdmissionToDTNCS' => $student->DateOffAdmissionToDTNCS,
                'policyBeneficiary' => $student->policyBeneficiary,
                'contactAddress' => $student->contactAddress,
                'hometown' => $student->hometown,
            ];
        });

        // Trả về kết quả dưới dạng JSON
        return response()->json($formattedStudents);
    }

}

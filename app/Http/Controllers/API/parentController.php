<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\parents;

class parentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    //Trích xuất dữ liệu từ request
    $data = $request->all();

    // Tạo một đối tượng mới từ dữ liệu request
    $newparent = new parents(); // Giả sử Student là tên model của bạn
    $newparent->studentID = $data['studentID'];
    $newparent->fullName = $data['fullName'];
    $newparent->phoneNumber = $data['phoneNumber'];
    $newparent->professtion = $data['professtion'];
    $newparent->gender = $data['gender'];
    // Gán các thuộc tính khác (nếu có)

    // Lưu đối tượng vào cơ sở dữ liệu
    $newparent->save();

    // Trả về đối tượng đã tạo
    return response()->json($newparent, 201); // 201 là mã trạng thái Created
    // $data = $request->all();
    // return parent::create($data);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

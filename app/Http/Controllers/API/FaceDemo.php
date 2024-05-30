<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
class FaceDemo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function detectFaces(Request $request)
    {
        $file = $request->file('file');

        // Kiểm tra xem file có tồn tại không
        if ($file) {
            // Gửi yêu cầu POST đến Flask app
            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post('http://192.168.1.4:5001/');

            // Lấy kết quả từ phản hồi
            $data = $response->json();

            // Xử lý kết quả tại đây và trả về view hoặc JSON response
            return response()->json($data);
        }

        // Trả về lỗi nếu không có file được gửi
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

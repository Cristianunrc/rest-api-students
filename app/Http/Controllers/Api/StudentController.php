<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getStudents() {
        $students = Student::all();
        if ($students->isEmpty()) {
            $data = [
                'message' => 'No registered students',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        return response()->json($students, 200);
    }

    public function getStudent($id) {
        $student = Student::find($id);
        if ($student) {
            $data = [
                'message' => 'Getting student.',
                'student' => $student,
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        $data = [
            'message' => 'Student no found.',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    public function createStudent(Request $request) {
        $validator = $this->validateStudent($request);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error in data validation.',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);
        }

        $student = Student::create($request->all());

        if (!$student) {
            $data = [
                'message' => 'Error creating the student.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Student created successfully.',
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function deleteStudent($id) {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            $data = [
                'message' => 'Deleting student',
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        $data = [
            'message' => 'Student no found.',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    private function validateStudent(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'language' => 'required'
        ]);
    }
}

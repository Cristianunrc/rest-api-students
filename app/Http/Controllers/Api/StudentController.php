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
            return response()->json([
                    'message' => 'No students registered.',
                    'status' => '404'
            ], 404);
        }
        return response()->json($students, 200);
    }

    public function getStudent($id) {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                    'message' => 'Getting student.',
                    'student' => $student,
                    'status' => 200
            ], 200);
        }
        return response()->json([
                'message' => 'Student not found.',
                'status' => 404
        ], 404);
    }

    public function createStudent(Request $request) {
        $validator = $this->validateStudent($request);
        if ($validator->fails()) {
            return response()->json([
                    'message' => 'Error in data validation.',
                    'errors' => $validator->errors(),
                    'status' => 422
            ], 422);
        }
        $student = Student::create($request->all());
        if (!$student) {
            return response()->json([
                    'message' => 'Error creating the student.',
                    'status' => 500
            ], 500);
        }
        return response()->json([
                'message' => 'Student created successfully.',
                'student' => $student,
                'status' => 201
        ], 201);
    }

    public function deleteStudent($id) {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'message' => 'Deleting student',
                'status' => 200
            ], 200);
        }
        return response()->json([
            'message' => 'Student no found.',
            'status' => 404
        ], 404);
    }

    public function updateStudent(Request $request, $id) {
        $student = Student::find($id);
        if ($student) {
            $validator = $this->validateStudent($request);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error in data validation.',
                    'errors' => $validator->errors(),
                    'status' => 422
                ], 422);
            }
            $student->fill($request->all());
            $student->save();
            return response()->json([
                'message' => 'Updating student.',
                'student' => $student,
                'status' => 200
            ], 200);
        }
        return response()->json([
            'message' => 'Student not found.',
            'status' => 404
        ], 404);
    }

    public function updatePartial(Request $request, $id) {
        $student = Student::find($id);
        if ($student) {
            $validator = $this->validatePartialStudent($request);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error in data validation.',
                    'errors' => $validator->errors(),
                    'status' => 422
                ], 422);
            }
            $student->fill($request->only(['name', 'email', 'phone', 'language']));
            $student->save();
            return response()->json([
                'message' => 'Updating student.',
                'student' => $student,
                'status' => 200
            ], 200);
        }
        return response()->json([
            'message' => 'Student not found.',
            'status' => 404
        ], 404);
    }

    private function validateStudent(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'language' => 'required'
        ]);
    }
    
    private function validatePartialStudent(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'language' => 'sometimes|required'
        ]);
    }
}

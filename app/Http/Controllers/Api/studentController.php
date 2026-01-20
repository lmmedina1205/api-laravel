<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'language' => $request->input('language')
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Estudiante creado exitosamente.',
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado.',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroyAll()
    {
        Student::query()->delete();

        $data = [
            'message' => 'Todos los estudiantes han sido eliminados.',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->language = $request->input('language');

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado exitosamente.',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $student->name = $request->input('name');
        }
        if ($request->has('email')) {
            $student->email = $request->input('email');
        }
        if ($request->has('phone')) {
            $student->phone = $request->input('phone');
        }
        if ($request->has('language')) {
            $student->language = $request->input('language');
        }

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado exitosamente.',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        if (!$student->trashed()) {
            $data = [
                'message' => 'El estudiante no está eliminado.',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->restore();

        $data = [
            'message' => 'Estudiante restaurado exitosamente.',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}

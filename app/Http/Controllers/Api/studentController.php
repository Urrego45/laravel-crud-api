<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index () {
        $students = Student::all();

        // if ($students->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron estudiantes.',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 400);

        // }
        $data = [
            'message' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store (Request $req) {

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'lenguage' => 'required|in:English,Spanish,French'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'lenguage' => $req->lenguage,
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 400
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id) {

        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'message' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function destroy($id) {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $req, $id) {

        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'lenguage' => 'required|in:English,Spanish,French'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $student->name = $req->name;
        $student->email = $req->email;
        $student->phone = $req->phone;
        $student->lenguage = $req->lenguage;

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function updatePartial(Request $req, $id) {

        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($req->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'lenguage' => 'in:English,Spanish,French'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        if ($req->has('name')) $student->name = $req->name;
        if ($req->has('email')) $student->email = $req->email;
        if ($req->has('phone')) $student->phone = $req->phone;
        if ($req->has('lenguage')) $student->lenguage = $req->lenguage;


        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

}

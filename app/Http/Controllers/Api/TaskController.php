<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'يجب تسجيل الدخول',
                    'en' => 'Unauthenticated'
                ]
            ]);
        }

        $validate = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'status' => ['required', 'string']
        ]);

        $task = Task::create([
            'title'   => $validate['title'],
            'status'  => $validate['status'],
            'user_id' => $user->id
        ]);

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم إنشاء التاسك بنجاح',
                'en' => 'Task created successfully'
            ],
            'data' => $task
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'يجب تسجيل الدخول',
                    'en' => 'Unauthenticated'
                ]
            ]);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'غير موجود',
                    'en' => 'Not found'
                ]
            ]);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم الحذف بنجاح',
                'en' => 'Deleted successfully'
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'المستخدم غير موجود',
                    'en' => 'User not found'
                ]
            ]);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'التاسك غير موجود',
                    'en' => 'Task not found'
                ]
            ]);
        }

        $validate = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'status' => ['required', 'string']
        ]);

        $task->update($validate);

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم تعديل التاسك بنجاح',
                'en' => 'Task updated successfully'
            ]
        ]);
    }
}

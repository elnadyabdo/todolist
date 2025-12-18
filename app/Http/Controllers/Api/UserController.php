<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /* CREATE */
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
            'name'   => ['required', 'string', 'max:255'],
            'title'  => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email'],
            'status' => ['required', 'string', 'in:active,inactive']
        ]);

        $newUser = User::create($validate);

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم إنشاء المستخدم بنجاح',
                'en' => 'User created successfully'
            ],
            'data' => $newUser
        ]);
    }

    /* READ */
    public function show(Request $request, $id)
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

        $targetUser = User::find($id);
        if (!$targetUser) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'المستخدم غير موجود',
                    'en' => 'User not found'
                ]
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $targetUser
        ]);
    }

    /* UPDATE */
    public function update(Request $request, $id)
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

        $targetUser = User::find($id);
        if (!$targetUser) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'المستخدم غير موجود',
                    'en' => 'User not found'
                ]
            ]);
        }

        $validate = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'title'  => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email,' . $id],
            'status' => ['required', 'string', 'in:active,inactive']
        ]);

        $targetUser->update($validate);

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم تعديل المستخدم بنجاح',
                'en' => 'User updated successfully'
            ]
        ]);
    }

    /* DELETE */
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

        $targetUser = User::find($id);
        if (!$targetUser) {
            return response()->json([
                'status' => false,
                'message' => [
                    'ar' => 'المستخدم غير موجود',
                    'en' => 'User not found'
                ]
            ]);
        }

        $targetUser->delete();

        return response()->json([
            'status' => true,
            'message' => [
                'ar' => 'تم حذف المستخدم بنجاح',
                'en' => 'User deleted successfully'
            ]
        ]);
    }
}

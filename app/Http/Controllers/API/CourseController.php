<?php

namespace App\Http\Controllers\API;

use App\Enums\PaginationEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\TeacherCourseCollection;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return TeacherCourseCollection
     */
    public function index(Request $request): TeacherCourseCollection
    {
        $user = $request->user();

        if ($user->cannot('viewAny', Course::class)) {
            abort(403);
        }

        // Teacher able to see the students list of each class they teach.
        $courses = $user->courses()->with(['users' => function($query) {
            return $query->where('role_id', RoleEnum::STUDENT->value)->orderBy('name');
        }])
            ->orderBy('name')
            ->paginate(PaginationEnum::ITEM_PER_PAGE->value);

        return new TeacherCourseCollection($courses);
    }
}

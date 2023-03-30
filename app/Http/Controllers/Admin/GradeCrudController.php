<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operation\InlineCreateOperation;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

/**
 * Class GradeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GradeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }

    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Grade::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/grade');
        CRUD::setEntityNameStrings('Lớp học', 'Danh sách lớp học');
        if (backpack_user()->role == "staff") {
            $this->crud->query->whereHas("staffs", function (Builder $builder) {
                $builder->where("id", backpack_user()->id);
            });
        }
        if (backpack_user()->role == "teacher") {
            $this->crud->query->whereHas("teachers", function (Builder $teacher) {
                $teacher->where("id", backpack_user()->id);
            });
            $this->crud->denyAccess(["create", "update", "delete"]);
        }
        if (backpack_user()->role == "student") {
            $this->crud->query->whereHas("students", function (Builder $student) {
                $student->where("users.id", backpack_user()->id);
            });
            $this->crud->denyAccess(["create", "update", "delete"]);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    public function filters(): void
    {
        $this->crud->addFilter([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Tên lớp',
        ], false, function ($value) {
            $this->crud->query->where("name", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'program',
            'type' => 'text',
            'label' => 'Chương trình học',
        ], false, function ($value) {
            $this->crud->query->where("program", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'staff',
            'type' => 'text',
            'label' => 'Nhân viên quản lý',
        ], false, function ($value) {
            $this->crud->query->whereHas("staffs", function (Builder $staff) use ($value) {
                $staff->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'teacher',
            'type' => 'text',
            'label' => 'Giáo viên',
        ], false, function ($value) {
            $this->crud->query->whereHas("teachers", function (Builder $teacher) use ($value) {
                $teacher->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'supporter',
            'type' => 'text',
            'label' => 'Trợ giảng',
        ], false, function ($value) {
            $this->crud->query->whereHas("supporters", function (Builder $supporter) use ($value) {
                $supporter->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'student',
            'type' => 'text',
            'label' => 'Học sinh',
        ], false, function ($value) {
            $this->crud->query->whereHas("students", function (Builder $student) use ($value) {
                $student->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Trạng thái lớp',
        ], function () {
            return [
                "Đang học",
                "Đã kết thúc",
                "Đang bảo lưu"
            ];
        }, function ($value) {
            $this->crud->query->where("status", $value);
        });
    }

    protected function setupListOperation()
    {
        $this->crud->removeButton("show");
        //Filter
        $this->filters();
        //
        if (isset($_REQUEST["teacher_id"])) {
            $teacher = Teacher::find($_REQUEST["teacher_id"]);
            $this->crud->query->whereHas("teachers", function (Builder $bTeacher) use ($teacher) {
                $bTeacher->where("id", $teacher->id);
            });
            CRUD::setEntityNameStrings($teacher->name, "Lớp của giáo viên " . "\"$teacher->name\"");
            $this->crud->denyAccess(["create"]);
        }
        if (isset($_REQUEST["student_id"])) {
            $student = Student::find($_REQUEST["student_id"]);
            $this->crud->query->whereHas("students", function (Builder $bStudent) use ($student) {
                $bStudent->where("users.id", $student->id);
            });
            CRUD::setEntityNameStrings($student->name, "Lớp của học viên " . "\"$student->name\"");
            $this->crud->denyAccess(["create"]);
        }
        $this->crud->disableResponsiveTable();
        if (backpack_user()->role == "staff") {
//            $this->crud->query();
        }

        if (session("success")) {
            Alert::success(session("success"));
        }
        $this->crud->addClause("where", "disable", 0);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên lớp',
            'wrapper' => [
                'href' => function ($crud, $column, $entry) {
                    return backpack_url("/grade/$entry->id/show");
                },
            ]
        ]);
        CRUD::addColumn([
            'name' => 'program',
            'label' => 'Chương trình học',
        ]);
        CRUD::addColumn([
            'name' => 'time',
            'label' => 'Thời lượng',
            'type' => 'number',
            'suffix' => ' giờ',
        ]);
        CRUD::addColumn([
            'name' => 'lessons',
            'label' => 'Số buổi',
            'type' => 'number',
        ]);
        CRUD::addColumn([
            'name' => 'staffs',
            'label' => 'Nhân viên quản lý',
        ]);
        CRUD::addColumn([
            'name' => 'teachers',
            'label' => 'Giáo viên',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $rl) {
                    return backpack_url("/teacher/$rl/show");
                },
            ]
        ]);
        CRUD::addColumn([
            'name' => 'supporters',
            'label' => 'Trợ giảng',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $rl) {
                    return backpack_url("/teacher/$rl/show");
                },
            ]
        ]);
        CRUD::addColumn([
            'name' => 'students',
            'label' => 'Học sinh',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $rl) {
                    return backpack_url("/student/$rl/show");
                },
            ]
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'select_from_array',
            'options' => [
                'Đang học',
                'Đã kết thúc',
                'Đang bảo lưu'
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(GradeRequest::class);
        CRUD::field('origin')->type("hidden")->value(backpack_user()->origin);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Tên lớp',
        ]);
        CRUD::addField([
            'name' => 'program',
            'label' => 'Chương trình học',
        ]);
        CRUD::addField([
            'name' => 'time',
            'label' => 'Thời lượng',
            'type' => 'number',
            'suffix' => 'Giờ'
        ]);
        CRUD::addField([
            'name' => 'lessons',
            'label' => 'Số buổi',
            'type' => 'number',
        ]);
        CRUD::addField([
            'name' => 'thumbnail',
            'label' => 'Ảnh minh họa',
            'default' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
            'type' => 'image',
            'crop' => true,
            'aspect_ratio' => 1,
        ]);
        if (backpack_user()->role == "admin") {
            CRUD::addField([
                'name' => 'staffs',
                'label' => 'Nhân viên',
                'type' => 'relationship',
                'model' => 'App\Models\Staff',
                'entity' => 'Staffs',
                'attribute' => 'name',
                'pivot' => true,
                'options' => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('role', "staff")->get();
                }),
            ]);
        }
        CRUD::addField([
            'name' => 'teachers',
            'label' => 'Giáo viên',
            'type' => 'relationship',
            'model' => 'App\Models\Teacher',
            'entity' => 'Teachers',
            'attribute' => 'name',
            'pivot' => true,
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('role', "teacher")->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'supporters',
            'label' => 'Trợ giảng',
            'type' => 'relationship',
            'model' => 'App\Models\Teacher',
            'entity' => 'Supporters',
            'attribute' => 'name',
            'pivot' => true,
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('role', "teacher")->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'select_from_array',
            'options' => [
                'Đang học',
                'Đã kết thúc',
                'Đang bảo lưu'
            ],
            'wrapper' => ['class' => 'col-md-6 mb-2']
        ]);
        CRUD::addField([
            'name' => 'times',
            'label' => 'Lịch học',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'day',
                    'label' => "Ngày trong tuần",
                    'type' => 'select2_from_array',
                    'options' => [
                        'monday' => 'Thứ 2',
                        'tuesday' => 'Thứ 3',
                        'wednesday' => 'Thứ 4',
                        'thursday' => 'Thứ 5',
                        'friday' => 'Thứ 6',
                        'saturday' => 'Thứ 7',
                        'sunday' => 'Chủ nhật',
                    ],
                    'wrapper' => ['class' => 'col-md-6 mb-2']
                ],
                [
                    'name' => 'start',
                    'type' => 'time',
                    'label' => 'Bắt đầu',
                    'wrapper' => ['class' => 'col-md-3 mb-2']
                ],
                [
                    'name' => 'end',
                    'type' => 'time',
                    'label' => 'Kết thúc',
                    'wrapper' => ['class' => 'col-md-3 mb-2']
                ]
            ],
            'new_item_label' => 'Thêm lịch'
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


//    protected function setupShowOperation()
//    {
//
////        $this->crud->addColumn([
////            'name' => 'thumbnail',
////            'label' => false,
////            'type' => 'image'
////        ]);
//        $this->crud->addColumn([
//            'name' => 'name',
//            'label' => 'Tên lớp',
//        ]);
//        $this->crud->addColumn([
//            'name' => 'pricing',
//            'label' => 'Gói học phí',
//            'type' => 'number',
//            'suffix' => ' đ',
//        ]);
//        $this->crud->addColumn([
//            'name' => 'information',
//            'label' => 'Thông tin',
//            'type' => 'html',
//        ]);
//        $this->crud->addColumn([
//            'name' => 'link',
//            'label' => 'Link lớp học',
//            'type' => 'link',
//        ]);
//        $this->crud->addColumn([
//            'name' => 'times',
//            'label' => 'Lịch học',
//            'type' => 'json_view',
//        ]);
//        Widget::add([
//            'type' => 'relation_table',
//            'name' => 'logs',
//            'button' => true,
//            'label' => 'Nhật ký của lớp',
//            'backpack_crud' => 'log',
//            'visible' => function ($entry) {
//                return $entry->logs->count() > 0;
//            },
//            'search' => function ($query, $search) {
//                return $query->where('lesson', 'like', "%{$search}%");
//            },
//            'relation_attribute' => 'grade_id',
//            'button_create' => true,
//            'button_delete' => false,
//            'columns' => [
//                [
//                    'label' => 'Bài học',
//                    'name' => 'lesson',
//                ],
//                [
//                    'label' => 'Ngày',
//                    'name' => 'date',
//                ],
//                [
//                    'label' => 'Bắt đầu',
//                    'name' => 'start',
//                ],
//                [
//                    'label' => 'Kết thúc',
//                    'name' => 'end',
//                ],
//                [
//                    'label' => 'Lương theo giờ',
//                    'name' => 'salary_per_hour',
//                    'type' => 'number',
//                    'suffix' => 'đ',
//                ],
//                [
//                    'label' => 'Video',
//                    'name' => 'video',
//                    'type' => 'video'
//                ],
//            ],
//        ])->to('after_content');
//    }

    protected function destroy($id)
    {
        Grade::find($id)->update(["disable" => 1]);
        return redirect(backpack_url("/grade/"))->with("success", "Xóa thành công !");
    }

    public function store()
    {
        $response = $this->traitStore();
        if (backpack_user()->role == "staff") {
            $id = Grade::orderBy("id", "DESC")->first()->id;
            DB::table("staff_grade")->insert([
                'grade_id' => $id,
                'staff_id' => backpack_user()->id
            ]);
        }
        return $response;
    }

    public function show($id)
    {
        return view("grade.detail", ['entry' => $this->crud->getCurrentEntry()]);
    }
}

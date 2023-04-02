<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogRequest;
use App\Models\Grade;
use App\Models\Log;
use App\Models\Student;
use App\Models\Teacher;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Log::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/log');
        CRUD::setEntityNameStrings('Nhật ký', 'Nhật ký');
        if (backpack_user()->role == "staff") {
            $this->crud->query->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("staffs", function (Builder $staff) {
                    $staff->where("id", backpack_user()->id);
                });
            });
        }
        if (backpack_user()->role == "teacher") {
            $this->crud->query->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("teachers", function (Builder $teacher) {
                    $teacher->where("id", backpack_user()->id);
                });
            });
        }
        if (backpack_user()->role == "student") {
            $this->crud->query->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("students", function (Builder $student) {
                    $student->where("users.id", backpack_user()->id);
                });
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
    public function SetFilter()
    {
        $this->crud->addFilter([
            'name' => 'grade',
            'type' => 'text',
            'label' => 'Lớp học'
        ], false, function ($value) {

        });
    }

    protected function setupListOperation()
    {
        $this->SetFilter();
        if (isset($_REQUEST["grade_id"])) {
            $grade = Grade::find($_REQUEST["grade_id"]);
            $this->crud->query->where("grade_id", $_REQUEST["grade_id"]);
            CRUD::setEntityNameStrings($grade->name, "Lớp " . $grade->name);
            $this->crud->denyAccess(["create"]);
        }
        if (isset($_REQUEST["teacher_id"])) {
            $teacher = Teacher::find($_REQUEST["teacher_id"]);
            $this->crud->query->whereHas("grade", function (Builder $grade) use ($teacher) {
                $grade->whereHas("teachers", function (Builder $bTeacher) use ($teacher) {
                    $bTeacher->where("id", $teacher->id);
                });
            });
            CRUD::setEntityNameStrings($teacher->name, "Nhật ký của giáo viên " . "\"$teacher->name\"");
            $this->crud->denyAccess(["create"]);
        }
        if (isset($_REQUEST["student_id"])) {
            $student = Student::find($_REQUEST["student_id"]);
            $this->crud->query->whereHas("grade", function (Builder $grade) use ($student) {
                $grade->whereHas("students", function (Builder $bStudent) use ($student) {
                    $bStudent->where("users.id", $student->id);
                });
            });
            CRUD::setEntityNameStrings($student->name, "Nhật ký của học viên " . "\"$student->name\"");
            $this->crud->denyAccess(["create"]);
        }
        $this->crud->disableResponsiveTable();
        if (backpack_user()->role != "admin") {

        }
        CRUD::column('grade')->label("Lớp học")->wrapper([
            'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url('grade/' . $related_key . '/show');
            },
        ]);
        CRUD::column('no')->label("Buổi học")->prefix("Buổi ")->wrapper([
            'href' => function ($crud, $column, $entry) {
                return backpack_url('log/' . $entry->id . '/show');
            },
        ]);
        CRUD::column('lesson')->label("Bài học");
        CRUD::column('attachments')->type("link")->label("Đính kèm");
        CRUD::column('teacher')->label("Giáo viên");
        CRUD::column('date')->label("Ngày")->type("date");
        CRUD::column('start')->label("Bắt đầu")->type("time");
        CRUD::column('end')->label("Kết thúc")->type("time");
        if (backpack_user()->role != "student") {
            CRUD::column('salary_per_hour')->label("Lương theo giờ")->type("number")->suffix("đ");
        }
        CRUD::column('video')->type("video");
        $this->crud->removeButton("show");
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
        CRUD::setValidation(LogRequest::class);
        if (isset($_REQUEST["grade_id"])) {
            $grade = Grade::where("id", $_REQUEST["grade_id"])->first();
            if (!isset($grade->id)) {
                CRUD::addField([
                    'name' => 'grade',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh nào',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                ]);
            } else {
                CRUD::field('grade_id')->value($_REQUEST["grade_id"])->type("hidden");
                if (backpack_user()->role != "teacher") {
                    CRUD::addField([
                        'label' => 'Giáo viên',
                        'name' => 'teacher_id',
                        'type' => 'relationship',
                        'entity' => 'Teacher',
                        'attribute' => 'name',
                        'options' => (function ($query) {
                            return $query->whereHas("grades", function (Builder $builder) {
                                $builder->where("id", $_REQUEST["grade_id"]);
                            });
                        }),
                    ]);
                } else {
                    CRUD::field('teacher_id')->value(backpack_user()->id)->type("hidden");
                }
                CRUD::field('no')->label("Buổi học")->prefix("Buổi ")->wrapper([
                    "class" => 'col-md-6 mb-3'
                ]);
                CRUD::field('lesson')->label("Bài học")->wrapper([
                    "class" => 'col-md-6 mb-3'
                ]);
                CRUD::field('date')->label("Ngày")->wrapper(["class" => "col-md-4 mb-2"])->default(Carbon::now());
                CRUD::field('start')->label("Bắt đầu")->wrapper(["class" => "col-md-4 mb-2"]);
                CRUD::field('end')->label("Kết thuc")->wrapper(["class" => "col-md-4 mb-2"]);
                $studentsDF = Student::whereHas("grades", function (Builder $builder) {
                    $builder->where("grades.id", $_REQUEST["grade_id"]);
                })->get("name");
                foreach ($studentsDF as $student) {
                    $student->present = "0";
                    $student->comment = "";
                }
//                dd(json_encode($students));
                CRUD::addField([   // select_and_order
                    'name' => 'students',
                    'label' => 'Điểm danh',
                    'type' => 'repeatable',
                    'default' => $studentsDF->toJson(),
                    'init_rows' => $studentsDF->count(), // number of empty rows to be initialized, by default 1
                    'min_rows' => $studentsDF->count(), // minimum rows allowed, when reached the "delete" buttons will be hidden
                    'max_rows' => $studentsDF->count(),
                    'fields' => [
                        [
                            'name' => 'name',
                            'label' => 'Tên học sinh',
                            'attributes' => [
                                'readonly' => true
                            ]
                        ],
                        [
                            'name' => 'present',
                            'label' => 'Có tham gia học',
                            'type' => 'switch'
                        ],
                        [
                            'name' => 'comment',
                            'label' => 'Nhận xét',
                            'type' => 'textarea'
                        ],
                    ]
                ]);
                CRUD::field('salary_per_hour')->type("number")->label("Lương theo giờ")->wrapper(["class" => "col-md-6 mb-2"])->suffix(" đ");;
                CRUD::field('video')->type("video")->label("Video bài học")->wrapper(["class" => "col-md-6 mb-2"]);
                CRUD::field('teacher_comment')->label("Giáo viên nhận xét về buổi học");
                CRUD::field('question')->label("Bài tập của giáo viên");
                CRUD::addField([
                    'name' => 'attachments',
                    'type' => 'upload',
                    'label' => 'Đính kèm',
                    'upload' => true,
                    'disk' => 'public'
                ]);

            }
        } else {
            if (backpack_user()->role != "admin" && backpack_user()->role!="super") {
                CRUD::addField([
                    'name' => 'grade_id',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh nào',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                    'options' => (function ($query) {
                        if(backpack_user()->role=="staff"){
                            return $query->where(function (Builder $sub){
                                $sub->whereHas("staffs",function (Builder $builder){
                                    $builder->where("id",backpack_user()->id);
                                })->orWhereHas("supporters",function (Builder $builder){
                                    $builder->where("id",backpack_user()->id);
                                });
                            })->get();
                        }
                        if(backpack_user()->role=="teacher"){
                            return $query->whereHas("teachers",function (Builder $builder){
                                $builder->where("id",backpack_user()->id);
                            })->get();
                        }
                    }),
                ]);
            } else {
                CRUD::addField([
                    'name' => 'grade_id',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                ]);
            }
        }
        CRUD::field('origin')->type("hidden")->value(backpack_user()->origin);
        Widget::add()->type('script')->content(asset("js/grades.js"));


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
        $_REQUEST["grade_id"] = $this->crud->getCurrentEntry()->grade->id;
        $this->setupCreateOperation();
    }

    protected function destroy($id)
    {
        Log::destroy($id);
        return redirect()->back()->with("success", "Xóa thành công!");
    }

    public function show($id)
    {
        return view("log.detail", ['log' => $this->crud->getCurrentEntry()]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operation\FetchOperation;
use App\Http\Controllers\Operation\Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Operation\InlineCreateOperation;
use App\Http\Requests\InvoiceRequest;
use App\Models\Grade;
use App\Models\Invoice;
use App\Models\Student;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use InlineCreateOperation;
    use FetchOperation;

    public function fetchStudent()
    {
        if (in_array(backpack_user()->role, ["super", "admin"])) {
            return $this->fetch(Student::class);
        } else {
            return $this->fetch([
                'model' => \App\Models\Student::class, // required
                'searchable_attributes' => ['name'],
                'paginate' => 10, // items to show per page
                'searchOperator' => 'LIKE',
                'query' => function ($model) {
                    return $model->where("staff_id", backpack_user()->id);
                } // to filter the results that are returned
            ]);
        }
//        return $this->fetch(Student::class);
    }

    public function fetchGrade()
    {
        if (in_array(backpack_user()->role, ["super", "admin"])) {
            return $this->fetch(Grade::class);
        } else {
            return $this->fetch([
                'model' => \App\Models\Grade::class, // required
                'searchable_attributes' => ['name'],
                'paginate' => 10, // items to show per page
                'searchOperator' => 'LIKE',
                'query' => function ($model) {
                    return $model->whereHas("staffs", function (Builder $staff) {
                        $staff->where("id", backpack_user()->id);
                    });
                } // to filter the results that are returned
            ]);
        }
//        return $this->fetch(Grade::class);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('Học phí', 'Học phí');
        if (backpack_user()->role == "staff") {
            $this->crud->query->whereHas("student", function (Builder $student) {
                $student->where("staff_id", backpack_user()->id);
            });
        }
        if (backpack_user()->role == "student") {
            $this->crud->query->whereHas("student", function (Builder $student) {
                $student->where("id", backpack_user()->id);
            });
            $this->crud->denyAccess(["create", "update", "delete", "show"]);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("show");
        $this->crud->query->whereHas("student", function (Builder $builder) {
            $builder->where("origin", Cookie::get("origin" ?? "bizsoft"));
        });
        $this->crud->addFilter([
            'name' => 'student',
            'type' => 'text',
            'label' => 'Tên học sinh',
        ], false, function ($value) {
            $this->crud->query->whereHas("student", function (Builder $student) use ($value) {
                $student->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'grade',
            'type' => 'text',
            'label' => 'Tên lớp',
        ], false, function ($value) {
            $this->crud->query->whereHas("grade", function (Builder $student) use ($value) {
                $student->where("name", "like", "%$value%");
            });
        });
        $this->crud->addFilter([
            'name' => 'payment',
            'type' => 'dropdown',
            'label' => 'Thu tiền',
        ], function () {
            return [
                'Đã đủ',
                'Còn thiếu'
            ];
        }, function ($value) {
            $this->crud->query->where("payment", $value);
        });
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Tình trạng học',
        ], function () {
            return [
                'Đang học',
                'Đã kết thúc',
                'Đang bảo lưu',
            ];
        }, function ($value) {
            $this->crud->query->where("status", $value);
        });
        $this->crud->addFilter([
            'name' => 'expired',
            'type' => 'simple',
            'label' => 'Quá hạn',
        ], false, function ($value) {
            $this->crud->query->where("deadline", "<", Carbon::now());
        });
        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Ngày bắt đầu'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->query->where('start', '>=', $dates->from);
                $this->crud->query->where('start', '<=', $dates->to);
            });
        $this->crud->disableResponsiveTable();
        CRUD::column('grade')->label("Lớp học")->wrapper([
            'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url("/grade/$related_key/show");
            },
        ]);
        CRUD::column('student')->label("Học sinh")->wrapper([
            'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url("/student/$related_key/show");
            },
        ]);;
        CRUD::column('start')->label("Ngày bắt đầu");
        CRUD::column('pricing')->label("Gói học phí")->type("number")->suffix(" đ");
        CRUD::column('promotion')->label("Ưu đãi")->type("number")->suffix(" đ");
        CRUD::column('current')->label("Đã thu")->type("number")->suffix(" đ");
        CRUD::column('in_debt')->label("Còn lại")->type("model_function")->function_name("debt")->suffix(" đ");
        CRUD::column('payment')->label("Thu học phí")->type("select_from_array")->options(["Đã đủ", "Còn thiếu"]);
        CRUD::column('deadline')->label("Ngày hẹn đóng");
        CRUD::column('status')->label("Tình trạng học")->type("select_from_array")->options(["Đang học", "Đã kết thúc", "Đã bảo lưu"]);

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

        CRUD::setValidation(InvoiceRequest::class);
        CRUD::field('student_id')->type("relationship")
            ->label("Chọn học sinh")->inline_create(true)->wrapper([
                'class' => 'col-md-12 mb-4'
            ])->hint(session("ending") ? "<span class='text-danger font-weight-bold'>" . session("ending") . "</span>" : "");;
        CRUD::field('grade_id')->type("relationship")->label("Lớp học")->inline_create(true)->wrapper([
            'class' => 'col-md-12 mb-4'
        ])->hint(session("error") ? "<span class='text-danger font-weight-bold'>" . session("error") . "</span>" : "");
        CRUD::field('start')->label("Ngày bắt đầu")->type("date")->wrapper([
            'class' => 'col-md-6 mb-4'
        ]);
        CRUD::field('status')->label("Tình trạng lớp")->type("select_from_array")->options(["Đang học", "Đã kết thúc", "Đã bảo lưu"])->wrapper([
            'class' => 'col-md-6 mb-4'
        ]);
        CRUD::field('pricing')->label("Gói học phí")->wrapper([
            'class' => 'col-md-4 mb-4'
        ])->suffix("đ");
        CRUD::field('promotion')->label("Ưu đãi")->wrapper([
            'class' => 'col-md-4 mb-4'
        ])->default(0)->suffix("đ");
        CRUD::field('current')->label("Đã thu")->wrapper([
            'class' => 'col-md-4 mb-4'
        ])->default(0)->suffix("đ");
        CRUD::field('payment')->label("Thu học phí")->type("select_from_array")->options([0 => "Đã đóng đủ", 1 => "Còn thiếu"])->wrapper([
            'class' => 'col-md-6 mb-4'
        ]);
        CRUD::field('deadline')->label("Hẹn đóng (Để trống nếu đã thu đủ)")->type("date")->wrapper([
            'class' => 'col-md-6 mb-4'
        ]);

        CRUD::field("alias")->type("hidden")->value("");

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
        $this->crud->removeField("grade_id");
        $this->crud->removeField("student_id");
    }

    protected function store(Request $request)
    {
        $student_id = $request->request->get("student_id") ?? null;
        $grade_id = $request->request->get("grade_id") ?? null;
        if ($student_id == null || $grade_id == null) {
            return redirect()->back()->with("error", "Lỗi");
        }
        $invoice = Invoice::where("grade_id", $grade_id)->where("student_id", $student_id)->first();
        if (isset($invoice->id)) {
            return redirect()->back()->with("error", "Đã gắn vào lớp từ trước");
        }
        $exist = Invoice::where("student_id", $student_id)->where("status", 0)->first();
        if (isset($exist->id)) {
            $grade = $exist->Grade()->first()->name;
            return redirect()->back()->with("ending", "Vẫn còn lớp $grade chưa kết thúc");
        }
        $response = $this->traitStore();
        return redirect("admin/invoice");

    }

    protected function destroy($id)
    {
        Invoice::find($id)->delete();
        return redirect()->back();
    }
}

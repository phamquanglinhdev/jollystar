<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operation\InlineCreateOperation;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\StudentRequest;
use App\Models\Grade;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends UserCrudController
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
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
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('Học viên', 'Học viên');
        if (backpack_user()->role == "staff") {
            $this->crud->query->where("staff_id", backpack_user()->id);
        }
        if (backpack_user()->role == "teacher") {
            $this->crud->query->whereHas("grades", function (Builder $grade) {
                $grade->whereHas("teachers", function (Builder $teacher) {
                    $teacher->where("id", backpack_user()->id);
                });
            });
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
        $this->crud->addFilter([
            'name' => 'name',
            'label' => 'Tên học viên',
            'type' => 'text',
        ], false, function ($value) {
            $this->crud->query->where("name", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'type' => 'text',
        ], false, function ($value) {
            $this->crud->query->where("phone", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'parent',
            'label' => 'Phụ huynh',
            'type' => 'text',
        ], false, function ($value) {
            $this->crud->query->where("parent", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'grade',
            'label' => 'Lớp đang học',
            'type' => 'text',
        ], false, function ($value) {
            $this->crud->query->whereHas("invoices", function (Builder $invoice) use ($value) {
                $invoice->whereHas("grade", function (Builder $grade) use ($value) {
                    $grade->where("name", "like", "%$value%");
                })->where("status", 0);
            });
        });
        $this->crud->disableResponsiveTable();
        CRUD::addColumn([
            'name' => 'code',
            'type' => 'text',
            'label' => 'Mã HV'
        ]);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Họ và tên',
            'wrapper' => [
                'href' => function ($crud, $column, $entry) {
                    return backpack_url("/student/$entry->id/show");
                },
            ]
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại'
        ]);
        CRUD::column("parent")->label("Phụ huynh");
        if (backpack_user()->role == "admin") {
            CRUD::column("staff")->label("Nhân viên quản lý");
        }
        CRUD::addColumn([
            'name' => 'curren_grade',
            'label' => 'Lớp đang học',
            'type' => 'model_function',
            'function_name' => 'CurrentGrade'
        ]);
//        CRUD::addColumn([
//            'name' => 'email',
//            'type' => 'email'
//        ]);
        CRUD::addColumn([
            'name' => 'current_status',
            'label' => 'Tình trạng lớp học',
            'type' => 'model_function',
            'function_name' => 'CurrentStatus'
        ]);
        if (in_array(backpack_user()->role, ["admin", "staff"])) {
            CRUD::addColumn([
                'name' => 'current_payment',
                'label' => 'Tình trạng học phí',
                'type' => 'model_function',
                'function_name' => 'CurrentPayment'
            ]);
        }

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
        $this->crud->getRelationFieldsWithPivot();
        Widget::add()->type('style')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css');
        Widget::add()->type('script')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js');
        CRUD::setValidation(StaffRequest::class);
        CRUD::addField([
            'name' => 'code',
            'label' => 'Mã học viên',
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Họ và tên'
        ]);
        CRUD::addField([
            'name' => 'birthday',
            'label' => 'Ngày sinh',
            'type' => 'date',
        ]);
        CRUD::addField([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại'
        ]);
        CRUD::addField([
            'name' => 'email',
            'type' => 'email'
        ]);
        CRUD::addField([
            'name' => 'address',
            'label' => 'Địa chỉ'
        ]);
        CRUD::addField([
            'name' => 'parent',
            'label' => 'Phụ huynh',
        ]);
        CRUD::addField([
            'name' => 'parent_phone',
            'label' => 'Số điện thoại phụ huynh',
            'type' => 'phone',
        ]);
        CRUD::addField([
            'name' => 'role',
            'type' => 'hidden',
            'value' => 'student'
        ]);
        if (in_array(backpack_user()->role, ["admin", "super"])) {
            CRUD::addField([
                'label' => 'Nhân viên',
                'name' => 'staff_id',
                'type' => 'select2',
            ]);
        }
        if (in_array(backpack_user()->role, ["staff"])) {
            CRUD::addField([
                'name' => 'staff_id',

                'type' => 'hidden',
                'value' => backpack_user()->id
            ]);
        }
        CRUD::addField([
            'name' => 'avatar',
            'type' => 'image',
            'crop' => true,
            'aspect_ratio' => 1,
            'label' => 'Ảnh đại diện'
        ]);
        CRUD::addField([
            'name' => 'password',
            'label' => 'Mật khẩu',
            'type' => 'password'
        ]);
        CRUD::field('origin')->type("hidden")->value(backpack_user()->origin);
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

    public function show($id)
    {
        return view("student.detail", ["entry" => $this->crud->getCurrentEntry()]);
    }
}

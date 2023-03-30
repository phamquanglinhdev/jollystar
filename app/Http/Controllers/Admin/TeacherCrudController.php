<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StaffRequest;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class TeacherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeacherCrudController extends UserCrudController
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
        CRUD::setModel(\App\Models\Teacher::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/teacher');
        CRUD::setEntityNameStrings('Giáo viên', 'Giáo viên');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'name' => 'code',
            'label' => 'Mã giáo viên',
            'type' => 'text'
        ], false, function ($value) {
            $this->crud->query->where("code", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'name',
            'label' => 'Tên giáo viên',
            'type' => 'text'
        ], false, function ($value) {
            $this->crud->query->where("name", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'email',
            'label' => 'Email giáo viên',
            'type' => 'text'
        ], false, function ($value) {
            $this->crud->query->where("email", "like", "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'type' => 'text'
        ], false, function ($value) {
            $this->crud->query->where("phone", "like", "%$value%");
        });
        CRUD::column('code')->label('Mã giáo viên');
        CRUD::column('name')->label('Tên giáo viên')->wrapper([
            'href' => function ($crud, $column, $entry) {
                return backpack_url("/teacher/$entry->id/show");
            },
        ]);
        parent::setupListOperation();
        CRUD::column('cv')->label('Hồ sơ')->type("link");
        CRUD::column('phone')->label('Số điện thoại')->type("phone");
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
        CRUD::setValidation(TeacherRequest::class);
        Widget::add()->type('style')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css');
        Widget::add()->type('script')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js');
        CRUD::setValidation(StaffRequest::class);
        CRUD::addField([
            'name' => 'code',
            'label' => 'Mã giáo viên',
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Tên giáo viên',
        ]);
        CRUD::addField([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'type' => 'phone'
        ]);
        CRUD::addField([
            'name' => 'email',
            'label' => 'Email',
        ]);
        CRUD::addField([
            'name' => 'facebook',
            'label' => 'Facebook',
        ]);
        CRUD::addField([
            'name' => 'address',
            'label' => 'Địa chỉ',
        ]);
        CRUD::addField([
            'name' => 'cv',
            'label' => 'Hồ sơ',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public'
        ]);
        CRUD::addField([
            'name' => 'extras',
            'label' => 'Thông tin thêm',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'name',
                    'label' => 'Tên'
                ],
                [
                    'name' => 'value',
                    'label' => 'Thông tin thêm'
                ]
            ],
            'new_item_label' => 'Thêm thông tin',
        ]);
        CRUD::addField([
            'name' => 'role',
            'type' => 'hidden',
            'value' => 'teacher'
        ]);
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
        return view("teacher.detail", ["entry" => $this->crud->getCurrentEntry()]);
    }
}

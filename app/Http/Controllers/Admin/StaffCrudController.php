<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StaffRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class StaffCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StaffCrudController extends UserCrudController
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
        CRUD::setModel(\App\Models\Staff::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/staff');
        CRUD::setEntityNameStrings('Nhân viên', 'Nhân viên');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addClause("where", "role", "staff");
        CRUD::addColumn([
            'name' => 'code',
            'label' => 'Mã nhân viên'
        ]);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên nhân viên'
        ]);
        CRUD::addColumn([
            'name' => 'job',
            'label' => 'Chức vụ'
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'Số điện thoại'
        ]);
        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email'
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        $this->crud->removeButton("show");
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StaffRequest::class);
        CRUD::addField([
            'name' => 'code',
            'label' => 'Mã nhân viên'
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Tên nhân viên'
        ]);
        CRUD::addField([
            'name' => 'job',
            'label' => 'Chức vụ'
        ]);
        CRUD::addField([
            'name' => 'phone',
            'label' => 'Số điện thoại'
        ]);
        CRUD::addField([
            'name' => 'email',
            'label' => 'Email'
        ]);
        CRUD::addField([
            'name' => 'password',
            'label' => 'Mật khẩu',
            'type' => 'password'
        ]);
        CRUD::field('role')->type("hidden")->value("staff");
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
}

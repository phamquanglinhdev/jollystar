<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\CheckIfAdmin;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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

        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addClause("where", "disable", "0");
        CRUD::addColumn([
            'name' => 'email',
            'type' => 'email'
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại'
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
        CRUD::setValidation(UserRequest::class);

        Widget::add()->type('style')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css');
        Widget::add()->type('script')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js');
        CRUD::setValidation(StaffRequest::class);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Họ và tên'
        ]);
        CRUD::addField([
            'name' => 'email',
            'type' => 'email'
        ]);
        CRUD::addField([
            'name' => 'phone',
            'type' => 'phone',
            'label' => 'Số điện thoại'
        ]);
        CRUD::addField([
            'name' => 'role',
            'type' => 'hidden',
            'value' => 'staff'
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
}

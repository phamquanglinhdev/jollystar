<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CaringRequest;
use App\Models\Caring;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class CaringCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CaringCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }

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
        CRUD::setModel(\App\Models\Caring::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/caring');
        CRUD::setEntityNameStrings('Nhật ký chăm sóc', 'Nhật ký chăm sóc');
        $this->crud->denyAccess(["list"]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('staff_id')->label("Nhân viên");
        CRUD::column('student_id')->label("Học sinh");
        CRUD::column('note')->label("Ghi chú");
        CRUD::column('created_at')->label("Thời gian tạo");

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
        CRUD::setValidation(CaringRequest::class);

        CRUD::field('staff_id')->type("hidden")->value(backpack_user()->id);
        CRUD::field('student_id')->label("Học sinh")->type("select2");
        CRUD::field('note')->label("Ghi chú")->type("textarea");
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

    protected function store()
    {
        $data = $this->crud->getRequest()->request;
        $item = [
            'staff_id' => $data->get("staff_id"),
            'student_id' => $data->get("student_id"),
            'note' => $data->get("note"),
            'origin' => $data->get("origin"),
            'date' => Carbon::parse($data->get('date')),
        ];
        if($item["note"]!=null){
           Caring::create($item);
        }
        return redirect()->back();
    }
}

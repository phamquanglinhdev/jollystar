<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('Chi khác', 'Chi khác');
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
            'type' => 'text',
            'name' => 'staff',
            'label' => 'Nhân viên'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $this->crud->query->whereHas("staff", function (Builder $builder) use ($value) {
                    $builder->where("name", "like", "%$value%");
                });
            });
        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Ngày bắt đầu'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->query->where('date', '>=', $dates->from);
                $this->crud->query->where('date', '<=', $dates->to);
            });
        $this->crud->disableResponsiveTable();
        CRUD::column('date')->label("Ngày chi");
        CRUD::column('name')->label("Nội dung chi");
        CRUD::column('value')->label("Số tiền")->suffix("đ")->type("number");
        CRUD::column('staff_id')->label("Nhân viên chi")->wrapper([
            'href' => function ($model, $column, $entry, $relation) {
                return backpack_url("/staff/$relation/show");
            }
        ]);
//        CRUD::column('accept_id')->label("Người duyệt")->wrapper([
//            'href' => function ($model, $column, $entry, $relation) {
//                return backpack_url("/staff/$relation/show");
//            }
//        ]);
        CRUD::column('partner')->label("Bên chi");
        CRUD::column('comment')->label("Diễn giải thêm");
        CRUD::column('attachment')->type("link")->label("Đính kèm");

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
        CRUD::setValidation(PaymentRequest::class);
        CRUD::field('date')->type("date")->label("Ngày chi")->default(Carbon::now()->isoFormat("YYYY-MM-DD"));
        CRUD::field('name')->label("Nội dung chi");
        CRUD::field('value')->label("Số tiền")->suffix("đ")->type("number");
        if (backpack_user()->role == "staff") {
            CRUD::field('staff_id')->type("hidden")->value(backpack_user()->id);
            CRUD::field('accept_id')->type("select2")->label("Người duyệt");
        } else {
            CRUD::field('staff_id')->type("select2")->label("Nhân viên chi");
            CRUD::field('accept_id')->type("select2")->label("Người duyệt");
        }
        CRUD::field('origin')->type("hidden")->value(backpack_user()->origin);
        CRUD::field('partner')->label("Bên chi");
        CRUD::field('comment')->label("Diễn giải thêm")->type("textarea");
        CRUD::addField([
            'name' => 'attachment',
            'type' => 'upload',
            'label' => 'Đính kèm',
            'upload' => true,
            'disk' => 'public'
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
}

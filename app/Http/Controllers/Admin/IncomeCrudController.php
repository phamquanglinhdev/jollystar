<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IncomeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


/**
 * Class IncomeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IncomeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Income::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/income');
        CRUD::setEntityNameStrings('Thu khác', 'Danh sách thu khác');
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
        CRUD::column('date')->label("Ngày thu");
        CRUD::column('name')->label("Nội dung thu");
        CRUD::column('value')->label("Số tiền")->suffix("đ")->type("number");
        CRUD::column('staff_id')->label("Nhân viên thu")->wrapper([
            'href' => function ($model, $column, $entry, $relation) {
                return backpack_url("/staff/$relation/show");
            }
        ]);
        CRUD::column("partner")->label("Bên thu");
        CRUD::column("comment")->label("Diễn giải thêm");
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
        CRUD::setValidation(IncomeRequest::class);
        CRUD::field('date')->type("date")->label("Ngày thu")->default(Carbon::now()->isoFormat("YYYY-MM-DD"));
        CRUD::field('name')->label("Nội dung thu");

        if (backpack_user()->role == "staff") {
            CRUD::field('staff_id')->type("hidden")->value(backpack_user()->id);
        } else {
            CRUD::field('staff_id')->type("select2")->label("Nhân viên thu");
        }
        CRUD::field('value')->label("Số tiền")->suffix("đ")->type("number");
        CRUD::field('partner')->label("Bên thu");
        CRUD::field('comment')->label("Diễn giải thêm")->type("textarea");
        CRUD::addField([
            'name' => 'attachment',
            'type' => 'upload',
            'label' => 'Đính kèm',
            'upload' => true,
            'disk' => 'public'
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

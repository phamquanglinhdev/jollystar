<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TeacherSalaryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TeacherSalaryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeacherSalaryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\TeacherSalary::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/teacher-salary');
        CRUD::setEntityNameStrings('Lương giáo viên', 'Lương giáo viên');
        $this->crud->denyAccess(["create", "update", "delete", "show"]);
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
            'label' => 'Giáo viên'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $this->crud->query->whereHas("teacher", function (Builder $builder) use ($value) {
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
        CRUD::column('teacher')->label("Giáo viên");
        CRUD::column('grade_id')->label("Lớp");
        CRUD::column('no')->label("Buổi học");
        CRUD::column('date')->label("Ngày")->type("date");
        CRUD::column('start')->label("Bắt đầu");
        CRUD::column('end')->label("Kết thúc");
        CRUD::column('salary_per_hour')->label("Lương theo giờ")->type("number")->suffix("đ");
        CRUD::column('salary_column')->label("Lương buổi học")->type("model_function")->suffix("đ")->function_name("salary");


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
        CRUD::setValidation(TeacherSalaryRequest::class);

        CRUD::field('attachments');
        CRUD::field('date');
        CRUD::field('end');
        CRUD::field('grade_id');
        CRUD::field('lesson');
        CRUD::field('no');
        CRUD::field('origin');
        CRUD::field('question');
        CRUD::field('salary_per_hour');
        CRUD::field('start');
        CRUD::field('students');
        CRUD::field('teacher_comment');
        CRUD::field('teacher_id');
        CRUD::field('video');

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

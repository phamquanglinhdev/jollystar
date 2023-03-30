<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Course::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/course');
        CRUD::setEntityNameStrings('Khóa học', 'Danh sách khóa học');
        if (backpack_user()->role == "teacher") {
            $this->crud->denyAccess(["list", "show", "create", "update", "delete"]);
        }
        if (backpack_user()->role == "student") {
            $this->crud->query->whereHas("students", function (Builder $builder) {
                $builder->where("id", backpack_user()->id);
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
    protected function setupListOperation()
    {
        $this->crud->removeButton("show");

        CRUD::column('name')->label("Tên khóa học")->wrapper(
            [
                'href' => function ($crud, $column, $entry) {
                    return backpack_url("/course/$entry->id/show");
                }
            ]
        );

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
        CRUD::setValidation(CourseRequest::class);

        CRUD::field('origin')->type("hidden")->value(backpack_user()->origin);
        CRUD::field('name')->label("Tên khóa học");
        CRUD::field('description')->label("Giới thệu")->type("summernote");
        CRUD::addField([
            'new_item_label' => 'Thêm bài học', // customize the text of the button
            'init_rows' => 1, //
            'name' => 'lessons',
            'label' => 'Nội dung',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'unit',
                    'label' => 'Bài học'
                ],
                [
                    'name' => 'doc',
                    'label' => 'Nội dung',
                ],
                [
                    'name' => 'video',
                    'label' => 'Video',
                    'type' => 'browse',
                ],
            ]
        ]);
        CRUD::addField([
            'name' => 'students',
            'label' => 'Học sinh',
            'type' => 'relationship',
            'pivot' => true,
            'entity' => 'Students',
            'model' => 'App\Models\Student',
            'attribute' => 'name',
            'options' => function ($query) {
                if (backpack_user()->role == "staff") {
                    return $query->where("staff_id", backpack_user()->id);
                } else {
                    return $query;
                }
            },
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

    public function show($id)
    {
        return view("course.detail", ["course" => $this->crud->getCurrentEntry()]);
    }
}

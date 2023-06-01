<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use App\Models\Bag;
use App\Models\Book;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Book::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/book');
        CRUD::setEntityNameStrings('book', 'books');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
//    protected function setupListOperation()
//    {
//        CRUD::column('name');
//        CRUD::column('bag_id');
//        CRUD::column('thumbnail');
//        CRUD::column('url');
//        CRUD::column('created_at');
//        CRUD::column('updated_at');
//
//        /**
//         * Columns can be defined using the fluent syntax or array syntax:
//         * - CRUD::column('price')->type('number');
//         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
//         */
//    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BookRequest::class);

        CRUD::addField([
            'name' => 'bag_id',
            'type' => 'select2',
            'model' => 'App\Models\Bag',
            'entity' => 'Bag',
            'attribute' => 'name',
            'label' => 'Danh mục',
        ]);
        CRUD::field('name')->label("Tên sách");
        CRUD::field('description')->label("Mô tả");
        CRUD::field('thumbnail')->label("Ảnh")->type("image")->crop(true)->aspect_ratio(1907 / 2560);
        CRUD::field('url');

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

    protected function index($id = null): View
    {
        if (!$id) {
            $bags = new \stdClass();
            $bags->children = Bag::where("parent_id", null)->get();
            $bags->name = "Danh mục sách";
            $bags->books = [];
            return view("bag.list", ["bags" => $bags]);
        }
        return view("bag.list", ["bags" => Bag::where("id", $id)->first()]);
    }

    protected function destroy($id): RedirectResponse
    {
        Book::query()->where("id", $id)->delete();
        return redirect()->back();
    }
}

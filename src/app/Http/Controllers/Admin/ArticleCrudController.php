<?php

namespace Backpack\News\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\News\app\Http\Requests\ArticleRequest as StoreRequest;
use Backpack\News\app\Http\Requests\ArticleRequest as UpdateRequest;

class ArticleCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("Backpack\News\app\Models\Article");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'Ảnh',
            'lable' => 'Trạng thái',
            'type'        => 'model_function',
            'function_name' => 'getImage'
        ]);
        $this->crud->addColumn([
                                'name' => 'title',
                                'label' => 'Title',
                                'type'        => 'model_function',
                                'function_name' => 'getLink'
                            ]);
//        $this->crud->addColumn([
//                                'name' => 'featured',
//                                'label' => 'Featured',
//                                'type' => 'check',
//                            ]);
        $this->crud->addColumn([
            'name' => 'date',
            'label' => 'Date',
            'type' => 'date',
//            'type'        => 'model_function',
//            'function_name' => 'getDate'
        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type'        => 'model_function',
            'function_name' => 'getStatus'
        ]);
        $this->crud->addColumn([
                                'label' => 'Category',
                                'type' => 'select',
                                'name' => 'category_id',
                                'entity' => 'category',
                                'attribute' => 'name',
                                'model' => "App\Models\Category",
                            ]);

        // ------ CRUD FIELDS
        $this->crud->addField([    // TEXT
                                'name' => 'title',
                                'label' => 'Title',
                                'type' => 'text',
                                'placeholder' => 'Your title here',
                                'tab' => 'Info'
                            ]);
        $this->crud->addField([
                                'name' => 'slug',
                                'label' => 'Slug (URL)',
                                'type' => 'text',
                                'hint' => 'Will be automatically generated from your title, if left empty.',
                                // 'disabled' => 'disabled',
                                'tab' => 'Info'
                            ]);

        $this->crud->addField([    // TEXT
                                'name' => 'date',
                                'label' => 'Date',
                                'type' => 'date',
                                'value' => date('Y-m-d'),
                                'tab' => 'Info'
                            ], 'create');
        $this->crud->addField([    // TEXT
                                'name' => 'date',
                                'label' => 'Date',
                                'type' => 'date',
                                'tab' => 'Info'
                            ], 'update');

        $this->crud->addField([    // WYSIWYG
                                'name' => 'content',
                                'label' => 'Content',
                                'type' => 'ckeditor',
                                'placeholder' => 'Your textarea text here',
                                'tab' => 'Content'
                            ]);
        $this->crud->addField([    // Image
                                'name' => 'image',
                                'label' => 'Image',
                                'type' => 'browse',
                                'tab' => 'Content'
                            ]);
        $this->crud->addField([    // SELECT
                                'label' => 'Category',
                                'type' => 'select2',
                                'name' => 'category_id',
                                'entity' => 'category',
                                'attribute' => 'text_name',
                                'model' => "App\Models\Category",
                                'tab' => 'Content'
                            ]);
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
                                'label' => 'Tags',
                                'type' => 'select2_multiple',
                                'name' => 'tags', // the method that defines the relationship in your Model
                                'entity' => 'tags', // the method that defines the relationship in your Model
                                'attribute' => 'name', // foreign key attribute that is shown to user
                                'model' => "App\Models\Tag", // foreign key model
                                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                                'tab' => 'Content'
                            ]);
        $this->crud->addField([    // ENUM
                                'name' => 'status',
                                'label' => 'Status',
                                'type' => 'enum',
                                'tab' => 'Content'
                            ]);
        $this->crud->addField([    // CHECKBOX
                                'name' => 'featured',
                                'label' => 'Featured item',
                                'type' => 'checkbox',
                                'tab' => 'Content'
                            ]);

        $this->crud->enableAjaxTable();
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}

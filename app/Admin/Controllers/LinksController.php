<?php

namespace App\Admin\Controllers;

use App\Link;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class LinksController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Links');
            $content->description('Resources for the ruins');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Links');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Links');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Link::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('description');
            $grid->column('url');
            $grid->column('language')->sortable();
            $grid->ruin('Ruin')->display(function ($ruin) {
                return "<span class='label label-warning'>{$ruin['name']}</span>";
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Link::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('description', 'Description');
            $form->text('url', 'URL');
            $form->radio('language', 'Language')->options(['en' => 'EN', 'tr' => 'TR'])->default('tr');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

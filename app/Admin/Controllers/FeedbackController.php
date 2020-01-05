<?php

namespace App\Admin\Controllers;

use App\Feedback;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class FeedbackController extends Controller
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
            $content->header('Feedback');

            $content->body($this->grid());
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
            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Feedback::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->column('ruin');
            $grid->column('body');
            $grid->created_at()->sortable();

            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });

            $grid->filter(function ($filter) {
                $filter->like('ruin', 'Ruin');
                $filter->like('body', 'Feedback contains...');
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
        return Admin::form(Feedback::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

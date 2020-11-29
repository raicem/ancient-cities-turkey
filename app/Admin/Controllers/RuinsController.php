<?php

namespace App\Admin\Controllers;

use App\City;
use App\Ruin;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class RuinsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Ruins');

            $content->body($this->grid());
        });
    }

    public function edit($slug)
    {
        return Admin::content(function (Content $content) use ($slug) {
            /** @var Ruin $ruin */
            $ruin = Ruin::where(['slug' => $slug])->first();
            $content->header($ruin->name);
            $content->body($this->form()->edit($ruin->id));
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
            $content->header('Create New');

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
        return Admin::grid(Ruin::class, function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();

            $grid->column('name')->sortable();
            $grid->column('name_tr')->sortable();
            $grid->column('links', 'Links')->display(function ($link) {
                $count = count($link);
                return "<span class='label label-warning'>{$count}</span>";
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name', 'Name');
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
        return Admin::form(Ruin::class, function (Form $form) {
            $form->tab('Main Info', function ($form) {
                $form->text('name', 'Name EN');
                $form->text('name_tr', 'Name TR');

                $form->textarea('information', 'Info EN');
                $form->textarea('information_tr', 'Info TR');

                $form->image('image')->move('img/ruins');

                $form->text('latitude', 'Latitude');
                $form->text('longitude', 'Longitude');

                /* @phpstan-ignore-next-line */
                $form->select('city_id', 'City')->options(City::all()->pluck('name', 'id'));

                $form->text('tripadvisor', 'Tripadvisor');
                $form->text('foursquare', 'Foursquare');

                $form->radio('official_site', 'Official Site')->options([
                    0 => 'No',
                    1 => 'Yes'
                ])->default(0);

                $form->text('official_site_en', 'Official Site EN');
                $form->text('official_site_tr', 'Official Site TR');
            })->tab('Links', function ($form) {
                $form->hasMany('links', function (Form\NestedForm $form) {
                    $form->text('description', 'Description');
                    $form->url('url', 'URL');
                    $form->radio('language', 'Language')->options([
                        'en' => 'EN',
                        'tr' => 'TR'
                    ])->default('tr');
                });
            });
        });
    }
}

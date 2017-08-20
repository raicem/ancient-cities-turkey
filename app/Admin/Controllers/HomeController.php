<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Link;
use App\Ruin;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Panel');

            $number['ruins'] = Ruin::all()->count();
            $number['links'] = Link::all()->count();
            $number['withInfo'] = Ruin::where('information_tr', '!=', null)->count();
            $number['percentage'] = ceil($number['withInfo'] / $number['ruins'] * 100);

            $content->row(function ($row) use ($number) {
                $row->column(
                    3,
                    new InfoBox(
                        'Ruins',
                        'university',
                        'aqua',
                        '/admin/ruins',
                        $number['ruins']
                    )
                );
                $row->column(
                    3,
                    new InfoBox(
                        'Links',
                        'link',
                        'green',
                        '/admin/links',
                        $number['links']
                    )
                );
                $row->column(
                    3,
                    new InfoBox(
                        'Information Completed',
                        'info',
                        'yellow',
                        '/admin/ruins',
                        '%' . $number['percentage']
                    )
                );
            });
        });
    }
}

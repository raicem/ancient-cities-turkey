<?php

namespace App\Admin\Controllers;

use App\Ruin;
use App\Link;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
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
                    new InfoBox('Ruins', 'university', 'aqua', '/admin/ruins', $number['ruins'])
                );
                $row->column(
                    3,
                    new InfoBox('Links', 'link', 'green', '/admin/links', $number['links'])
                );
                $row->column(
                    3,
                    new InfoBox(
                        'Links Per Ruin (>4 is OK)',
                        'link',
                        'red',
                        '/admin/ruins',
                        round($number['links'] / $number['ruins'], 1)
                    )
                );
                $row->column(
                    3,
                    new InfoBox(
                        'Short Info Completed',
                        'info',
                        'yellow',
                        '/admin/ruins',
                        '%' . $number['percentage']
                    )
                );
                $row->column(
                    3,
                    new InfoBox(
                        'Target',
                        'info',
                        'yellow',
                        '/admin/ruins',
                        $number['ruins'] . '/140'
                    )
                );
            });
        });
    }
}

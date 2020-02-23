<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\User;
use App\Visitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $visitsCount = 0;
        $onlineCount= 0;
        $pageCount = 0;
        $userCount = 0;

        // contagem de visitas
        $visitsCount = Visitor::count();

        // contagem de usuarios online
        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupBy('ip')->get();
        $onlineCount = count($onlineList);

        // contagem de paginas
        $pageCount = Page::count();

        // contagem de usuario
        $userCount = User::count();

        // contagem para o PagePie
        $pagePie = [];
        $visitsAll = Visitor::selectRaw('page, count(page) as c')->groupBy('page')->get();
        foreach($visitsAll as $visit){
            $pagePie[ $visit['page'] ] = intval($visit['c']);
        }

        $pageLabels = json_encode( array_keys($pagePie) );
        $pageValues = json_encode( array_values($pagePie) );

        return view('admin.home', [
            'visitsCount' => $visitsCount,
            'onlineCount' => $onlineCount,
            'pageCount' => $pageCount,
            'userCount' => $userCount,
            'pageLabels' => $pageLabels,
            'pageValues' => $pageValues
        ]);
    }
}

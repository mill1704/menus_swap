<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Menu;
use App\Models\Menu_translations;

class MenuController extends Controller
{
    public function index()
    {
        $menus = DB::table('menus')
        ->join('menu_translations', 'menu_translations.menu_id', '=', 'menus.id')
        ->orderBy('menus.order_column')
        ->where('menu_translations.locale', 'th')
        ->get();

        $menu_data = [
            'level1' => [],
            'level2' => [],
        ];

        if ($menus->count() > 0) {    
            foreach ($menus as $menu) {
                if ($menu->level == 1) {
                    $menu_data['level1'][$menu->id] = $menu;
                } elseif ($menu->level == 2) {
                    $menu_data['level2'][$menu->parent_id][] = $menu;
                }
            }
        }

        // dd($menu_data);
        return view('content', compact('menu_data'));
    } 

    public function store(Request $req) {
        $req->validate([
            'parent_id', 'order_column'
        ]);

        $menu->create($req->all());
        return redirect()->route('/');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\AtlantisCustomMenu;

class AtlantisSidebarMenu
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        $config = config('menu.items', []);
        $childrenConfig = config('menu.children', []);

        $items = [];

        foreach ($config as $item) {
            switch ($item['type']) {
                case 'header':
                    $items[] = $item;
                    break;

                case 'menu':
                    $items[] = [
                        'type' => 'menu',
                        'title' => $item['title'],
                        'url' => route($item['route']),
                        'icon' => $item['icon'] ?? '',
                        'isActive' => request()->routeIs($item['route']),
                    ];
                    break;

                case 'submenu':
                    $children = [];

                    if (isset($item['children'], $childrenConfig[$item['children']])) {
                        foreach ($childrenConfig[$item['children']] as $child) {
                            $children[] = [
                                'title' => $child['title'],
                                'url' => route($child['route']),
                                'isActiveHas' => request()->routeIs($child['route']),
                            ];
                        }
                    }

                    $items[] = [
                        'type' => 'submenu',
                        'title' => $item['title'],
                        'icon' => $item['icon'] ?? '',
                        'isActive' => request()->routeIs($item['isActive']),
                        'children' => $children,
                    ];
                    break;
            }
        }

        // Renderizar menú HTML
        $sidebarHtml = AtlantisCustomMenu::render($items);
        view()->share('atlantisSidebarMenu', $sidebarHtml);

        return $next($request);
    }
}

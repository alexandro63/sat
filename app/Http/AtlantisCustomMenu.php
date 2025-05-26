<?php

namespace App\Http;

use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Illuminate\Support\Str;
use Spatie\Menu\Laravel\Menu;

class AtlantisCustomMenu
{
    public static function render(array $items): string
    {
        $menu = Menu::new()
            ->addClass('nav nav-danger')
            ->setActiveClassOnParent();
        // No duplique la clase "active" en el <a>
        // ->setActiveClassOnLink(false);

        foreach ($items as $item) {
            switch ($item['type'] ?? 'item') {
                case 'header':
                    $menu->add(Html::raw('<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="' . e($item['icon']) . '"></i>
							</span>
							<h4 class="text-section">' . e($item['title']) . '</h4>
						</li>'));
                    break;

                case 'menu':
                    $menu->add(
                        Html::raw(
                            '<li class="nav-item' . ($item['isActive'] ? ' active' : '') . '">
                            <a href="' . e($item['url']) . '">
                                <i class="' . e($item['icon']) . '"></i>
                                <p>' . e($item['title']) . '</p>
                            </a>
                        </li>'
                        )
                    );
                    break;
                case 'submenu':
                    $id = Str::slug($item['title']);
                    $hasActiveChild = collect($item['children'])
                        ->pluck('isActiveHas')
                        ->contains(true);

                    $menu->add(Html::raw(
                        '<li class="nav-item' . (($item['isActive'] || $hasActiveChild) ? ' active' : '') . '">
                            <a
                                data-toggle="collapse"
                                href="#' . $id . '"
                                aria-expanded="' . ($hasActiveChild ? 'true' : 'false') . '"
                                class="' . ($hasActiveChild ? '' : 'collapsed') . '"
                            >
                                <i class="' . e($item['icon']) . '"></i>
                                <p>' . e($item['title']) . '</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse' . ($hasActiveChild ? ' show' : '') . '" id="' . $id . '">
                                <ul class="nav nav-collapse">' .
                            collect($item['children'])->map(function ($child) {
                                return '<li class="' . ($child['isActiveHas'] ? ' active' : '') . '">
                                            <a href="' . e($child['url']) . '">
                                                <span class="sub-item">' . e($child['title']) . '</span>
                                            </a>
                                        </li>';
                            })->implode('') .
                            '</ul>
                            </div>
                        </li>'
                    ));
                    break;
                default:
                    $menu->add(Html::raw(
                        '<li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section"> SIN MENU DEFINIDO</h4>
                        </li>'
                    ));
                    break;
            }
        }

        return $menu;
    }
}

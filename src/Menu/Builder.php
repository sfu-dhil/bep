<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\ItemInterface;
use Nines\UtilBundle\Menu\AbstractBuilder;

/**
 * Class to build some menus for navigation.
 */
class Builder extends AbstractBuilder {
    public function mainMenu(array $options) : ItemInterface {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes([
            'class' => 'nav navbar-nav',
        ]);

        $browse = $menu->addChild('Browse', [
            'uri' => '#',
            'label' => 'Browse',
            'attributes' => [
                'class' => 'nav-item dropdown',
            ],
            'linkAttributes' => [
                'class' => 'nav-link dropdown-toggle',
                'role' => 'button',
                'data-bs-toggle' => 'dropdown',
                'id' => 'browse-dropdown',
            ],
            'childrenAttributes' => [
                'class' => 'dropdown-menu text-small shadow dropdown-menu-end',
                'aria-labelledby' => 'browse-dropdown',
            ],
        ]);
        $browse->addChild('Archdeaconries & Courts', [
            'route' => 'archdeaconry_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Archives', [
            'route' => 'archive_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Books', [
            'route' => 'book_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Counties', [
            'route' => 'county_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Dioceses', [
            'route' => 'diocese_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Injunctions', [
            'route' => 'injunction_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Inventories', [
            'route' => 'inventory_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Manuscript Sources', [
            'route' => 'manuscript_source_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Monarchs', [
            'route' => 'monarch_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Nations', [
            'route' => 'nation_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Parishes', [
            'route' => 'parish_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Print Sources', [
            'route' => 'print_source_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Provinces', [
            'route' => 'province_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Towns', [
            'route' => 'town_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Transactions', [
            'route' => 'transaction_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);
        $browse->addChild('Surviving Texts', [
            'route' => 'holding_index',
            'linkAttributes' => [
                'class' => 'dropdown-item link-dark',
            ],
        ]);

        if ($this->hasRole('ROLE_CONTENT_ADMIN')) {
            $browse->addChild('divider1', [
                'label' => '',
                'attributes' => [
                    'role' => 'separator',
                    'class' => 'divider',
                ],
            ]);
            $browse->addChild('Formats', [
                'route' => 'format_index',
                'linkAttributes' => [
                    'class' => 'dropdown-item link-dark',
                ],
            ]);
            $browse->addChild('Source Categories', [
                'route' => 'source_category_index',
                'linkAttributes' => [
                    'class' => 'dropdown-item link-dark',
                ],
            ]);
            $browse->addChild('Transaction Categories', [
                'route' => 'transaction_category_index',
                'linkAttributes' => [
                    'class' => 'dropdown-item link-dark',
                ],
            ]);
        }

        return $menu;
    }
}

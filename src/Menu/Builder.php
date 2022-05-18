<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Menu;

use Knp\Menu\ItemInterface;
use Nines\UtilBundle\Menu\AbstractBuilder;

/**
 * Class to build some menus for navigation.
 */
class Builder extends AbstractBuilder {
    /**
     * Build a menu for navigation.
     *
     * @return ItemInterface
     */
    public function mainMenu(array $options) {
        $menu = $this->dropdown('Browse');
        $menu->addChild('Archdeaconries & Courts', ['route' => 'archdeaconry_index']);
        $menu->addChild('Archives', ['route' => 'archive_index']);
        $menu->addChild('Books', ['route' => 'book_index']);
        $menu->addChild('Counties', ['route' => 'county_index']);
        $menu->addChild('Dioceses', ['route' => 'diocese_index']);
        $menu->addChild('Injunctions', ['route' => 'injunction_index']);
        $menu->addChild('Inventories', ['route' => 'inventory_index']);
        $menu->addChild('Monarchs', ['route' => 'monarch_index']);
        $menu->addChild('Nations', ['route' => 'nation_index']);
        $menu->addChild('Parishes', ['route' => 'parish_index']);
        $menu->addChild('Provinces', ['route' => 'province_index']);
        $menu->addChild('Sources', ['route' => 'source_index']);
        $menu->addChild('Towns', ['route' => 'town_index']);
        $menu->addChild('Transactions', ['route' => 'transaction_index']);
        $menu->addChild('Surviving Texts', ['route' => 'holding_index']);

        if ($this->hasRole('ROLE_CONTENT_ADMIN')) {
            $this->addDivider($menu);
            $menu->addChild('Formats', ['route' => 'format_index']);
            $menu->addChild('Source Categories', ['route' => 'source_category_index']);
            $menu->addChild('Transaction Categories', ['route' => 'transaction_category_index']);
        }

        return $menu;
    }

    /**
     * Build a menu for navigation.
     *
     * @return ItemInterface
     */
    public function footerMenu(array $options) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes([
            'class' => 'nav navbar-nav',
        ]);

        $menu->addChild('Home', [
            'route' => 'homepage',
        ]);
        $menu->addChild('Privacy', [
            'route' => 'privacy',
        ]);
        $menu->addChild('GitHub', [
            'uri' => 'https://github.com/sfu-dhil/bep',
        ]);

        return $menu;
    }
}

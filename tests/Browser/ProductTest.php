<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Homepage;
use Tests\Browser\Pages\ProductPage;
use Tests\Traits\RefreshDatabaseWithSeeds;

class ProductTest extends DuskTestCase
{
    use RefreshDatabaseWithSeeds;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCanVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs('admin@example.com');
            // /$browser->login();
            $browser->visit(route('dashboard', [], false))
                ->waitForText('Products');
            $browser->clickLink('Products')
                ->waitForLocation(route('product.index', [], false));
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs('1');
            $browser->visit(new ProductPage)->clickLink('Your Products');
            //dd($browser->vueAttribute('@vue-product', 'productlist'));
            $browser->assertVueIsNot('productlist.total', 0, '@vue-product');
        });
    }
}

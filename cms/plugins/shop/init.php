<?php defined('SYSPATH') or die('No direct access allowed.');

$plugin = Model_Plugin_Item::factory( array(
	'id' => 'shop',
	'title' => 'Simple Shop',
	'description' => 'Simple way to get little shop on your website',
	'version' => '1.0.0',
) )->register();

if($plugin->enabled())
{
	
	Route::set( 'shop', ADMIN_DIR_NAME.'/shop(/<controller>(/<action>(/<id>)))')
       ->defaults( array(
		   'directory' => 'shop',
           'controller' => 'category',
           'action' => 'index'
       ) );
	
	Route::set( 'shopping_cart', 'shop(/<controller>(/<action>(/<id>)))')
       ->defaults( array(
		   'directory' => 'shop',
           'controller' => 'cart',
           'action' => 'index'
       ) );
	
	
	//Observer::observe( 'shopping_cart', 'enable_shopping_cart', $plugin );
	
	Behavior::add('shop', 'shop/shop.php');
	
	if(IS_BACKEND)
	{
		// Add navigation section
		Model_Navigation::add_section('Simple Shop', 'Item categories', 'shop/category', array('administrator'), 999);
		Model_Navigation::add_section('Simple Shop', 'Items', 'shop/item', array('administrator'), 999);
	}
}

function enable_shopping_cart($plugin)
{
	echo View::factory( 'shop/cart', array(
		'plugin' => $plugin
	) );
}
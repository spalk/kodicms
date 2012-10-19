<?php defined('SYSPATH') or die('No direct access allowed.');

class PageShop extends FrontPage
{
	protected function setUrl()	{}

	public function title() {}

	public function breadcrumb() {}
	
}
class Shop
{
    public function __construct(&$page, $params)
    {
        $this->page =& $page;
        $this->params = $params;
	}
	
	public function items()
	{
		return $items = ORM::factory('shop_item')->find_all();
	}
	
	public function items_in_cart()
	{
		$session = Session::instance();
		$post_items = $session->get('orders');
		
		if ($post_items)
		{
			$ids = $this->ids_in_cart();
			
			$items = ORM::factory('shop_item')
			->where('id', 'IN', $ids)
			->find_all();
			return $items;
		}
		else
		{
			return null;
		}
		
	}
	
	public function items_amount()
	{
		$session = Session::instance();
		$post_items = $session->get('orders');
		return $post_items;
	}
	
	public function ids_in_cart()
	{
		$session = Session::instance();
		$items = $session->get('orders');
		
		if ($items)
		{
			$ids = array_keys($items);
			return $ids;
		}
		else
		{
			return array();
		}
	}
}

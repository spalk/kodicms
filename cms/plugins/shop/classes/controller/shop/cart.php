<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Shop_Cart extends Controller_System_Plugin {
	
	public $plugin_id = 'shop';

	public function action_index()
	{
		$session = Session::instance();
		$items_ids = $session->get('orders');
		
		$items = ORM::factory('shop_item')
			->where('id', 'IN', $items_ids)
			->find_all();
		
		$this->template->content = View::factory('shop/cart', array(
			'items' => $items,
		));
	}
	
	public function action_add()
	{
		$item = Arr::get($_POST, 'item');
		
		$session = Session::instance()->get('orders');
		$session[$item['id']] = $item['amount'];
		
		if($item['amount'] == 0)
		{
			unset($session[$item['id']]);
		}
		
		Session::instance()->set('orders', $session);
		
		$this->go('store');
		
	}
	
	public function action_recount()
	{
		$item = Arr::get($_POST, 'item');
		
		$arr = array();
		
		foreach ($item as $id => $value)
		{
			$arr[$id] = $value;
			
			if ($value == 0)
			{
				unset($arr[$id]);
			}
		}
		
		Session::instance()->set('orders', $arr);

		$this->go('shopping-cart');
	}
	
}
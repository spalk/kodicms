<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Shop_Category extends Controller_System_Plugin {
	
	public $plugin_id = 'shop';
	
	public function action_index() 
	{
		$categories = ORM::factory('shop_category')->find_all();
		
		$this->template->content = View::factory('shop/category/index', array(
			'categories' => $categories
		));
	}
	
	public function action_add() 
	{
		$category = ORM::factory('shop_category');
		
		if ($this->request->method() === Request::POST)
		{
			$this->auto_render = FALSE;
			return $this->_add($category);
		}
		
		$this->template->content = View::factory('shop/category/add', array(
			'category' => $category
		));
	}
	
	private function _add($category)
	{
		
		$category_post = Arr::get($_POST, 'category');
		$category->values($category_post);
		$category->save();
		$this->go('shop/item/index');
		return;
	}
	
	public function action_edit() 
	{
		$category_id = (int) $this->request->param('id');
		
		$category = ORM::factory('shop_category', $category_id);
		
		
		if ( $this->request->method() === Request::POST )
		{
			$this->auto_render = FALSE;
			$category_post = Arr::get($_POST, 'category');
			$category->values($category_post);
			$category->save();
			$this->go('shop/category/index');
			return;
		}
		
		
		$this->template->content = View::factory('shop/category/add', array(
			'category' => $category
		));
		
	}
	
	public function action_del() 
	{
		$category_id = (int) $this->request->param('id');
		$category = ORM::factory('shop_category', $category_id);
		$category->delete();
		$this->go('shop/category/index');
		return;
	}
}
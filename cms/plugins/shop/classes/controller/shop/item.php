<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Shop_Item extends Controller_System_Plugin {
	
	public $plugin_id = 'shop';
	
	public function action_index() 
	{
		$categories = ORM::factory('shop_category')->find_all();
		
		$cat_array = array();
		foreach ($categories as $c)
		{
			$cat_array[$c->id] = $c->name;
		}
		
		$items = ORM::factory('shop_item');
		
		$cur_cat_id = null;
		if ($this->request->query('category_id'))
		{
			$cur_cat_id = $this->request->query('category_id');
			$items->where('category', '=', $cur_cat_id);
		}
		
		$this->template->content = View::factory('shop/item/index', array(
			'items' => $items->find_all(),
			'categories' => $cat_array,
			'cur_cat_id' => $cur_cat_id
		));
	}
	
	
	public function action_add() 
	{
		$item = ORM::factory('shop_item');
		
		$categories = ORM::factory('shop_category')->find_all();
		$cat_array = array();
		foreach ($categories as $c)
		{
			$cat_array[$c->id] = $c->name;
		}
		
		if ($this->request->method() === Request::POST)
		{
			$this->auto_render = FALSE;
			return $this->_add($item);
		}
		
		$this->template->content = View::factory('shop/item/add', array(
			'item' => $item,
			'categories' => $cat_array
		));
	}
	
	
	private function _add($item)
	{
		$item_post = Arr::get($_POST, 'item');
		if (!isset($item_post['status']))
		{
			$item_post['status'] = 0;
		}
		
		print_r($_FILES);
		
		if (isset($_FILES['foto']))
		{
			$filename = $this->_save_image($_FILES['foto']);
			$item_post['img_name'] = $filename;
		}
		
		$item->values($item_post);
		$item->save();
		$this->go('shop/item/index');
		return;
	}
	
	private function _save_image($image)
    {
        if (
            ! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg')))
        {
            return FALSE;
        }
 
        $directory = DOCROOT.'public/shop/items/';
		
		if(!is_dir($directory))
		{
			 mkdir(DOCROOT.'public/shop/', 0777);
			 mkdir(DOCROOT.'public/shop/items/', 0777);
			 mkdir(DOCROOT.'public/shop/items/big/', 0777);
			 mkdir(DOCROOT.'public/shop/items/normal/', 0777);
			 mkdir(DOCROOT.'public/shop/items/thmb/', 0777);
		}
		
        if ($file = Upload::save($image, NULL, $directory))
        {
            $filename = strtolower(Text::random('alnum', 20)).'.jpg';
 
            Image::factory($file)
                ->resize(800, 800, Image::AUTO)
                ->save($directory.'big/'.$filename);
			
			Image::factory($file)
                ->resize(180, 180, Image::AUTO)
                ->save($directory.'normal/'.$filename);
 
			Image::factory($file)
                ->resize(80, 80, Image::AUTO)
                ->save($directory.'thmb/'.$filename);


			// Delete the temporary file
            unlink($file);
			
            return $filename;
        }
 
        return FALSE;
    }
	
	
	public function action_edit() 
	{
		$item_id = (int) $this->request->param('id');
		$item = ORM::factory('shop_item', $item_id);
		
		$categories = ORM::factory('shop_category')->find_all();
		$cat_array = array();
		$cat_array[0] = _('Select category');
		foreach ($categories as $c)
		{
			$cat_array[$c->id] = $c->name;
		}
		
		
		if ( $this->request->method() === Request::POST )
		{
			$this->auto_render = FALSE;
			return $this->_edit($item);
		}
		
		
		$this->template->content = View::factory('shop/item/add', array(
			'item' => $item,
			'categories' => $cat_array
		));
	}
	
	private function _edit($item)
	{
		$item_post = Arr::get($_POST, 'item');
		if (!isset($item_post['status']))
		{
			$item_post['status'] = 0;
		}
		if (isset($_FILES['foto']))
		{
			$filename = $this->_edit_image($_FILES['foto'], $item);
			$item_post['img_name'] = $filename;
		}
		$item->values($item_post);
		$item->save();
		$this->go('shop/item/edit/'.$item->id);
		return;
	}
	
	private function _edit_image($image, $item)
    {
        if (
            ! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg')))
        {
            return FALSE;
        }
 
        $directory = DOCROOT.'public/shop/items/';
 
        if ($file = Upload::save($image, NULL, $directory))
        {
            $filename = strtolower(Text::random('alnum', 20)).'.jpg';
 
            Image::factory($file)
                ->resize(800, 800, Image::AUTO)
                ->save($directory.'big/'.$filename);
			
			Image::factory($file)
                ->resize(180, 180, Image::AUTO)
                ->save($directory.'normal/'.$filename);
 
			Image::factory($file)
                ->resize(80, 80, Image::AUTO)
                ->save($directory.'thmb/'.$filename);


			// Delete the temporary file
            unlink($file);
			if($item->img_name)
			{
				unlink($directory.'big/'.$item->img_name);
				unlink($directory.'normal/'.$item->img_name);
				unlink($directory.'thmb/'.$item->img_name);
			}

			
            return $filename;
        }
 
        return FALSE;
    }
	
	public function action_del() 
	{
		$item_id = (int) $this->request->param('id');
		$item = ORM::factory('shop_item', $item_id);
		
		if($item->img_name)
		{
			$directory = DOCROOT.'public/shop/items/';
			unlink($directory.'big/'.$item->img_name);
			unlink($directory.'normal/'.$item->img_name);
			unlink($directory.'thmb/'.$item->img_name);
		}
		
		$item->delete();
		$this->go('shop/item/index');
		return;
	}
	
	public function action_activate() 
	{
		$item_id = (int) $this->request->param('id');
		$item = ORM::factory('shop_item', $item_id);
		$cur_status = $item->status;
		if ($cur_status == 1)
		{
			$item->status = 0;
		}
		else
		{
			$item->status = 1;
		}
		$item->save();
		$this->go('shop/item/index');
		return;
	}
	
}
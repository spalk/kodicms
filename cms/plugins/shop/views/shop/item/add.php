<div class="page-header">
	<h1><?php echo __( 'Simple Shop' ); ?></h1>
</div>

<?php 
	if (isset($item->id))
	{
		echo Form::open(Route::url('shop', array('directory'=>'shop', 'controller' => 'item', 'action' => 'edit', 'id'=>$item->id)), array('enctype' => 'multipart/form-data')); 	
	}
	else
	{
		echo Form::open(Route::url('shop', array('directory'=>'shop', 'controller' => 'item', 'action' => 'add')), array('enctype' => 'multipart/form-data')); 
	}
?>
	<div class="span8">
		<legend><?php echo _('Add/edit item'); ?></legend>
		<?php echo Form::label('item[name]', _('Item name')); ?>
		<?php echo Form::input('item[name]', $item->name, array('type'=>'text', 'class'=>'span8', 'placeholder'=>_('Enter item name')))?>
		<?php echo Form::label('item[descr]', _('Item description')); ?>
		<?php echo Form::textarea('item[descr]', $item->descr, array('rows'=>8, 'class'=>'span8'))?>
		<?php echo Form::select('item[category]', $categories, $item->category); ?>

		<label><?php echo _('Item price'); ?></label>
		<div class="input-prepend input-append">
			<span class="add-on">р.</span>
			<?php echo Form::input('item[price]', $item->price, array('class'=>'span2', 'id'=>'appendedPrependedInput', 'size'=>'16', 'type'=>'text'))?>
			<span class="add-on">.00</span>
		</div>
		<label class="checkbox">
			<?php echo Form::checkbox('item[status]', '1', ($item->status == 1?TRUE:FALSE)); ?><?php echo _('Published'); ?>
		</label>
	</div>
	<div class="span3">
		<img src="<?php echo ($item->img_name?'/public/shop/items/normal/'.$item->img_name:'http://cambelt.co/180x180'); ?>">
		<legend><?php echo _('Add/edit main image'); ?></legend>
		<br />
		<?php echo Form::file('foto'); ?>
	</div>
	<div class="span11">
		<hr />
		<button type="submit" class="btn btn-success btn-large pull-right"><?php echo _('Submit'); ?></button>
	</div>
<?php echo Form::close(); ?>
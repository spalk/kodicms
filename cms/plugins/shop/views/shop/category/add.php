<div class="page-header">
	<h1><?php echo __( 'Simple Shop - category' ); ?></h1>
</div>

<?php 
	if (isset($category->id))
	{
		echo Form::open(Route::url('shop', array('directory'=>'shop', 'controller' => 'category', 'action' => 'edit', 'id'=>$category->id))); 	
	}
	else
	{
		echo Form::open(Route::url('shop', array('directory'=>'shop', 'controller' => 'category', 'action' => 'add'))); 
	}
?>

	<div class="span8">
		<legend><?php echo _('Add/edit category'); ?></legend>
		<?php echo Form::label('category[name]', _('Category name')); ?>
		<?php echo Form::input('category[name]', $category->name, array('type'=>'text', 'class'=>'span8', 'placeholder'=>_('Enter category name')))?>
	</div>
	<div class="span3">
		<legend><?php //echo _('Add/edit main image'); ?></legend>
		<br />
		<?php //echo Form::file('img_main'); ?>
	</div>
	<div class="span11">
		<hr />
		<button type="submit" class="btn btn-success btn-large pull-right"><?php echo _('Submit'); ?></button>
	</div>
<?php echo Form::close(); ?>
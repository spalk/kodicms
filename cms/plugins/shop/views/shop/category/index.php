<div class="page-header">
	<h1><?php echo __( 'Simple Shop - category' ); ?></h1>
</div>

<div class="btn-toolbar" style="margin: 0;">
	<?php echo UI::button(_('Add category'), array('icon' => UI::icon('plus'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'category', 'action' => 'add')))); ?>
</div>
<br />
<table class="table">
	<colgroup>
		<col width="100px">
		<col>
		<col width="100px">
		<col width="100px">
	</colgroup>
	<?php foreach($categories as $c): ?>
		<tr>
			<td>
				<?php // echo HTML::image($c->img_name, array('width' => 80, 'heigh' => 80)); ?>
			</td>
			<td><?php echo $c->name; ?></td>
			<td><?php echo UI::button(
					_('Edit'), 
					array(
						'icon' => UI::icon('edit'), 
						'href' => Route::url('shop', array(
							'directory' => 'shop', 
							'controller' => 'category', 
							'action' => 'edit',
							'id' => $c->id
							)),
						'class' => 'btn-success btn'
					)
				); ?>
			</td>
			<td><?php echo UI::button(
					_('Delete'), 
					array(
						'icon' => UI::icon('edit'), 
						'href' => Route::url('shop', array(
							'directory' => 'shop', 
							'controller' => 'category', 
							'action' => 'del',
							'id' => $c->id
							)),
						'class' => 'btn-danger btn'
					)
					); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
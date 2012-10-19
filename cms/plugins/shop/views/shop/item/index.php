<div class="page-header">
	<h1><?php echo __( 'Simple Shop - Items' ); ?></h1>
</div>



<div class="btn-toolbar" style="margin: 0;">
	<div class="btn-group">
		<button class="btn btn-info"><?php echo ($cur_cat_id?$categories[$cur_cat_id]:_('All categories')); ?></button>
		<button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><? echo HTML::anchor(Route::url('shop', array('controller' => 'item', 'action' => 'index', 'directory' => 'shop')), _('All categories')); ?></li>
			<li class="divider"></li>
			<?php foreach ($categories as $id=>$name): ?>
				<li><? echo HTML::anchor(Route::url('shop', array('controller' => 'item', 'action' => 'index', 'directory' => 'shop')).URL::query(array('category_id' => $id)), $name); ?></li>
			<?php endforeach; ?>
			<li class="divider"></li>
			<li><? echo HTML::anchor(Route::url('shop', array(
					'directory' => 'shop',
					'controller' => 'category', 
					'action' => 'index'
				)), _('Edit categories')); ?>
			</li>
		</ul>
	</div>
	<?php echo UI::button(_('Add category'), array('icon' => UI::icon('plus'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'category', 'action' => 'add')))); ?>
	<?php echo UI::button(_('Add item'), array('icon' => UI::icon('plus'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'add')))); ?>
</div>

<hr />

<div class="row-fluid">
	<ul class="thumbnails">
		
		<?php foreach($items as $i): ?>
		<li class="span2" id="<?php echo $i->id; ?>">
			<div class="thumbnail">
				<img src="<?php echo ($i->img_name?'/public/shop/items/normal/'.$i->img_name:'http://cambelt.co/180x180'); ?>" alt="<?php echo $i->name; ?>">
				<div class="caption">
					<h5><?php echo HTML::anchor(Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'edit', 'id' => $i->id)), $i->name)?></h5>
					<ul>
						<li><?php echo _('Price'); ?>: <?php echo $i->price; ?> руб.</li>
						<li><?php echo _('Status'); ?>: <span class="label <?php echo ($i->status == 1?'label-important':''); ?>"><?php echo ($i->status == 1?'Live':'Draft'); ?></span></li>
					</ul>
					<hr />
					<p>
						<?php echo UI::button('', array('icon' => UI::icon('remove'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'del', 'id' => $i->id)))); ?>
						<?php echo UI::button('', array('icon' => UI::icon('edit'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'edit', 'id' => $i->id)))); ?>
						<?php echo UI::button('', array('icon' => UI::icon('star'), 'href'=>Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'activate', 'id' => $i->id)))); ?>
					</p>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>			 

<hr />
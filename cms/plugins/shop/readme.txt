Simple Shop Plugin v1.0.0

Installing instructions:

1. Copy plugin directory 'shop' on your host in 'cms/plugins'.
2. Run SQL code in your database from 'shop_plugin_tables.sql' file.
3. Activate image module in 'cms/app/init.php' file.
4. Create 2 pages with type 'shop' in admin section for store and shoppingcart with following code:

Code example for store-page:

<?php $items = $page->shop->items(); ?>
<?php $amount = $page->shop->items_amount(); ?>
<?php $ids_in_cart = $page->shop->ids_in_cart(); ?>
<div class="row-fluid">
	<ul class="thumbnails">
		<?php foreach($items as $i): ?>
		<li class="span2" id="<?php echo $i->id; ?>">
			<div class="thumbnail">
				<img src="<?php echo ($i->img_name?'/public/shop/items/normal/'.$i->img_name:'http://placehold.it/180x180'); ?>" alt="<?php echo $i->name; ?>">
				<div class="caption">
					<h5><?php echo HTML::anchor(Route::url('shop', array('directory' => 'shop', 'controller' => 'item', 'action' => 'edit', 'id' => $i->id)), $i->name)?></h5>
					<ul>
						<li><?php echo _('Price'); ?>: <?php echo $i->price; ?> руб.</li>
						<li><?php echo (in_array((int)$i->id, $ids_in_cart) ? HTML::anchor(Route::url('shopping_cart', array('directory' => 'shop', 'controller' => 'cart', 'action' => 'dell', 'id' => $i->id)), 'In cart!') : HTML::anchor(Route::url('shopping_cart', array('directory' => 'shop', 'controller' => 'cart', 'action' => 'add', 'id' => $i->id)), 'Buy now!') ); ?></li>
						<li>
							<?php echo Form::open(Route::url('shopping_cart', array('directory'=>'shop', 'controller' => 'cart', 'action' => 'add'))); ?>
								<?php isset($amount[$i->id]) ? $am = $amount[$i->id] : $am = 0; ?>
								<?php echo Form::input('item[amount]', $am, array('type'=>'text', 'size'=>'1'))?>
								<?php echo Form::input('item[id]', $i->id, array('type'=>'hidden'))?>
								<button type="submit"><?php echo _('Put in cart'); ?></button>
							<?php echo Form::close(); ?>
						</li>
					</ul>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>		



Example for shopping cart page:

<?php $items = $page->shop->items_in_cart(); ?>
<?php $amount = $page->shop->items_amount(); ?>
<ul>
	<?php if($items): ?>
	<?php $global_summ = 0; ?>
	<?php echo Form::open(Route::url('shopping_cart', array('directory'=>'shop', 'controller' => 'cart', 'action' => 'recount'))); ?>
	<table width="100%" border="1" cellspacing="0" cellpadding="4">
		<?php foreach($items as $i): ?>
			<?php 
			$summ = $i->price * $amount[$i->id]; 
			$global_summ = $global_summ + $summ;
			?>
			<tr>
				<td><?php echo $i->name; ?></td>
				<td><?php echo $i->price; ?> руб./шт.</td>
				<td><?php echo Form::input('item['.$i->id.']', $amount[$i->id], array('type'=>'text', 'size'=>'1'))?> шт.</td>
				<td><?php echo $summ; ?> руб.</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td><b><?php echo $global_summ; ?> руб.</b></td>
		</tr>
	</table>
	<button type="submit"><?php echo _('Recount'); ?></button>
	<?php echo Form::close(); ?>
	<?php else: ?>
	<p>Ваша корзина пуста</p>
	<?php endif; ?>
</ul>


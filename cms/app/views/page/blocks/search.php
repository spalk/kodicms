<?php 
echo Form::open(URL::site('page/search'), array(
	'class' => 'form-search pull-right'
));
echo Form::hidden('token', Security::token()); ?>
	<div class="input-append">
		<?php echo Form::input('search', NULL, array(
			'id' => 'pageMapSearchField', 
			'class' => 'input-medium search-query',
			'placeholder' => __('Find page')
		)); ?>
		<?php echo UI::button(__('Search')); ?>
	</div>
<?php echo Form::close(); ?>
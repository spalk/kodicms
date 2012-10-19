<div class="page-header">
	<h1><?php echo __('Users'); ?></h1>  
</div>

<div class="map">
	<div class="well page-actions">
		<?php echo UI::button(__('Add user'), array(
			'href' => 'user/add', 'icon' => UI::icon('plus')
		)); ?>
	</div>
	
	<table class="table table-striped table-hover" id="UserList">
		<colgroup>
			<col />
			<col width="150px" />
			<col width="150px" />
			<col width="100px" />
		</colgroup>
		<thead>
			<tr>
				<th><?php echo __('Username'); ?></th>
				<th><?php echo __('Roles'); ?></th>
				<th><?php echo __('E-mail'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
			<tr class="item">
				<td class="name">
					<?php echo $user->gravatar(20, NULL, array('class' => 'img-circle')); ?> 
					<?php echo HTML::anchor(URL::site('user/edit/'.$user->id), $user->username); ?>
				</td>
				<td class="roles">
					<?php $roles = explode(',', $user->roles); ?>
					<?php foreach($roles as $role): ?>
						<?php echo UI::label($role, 'default'); ?>
					<?php endforeach; ?>
				</td>
				<td class="email"><?php echo UI::label($user->email); ?></td>
				<td class="actions">
					<?php 
					if ($user->id > 1)
					{
						echo UI::button(NULL, array(
							'href' => 'user/delete/'.$user->id, 'icon' => UI::icon('remove'),
							 'class' => 'btn btn-mini btn-confirm'
						));
					} ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div><!--/#userMap-->
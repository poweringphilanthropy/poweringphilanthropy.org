<?php
if (!defined('ABSPATH')) {
    die;
}
?>
<div class="wrap bb_wrap bb_edo_settings" id="bb-edo-settings">
    <h2 class="bb-headtitle"><?php esc_html_e('Responsive for Visual Composer - All Devices', 'bestbug') ?></h2>

<form action="" method="post">
	<table class="wp-list-table widefat">
		<thead>
			<tr>
				<th width="20px"><?php esc_html_e('Priority', 'bestbug') ?></th>
				<th><?php esc_html_e('Device', 'bestbug') ?></th>
				<th width="20%"><?php esc_html_e('Slug', 'bestbug') ?></th>
				<th width="20%"><?php esc_html_e('Media Features', 'bestbug') ?></th>
				<th width="12%"><?php esc_html_e('Breakpoint (px)', 'bestbug') ?></th>
				<th width="10%"><?php esc_html_e('Icon', 'bestbug') ?></th>
				<th width="100px"><?php esc_html_e('Action', 'bestbug') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($this->devices as $id => $device) {
					extract($device);
			?>
				<tr>
					<td><input class="bb-txt-priority" type="number" name="orders[<?php echo esc_attr($id) ?>]" value="<?php echo esc_attr($order) ?>"></td>
					<td><?php echo esc_html($label) ?></td>
					<td><?php echo esc_html($id) ?></td>
					<td><?php echo esc_html($mediafeature) ?></td>
					<td><?php echo esc_html($breakpoint) ?></td>
					<td><?php
						if($icon == 'class_icon') {
							echo '<span class="'.esc_attr($class_icon).'"></span>';
						} else {
							echo '<img class="img-icon" src="'.esc_attr($image_icon).'" alt="" />';
						}
					?></td>
					<td>
						<a class="button success" href="<?php echo admin_url('admin.php?page=bb_edo_addnewdevice&idEdit=' . $id) ?>">
							<span class="dashicons dashicons-edit"></span></a>
						<button type="button" class="button danger" onclick="bbvcedo_delete_device('<?php echo esc_attr($id) ?>')">
							<span class="dashicons dashicons-trash"></span></button>
					</td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="bbvedo_update_order" value="1">
	<button type="submit" class="button primary"><span class="dashicons dashicons-admin-generic"></span><?php esc_html_e('Save changes', 'bestbug') ?></button>

	<a href="<?php echo admin_url( 'admin.php?page=bb_edo_addnewdevice' ) ?>" class="button success"><span class="dashicons dashicons-plus-alt"></span><?php esc_html_e('Add device', 'bestbug') ?></a>
</form>

<form id="bb_delete_device_form" class="bb_delete_device_form" action="" method="post">
	<input type="hidden" name="bbEdoIdDeviceDel" id="bbEdoIdDeviceDel" value="">
</form>

</div>

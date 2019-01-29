<?php
if (!defined('ABSPATH')) {
    die;
}
?>
<div class="wrap bb_wrap bb_edo_settings" id="bb-edo-settings">
    <h2 class="bb-headtitle"><?php esc_html_e('Responsive for Visual Composer - General Settings', 'bestbug') ?></h2>

	<form id="bb-form" method="post" action="">
		<div class="bb-form">
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Mode Elements Option by themselves', 'bestbug') ?></label>
				</div>
				<div class="bb-field">
					<select name="option_by_elements" id="bb_edo_option_by_themselves">
						<option value="" <?php echo ($this->option_by_elements == '')?'selected="selected"' : ''; ?>><?php esc_html_e('Disable', 'bestbug') ?></option>
						<option value="all" <?php echo ($this->option_by_elements == 'all')?'selected="selected"' : ''; ?>><?php esc_html_e('All of Elements', 'bestbug') ?></option>
						<option value="custom" <?php echo ($this->option_by_elements == 'custom')?'selected="selected"' : ''; ?>><?php esc_html_e('Custom Elements', 'bestbug') ?></option>
					</select>

					<p id="bb_edo_option_by_themselves_custom" class="bb_edo_icon_depend">
						<textarea name="custom_elements"><?php echo esc_textarea( $this->custom_elements ) ?></textarea>
					</p>
				</div>
				<div class="bb-desc">
					<?php esc_html_e("'All of Elements' only apply to elements have available 'Design Options'", 'bestbug') ?>
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Menu tab position', 'bestbug') ?></label>
				</div>
				<div class="bb-field">
					<select name="menu_tab_position">
						<option value="top" <?php echo ($this->menu_tab_position == 'top')?'selected="selected"' : ''; ?>><?php esc_html_e('Top', 'bestbug') ?></option>
						<option value="right" <?php echo ($this->menu_tab_position == 'right')?'selected="selected"' : ''; ?>><?php esc_html_e('Right', 'bestbug') ?></option>
					</select>
				</div>
				<div class="bb-desc">
				</div>
			</div>
		</div>

		<input type="hidden" name="bb_edo_update_general" value="1">
		<button type="submit" name="submit" class="button success">
			<span class="dashicons dashicons-admin-generic"></span>
			<?php esc_html_e('Save Changes', 'bestbug') ?>
		</button>
	</form>

</div>

	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="field" name="s" id="s" onfocus="if(this.value == '<?php esc_attr_e( '搜索' ); ?>') { this.value = ''; }" value="<?php esc_attr_e( '搜索' ); ?>" onblur="if(this.value == '') { this.value = '<?php esc_attr_e( '搜索' ); ?>'; }" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( '►' ); ?>" />
	</form>
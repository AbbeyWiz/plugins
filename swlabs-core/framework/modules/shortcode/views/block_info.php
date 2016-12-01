
<div class=" block-info mbn shw-shortcode <?php echo esc_attr( $extra_class );?>">
	<?php if( !empty( $title ) ) :?>
	<div class="section-name">
		<div class="pull-left block-title"><?php echo esc_attr( $title );?></div>
		<div class="clearfix"></div>
	</div>
	<?php endif;?>
	<div class="section-content">
		<?php if ( !empty( $content ) ){
			printf('<div class="description">%s</div>', $content );
		}?>
	</div>
</div>
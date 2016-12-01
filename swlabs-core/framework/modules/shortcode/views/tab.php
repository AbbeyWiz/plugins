<?php
if( $style == '01' ) {
	$class_tab ="tab-01";
}else if( $style == '02' ){
	$class_tab ="tab-02";
}else if( $style == '03' ){
	$class_tab ="tab-03";
}else if( $style == '04' ){
	$class_tab ="tab-04";
}else{
	$class_tab ="tab-06";
}
?>
<div id="<?php echo esc_attr( $id ); ?>" class = " shw-shortcode shw-tab-container <?php echo esc_attr( $extra_class );?>">
	<div class="<?php echo esc_attr( $class_tab )?>">
		<!-- Nav tabs-->
			<div class="nav nav-tabs box-tab">
				<?php printf( "%s", $content );?> 
			</div>
		<!-- Tab panes-->
			<div class="tab-content"></div>
	</div>
</div>

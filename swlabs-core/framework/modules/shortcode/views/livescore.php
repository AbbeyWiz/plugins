<?php 
	$model = new SwlabsCore_Block;   
	if(!empty($atts['type']) && $atts['type'] == '1'):
		$all = false;
		$leagues = $atts['leagues_list'];
		if (empty($leagues)) { $all = true ; }
		else
			foreach ($leagues as $key => $value)
				if ($value =='all') {
					$all = true ;
					break;
				}   
		$datas = array();
		$arrLeages = Swbignews::get_params('league_options');
		$leagueNames = array(); 
		if ($all) {
			foreach ($arrLeages as $key => $value) {
				$temp = $model->get_livescore_football($key);
				if (!empty($temp)) {
					$datas[] = $temp; 
					$leagueNames[] = $value;
				}
			}
		}else{
			foreach ($leagues as $key => $value)
				if (!in_array($value, $leagueNames)){ 
					$temp = $model->get_livescore_football($value);
					if (!empty($temp)) {
						$datas[] = $temp;
						$leagueNames[] = $arrLeages[$value];
					}  
				} 
		}  
		if (count($datas) > 0 ) :
			foreach ($datas as $key => $league): ?>
			<div class='item'>
				<div class='cup-name'>
					<div class='pull-left'><?php echo esc_html($leagueNames[$key]); ?> </div>
					<div class='pull-right'>
						<a class='right carousel-control' href='#cup-name-carousel-<?php echo esc_attr($atts['id']); ?>' data-slide='next'>
							<span class='fa fa-angle-right'></span>
						</a>
						<a class='left carousel-control' href='#cup-name-carousel-<?php echo esc_attr($atts['id']); ?>' data-slide='prev'>
							<span class='fa fa-angle-left'></span>
						</a>
					</div>
				</div>
				<div class="clearfix"></div>
				<table class='table table-condensed table-hover'>
					<thead>
						<tr>

							<th><?php echo esc_html__('No','swlabs-core'); ?></th>
							<th><?php echo esc_html__('Name','swlabs-core'); ?></th>
							<th><?php echo esc_html__('P','swlabs-core'); ?></th>
							<th><?php echo esc_html__('PTS','swlabs-core'); ?></th>

						</tr>
					</thead>
					<tbody>
					<?php  $i=0; foreach ($league as $k => $team):  
						$i++;
						$team = (object) $team;
						echo ' <tr> <td> '.esc_html($team->rank).' </td> 
									<td> '.esc_html($team->name).' </td> 
									<td> '.esc_html($team->played).'  </td> 
									<td> '.esc_html($team->points).' </td> </tr> ';

 
						if($i==10){
							break;
						}
						endforeach;?> 
					</tbody>
				</table>
			</div>
			<?php endforeach;   
		endif;
	elseif (!empty($atts['loading_table']) && $atts['loading_table'] == 'show') :
		$leagues = array();
	 	$leagues = json_decode(urldecode($atts['leagues_list']));
			$all = false;
			if (empty($leagues)) {
				$all = true ;
			}else
				foreach ($leagues as $key => $value) { 
					if ($value->selected =='All') {
						$all = true ;
						break;
					}
				} 
			$datas = array();
			$arrLeages = Swbignews::get_params('league_options'); 
			$leagueNames = array();
			if ($all) {
				foreach ($arrLeages as $key => $value) { 
					$temp = $model->get_livescore_football($key);
					if (!empty($temp)) {
						$datas[] = $temp; 
						$leagueNames[] = $value;
					}
				}
			}else{
				foreach ($leagues as $key => $value) {
					if (!in_array($value->selected, $leagueNames)){ 
						$temp = $model->get_livescore_football($value->selected);
						if (!empty($temp)) {
							$datas[] = $temp; 
							$leagueNames[] = $arrLeages[$value->selected];
						}  
					}
				}
			}   
		?>
		<?php if (count($datas) > 0 ) :?>
			<?php foreach ($datas as $key => $league): ?>
			<div class='item'>
				<div class='cup-name'>
					<div class='pull-left'><?php echo esc_html($leagueNames[$key]); ?> </div>
					<div class='pull-right'>
						<a class='right carousel-control' href='#cup-name-carousel-<?php echo esc_attr($atts['id']); ?>' data-slide='next'>
							<span class='fa fa-angle-right'></span>
						</a>
						<a class='left carousel-control' href='#cup-name-carousel-<?php echo esc_attr($atts['id']); ?>' data-slide='prev'>
							<span class='fa fa-angle-left'></span>
						</a>
					</div>
				</div>
				<div class="clearfix"></div>
				<table class='table table-condensed table-hover'>
					<thead>
						<tr>

							<th><?php echo esc_html__('No','swlabs-core'); ?></th>
							<th><?php echo esc_html__('Name','swlabs-core'); ?></th>
							<th><?php echo esc_html__('P','swlabs-core'); ?></th>
							<th><?php echo esc_html__('PTS','swlabs-core'); ?></th>

						</tr>
					</thead>
					<tbody>
					<?php  $i=0; foreach ($league as $k => $team):  
						$i++;
						$team = (object) $team;
						echo ' <tr> <td> '.esc_html($team->rank).' </td> 
									<td> '.esc_html($team->name).' </td> 
									<td> '.esc_html($team->played).'  </td> 
									<td> '.esc_html($team->points).' </td> </tr> ';

 
						if($i==10){
							break;
						}
						endforeach;?> 
					</tbody>
				</table>
			</div>
			<?php endforeach;?> 
		<?php endif;?>  
	<?php else:   
		$model->attributes['block-class'] = 'livescore-table-'.esc_attr($atts['id']);
		$model->attributes['block_title_color'] = (empty($atts['block_title_color'])) ? '': $atts['block_title_color']; 
		// add inline css
		$custom_css = $model->add_custom_css(); 
		if( $custom_css ) {
			do_action( 'swlabscore_add_inline_style', $custom_css );
		}

	?>
	<div class='livescore-table  livescore-table-<?php echo esc_attr($atts['id']); ?> <?php echo esc_attr($atts['extra_class']); ?> shw-shortcode' data-id="<?php echo esc_attr($atts['id']); ?>" id="livescore-table-<?php echo esc_attr($atts['id']); ?>">
		<div class='heading block-title'> 
			<?php  
			if( !empty( $atts['block_title'] ) ) :?>
				<?php echo esc_attr($atts['block_title']);?>
			<?php endif;?> 
		</div>
		<div id='cup-name-carousel-<?php echo esc_attr($atts['id']); ?>' class='carousel slide' data-interval='false'>
			<div class='carousel-inner' id="carousel-inner-<?php echo esc_attr($atts['id']); ?>" data-block='<?php echo esc_attr(json_encode($atts)); ?>'>  
				<div class="item">
					<img src="<?php echo esc_url(SWLABSCORE_ASSET_URI); ?>/images/loading.gif" alt="" class="image-loading">
				</div>
			</div>
		</div>
	</div>
<?php endif;?> 

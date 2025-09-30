<?php 
/*
Plugin Name: AdSpeed Ad Server
Plugin URI: https://www.AdSpeed.com/Knowledges/1030/Serving_Code/AdSpeed_Plugin_WordPress.html
Description: Displays advertising from your AdSpeed account on the sidebar or within a post. Ads are served, managed and tracked for impressions and clicks by AdSpeed Ad Server. You setup and manage ads inside your AdSpeed account.
Version: 1.2.13
Author: AdSpeed.com
Author URI: https://www.AdSpeed.com
Author Email: support@adspeed.com
License: Copyright 2021 AdSpeed (support@adspeed.com)
*/

 class AdSpeed_Ad_Server extends WP_Widget { public function AdSpeed_Ad_Server() { $this->_init_plugin_constants(); $widget_opts = array ( 'classname' =>PLUGIN_NAME, 'description' => 'Displays advertising from your AdSpeed account on the sidebar or within a post. Ads are served, managed and tracked for impressions and clicks by AdSpeed Ad Server. You setup ads inside your AdSpeed account.' ); $this->WP_Widget(PLUGIN_SLUG,PLUGIN_NAME,$widget_opts); add_filter('the_content',array($this,'replacePostTag')); add_filter('the_excerpt',array($this,'replacePostTag')); $this->_register_scripts_and_styles(); } public static function getAdTag($pZoneID,$pCustom='') { if (!empty($pCustom) && substr($pCustom,0,1)!='&') { $pCustom = '&'.$pCustom; } $vOutput = '<div class="AdSpeedWP">
		<!-- AdSpeed.com WP Ad Tag 8.0.2 for [Zone] #'.$pZoneID.' [Any Dimension] -->
		<script type="text/javascript" src="//g.adspeed.net/ad.php?do=js&zid='.$pZoneID.'&wd=-1&ht=-1&target=_blank&cb='.time().$pCustom.'"></script>
		<!-- AdSpeed.com End --></div>'; return $vOutput; } public static function replacePostTag($pContent) { if (preg_match_all('/{AdSpeed:Zone:([0-9]+)}/',$pContent,$vMatches)) { foreach ($vMatches[1] AS $vOne) { $pContent = str_replace('{AdSpeed:Zone:'.$vOne.'}',self::getAdTag($vOne),$pContent); } } return $pContent; } function widget($args, $instance) { extract($args, EXTR_SKIP); echo $before_widget; $AdSpeed_zid = empty($instance['AdSpeed_zid']) ? '' : apply_filters('AdSpeed_zid', $instance['AdSpeed_zid']); $AdSpeed_CustomParams = empty($instance['AdSpeed_CustomParams']) ? '' : apply_filters('AdSpeed_CustomParams', $instance['AdSpeed_CustomParams']); echo self::getAdTag($AdSpeed_zid,$AdSpeed_CustomParams); echo $after_widget; } function update($new_instance, $old_instance) { $instance = $old_instance; $instance['AdSpeed_zid'] = strip_tags(stripslashes($new_instance['AdSpeed_zid'])); $instance['AdSpeed_CustomParams'] = strip_tags(stripslashes($new_instance['AdSpeed_CustomParams'])); return $instance; } function form($instance) { $instance = wp_parse_args( (array)$instance, array( 'AdSpeed_zid' => '', 'AdSpeed_CustomParams' => '', ) ); $AdSpeed_zid = strip_tags(stripslashes($new_instance['AdSpeed_zid'])); $vOutput = '
			<label for="AdSpeed_zid">Zone ID:</label><br/>
			<input type="text" id="'.$this->get_field_id('AdSpeed_zid').'" name="'.$this->get_field_name('AdSpeed_zid').'" value="'.$instance['AdSpeed_zid'].'" /> (numbers only)
			
			<br/>
			
			<label for="AdSpeed_CustomParams">Custom Parameters:</label><br/>
			<input type="text" id="'.$this->get_field_id('AdSpeed_CustomParams').'" name="'.$this->get_field_name('AdSpeed_CustomParams').'" value="'.$instance['AdSpeed_CustomParams'].'" /> (optional)

		'; echo($vOutput); } private function _init_plugin_constants() { if(!defined('PLUGIN_LOCALE')) { define('PLUGIN_LOCALE','adspeed-ad-server-locale'); } if(!defined('PLUGIN_NAME')) { define('PLUGIN_NAME','AdSpeed Ad Server'); } if(!defined('PLUGIN_SLUG')) { define('PLUGIN_SLUG','AdSpeed-Ad-Server'); } } private function _register_scripts_and_styles() { } private function _load_file($name, $file_path, $is_script = false) { $url = WP_PLUGIN_URL . $file_path; $file = WP_PLUGIN_DIR . $file_path; if (file_exists($file)) { if($is_script) { wp_register_script($name, $url); wp_enqueue_script($name); } else { wp_register_style($name, $url); wp_enqueue_style($name); } } } } add_action('widgets_init', create_function('', 'register_widget("AdSpeed_Ad_Server");')); ?>
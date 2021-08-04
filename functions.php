<?php
	function utfeed_load_widget() {
		register_widget( 'UTFEED_Widget' );
	}
	
	function utfeed_pre($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
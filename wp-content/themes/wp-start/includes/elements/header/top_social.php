<?php
	$facebook_url    = print_option('facebook-url');
	$twitter_url     = print_option('twitter-url');
	$google_plus_url = print_option('google-plus-url');
	$linkedin_url    = print_option('linkedin-url');
	$youtube_url     = print_option('youtube-url');
	$pinterest_url   = print_option('pinterest-url');

	if($facebook_url) {
		echo '<li><a href="'.$facebook_url.'" target="_blank"><i class="icon-facebook"></i></a></li>';
	}
	if($twitter_url) {
		echo '<li><a href="'.$twitter_url.'" target="_blank"><i class="icon-twitter"></i></a></li>';
	}
	if($google_plus_url) {
		echo '<li><a href="'.$google_plus_url.'" target="_blank"><i class="icon-google-plus"></i></a></li>';
	}
	if($linkedin_url) {
		echo '<li><a href="'.$linkedin_url.'" target="_blank"><i class="icon-linkedin"></i></a></li>';
	}
	if($youtube_url) {
		echo '<li><a href="'.$youtube_url.'" target="_blank"><i class="icon-youtube"></i></a></li>';
	}
	if($pinterest_url) {
		echo '<li><a href="'.$pinterest_url.'" target="_blank"><i class="icon-pinterest"></i></a></li>';
	}
?>
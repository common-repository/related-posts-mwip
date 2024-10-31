<?php 


/*
Plugin Name: Related Posts Mwip
Version: 2.1
Description: Choose related posts in a simple and quickly way. At the end of the article advise similar posts to the one just read.
Author: Simone Fontana
License: GPLv3

Copyright 2015 Simone Fontana
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


/*Call css*/
function mwip_call_style()
{
    // Register the style:
    wp_register_style( 'mwip_custom-style', plugins_url( '/css/style.css', __FILE__ ), array(), 'all' );
	
    // Enqueue the style:
    wp_enqueue_style( 'mwip_custom-style' );
	
}
add_action( 'wp_enqueue_scripts', 'mwip_call_style' );

/*Call admin css*/

function mwip_call_admin_style() {
        
}
add_action( 'admin_enqueue_scripts', 'mwip_call_admin_style' );



/*Add a new field to settings */ 

add_action('admin_menu', 'mwip_add_custom_options');

/* Add colorpicker and admin style */

add_action( 'admin_enqueue_scripts', 'mwip_enqueue_color_picker' );
function mwip_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
	wp_register_style( 'mwip_admin_css', plugins_url( '/css/admin.css', __FILE__ ), false, '1.0.0' );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'mwip_admin_css' );
    wp_enqueue_script( 'mwip-admin-page-script', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


/*Add a new fields to the database*/
add_option('mwip_title_related','Related Posts','','yes');
add_option('mwip_color_related','#FFFFFF','','yes');
add_option('mwip_title_font_size', 20, '', 'yes');
add_option('mwip_border_related','#FFFFFF','','yes');
add_option('mwip_related_post_true', 1,'', 'yes');
add_option('mwip_border_true', 1,'', 'yes');


/* Add Settings Section */
function mwip_add_custom_options()
{
    add_options_page('Setting', 'Related Posts Mwip', 'manage_options', 'functions', 'mwip_related_posts_custom_options');
}

function mwip_related_posts_custom_options()  {
	
    include('Setting_Related_Posts.php');

}

?>
<?php
 
 /* The box adds related posts informations to the article */
 
function  mwip_add_meta_box() {
 
    add_meta_box( '333', 'Additional Information', 'mwip_information_meta_box', 'post', 'normal', 'high' );
    
}
   
add_action( 'add_meta_boxes', 'mwip_add_meta_box' );


function mwip_information_meta_box($post){
    include('Posts_Related_Edit.php');
}

?>
<?php

/* Save meta to database */

add_action('save_post', 'mwip_save_related_posts');

function mwip_save_related_posts()
{  
    global $post;
   
    if(isset($_POST['related_true'])){
        $disabled_post=intval($_POST['related_true']); }
		
    if(isset($_POST["mwip_related_1"])) {
		$related1=intval($_POST["mwip_related_1"]);}
		
	if(isset($_POST["mwip_related_2"])){
		$related2=intval($_POST["mwip_related_2"]);}
		
	if(isset($_POST["mwip_related_3"])){
		$related3=intval($_POST["mwip_related_3"]);}
		
    if(isset($_POST["mwip_random_post"])){
		$random_post=intval($_POST["mwip_random_post"]);
	}
	
    if (isset($disabled_post)) {
            update_post_meta($post->ID, "Related_post_true", 1); }
	else {
			if (isset($post->ID)){
                       update_post_meta($post->ID, "Related_post_true", 0);}
		}
	
	if (isset($random_post)) {
		
			   update_post_meta($post->ID, "Random_post_true", 1);
			   $random_post=mwip_random_query();
			   
			   if($random_post!=Null){
				
				        $count=1;
						
				        foreach($random_post as $id_posts){
					                $name="Post_related".$count;
					                update_post_meta($post->ID, $name, $id_posts);
					                $count=$count+1;
									}
									
							}
			}
		 
    else {
		if (isset($post->ID)){
		    update_post_meta($post->ID, "Random_post_true", 0);
		}
			if (isset($related1) ) {
                        update_post_meta($post->ID, "Post_related1", $related1); }
   
            if (isset($related2)) {
                        update_post_meta($post->ID, "Post_related2", $related2); }
   
            if (isset($related3)) {
                        update_post_meta($post->ID, "Post_related3", $related3); }
		
	}
   
   }
   
   
   
/* Call related posts and additional informations to the article*/
		
add_filter( 'the_content', 'mwip_informations_posts', 999 );

function mwip_informations_posts($content) {
	if(in_array('get_the_excerpt', $GLOBALS['wp_current_filter'])) return $content;
    include('Template_Related_Posts.php');
}


/*Random Posts query */

function mwip_random_query() {
	
	global $wpdb;
	$sql="SELECT id FROM wp_posts WHERE `post_type`='post' && `post_status`='publish'";
	$posts = $wpdb->get_results($sql);
	$array_posts=[];
	$array_random=[];
	foreach($posts as $post_id){
		array_push($array_posts, $post_id->id);	
	}
	
	if (count($array_posts)>=3){  $random_keys=array_rand($array_posts, 3);      }
	elseif (count($array_posts)==2){  $random_keys=array_rand($array_posts, 2);  }                                   
	elseif  (count($array_posts)==1){  $random_keys=array_rand($array_posts, 1); }                                  
	elseif  (count($array_posts)==0){  $array_random=Null;                  }
	
	foreach($random_keys as $random_key) {
		array_push($array_random, $array_posts[$random_key]);
	}
	
	return $array_random;
	
}
		

?>
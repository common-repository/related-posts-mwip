<?php
if (is_single()){
	echo $content;		    
    global $post;
    $array = get_post_meta($post->ID);	
    
    if (isset($array["Related_post_true"])) {
	     
        if ($array["Related_post_true"][0]==1) { 
            $title=get_option('mwip_title_related');
            $color=get_option('mwip_color_related');
			$font_size=get_option('mwip_title_font_size');
            $border=get_option('mwip_border_related');
            $true_border=get_option('mwip_border_true');
		  
            echo '<div class="mwip_related_row"';
            if ($true_border==1) { echo 'style="border-top:1px solid '.esc_attr($border).';"';}
            echo '><h3 style="color:'.esc_attr($color).'; margin-top:15px; margin-bottom:15px; font-size:'.esc_attr($font_size).'px;">'.esc_html($title).'</h3></div>';
            echo '<div class="mwip_related_row mwip_related_posts-container">';
	    $id_post=get_the_ID();
            for ($i=1; $i<4; $i++) {
	        
		$related_id= get_post_meta($id_post,'Post_related'.$i, true);
                if(!empty($related_id)) {
                    $link_related=get_permalink($related_id);
                    $title_related=get_the_title($related_id);
                    $image_related= get_the_post_thumbnail($related_id,array(150,150));
                                        
		             echo '<a href="'.esc_url($link_related).'">
                                  <div class="mwip_related_col-md-4">
			              <div class="mwip_container-thumb">';
                                       if (isset($image_related) && !empty($image_related)) { echo $image_related;  } 
				       else { echo '<img src="'.plugins_url( 'img/unless-thumbnail.jpg', __FILE__ ).'" style="width:100%; min-heigth:100%;" alt="'.$title_related.'" />'  ;  }
				       
			        echo '</div>         
                                      <h5>'.esc_html($title_related).'</h5></div></a>'; 
												 
				       }       
                               
			            } /*close for */ echo '</div><div class="mwip_related_clear"></div>';                                        
                              } /*close if */    
	                   }
                       }   /*close if*/
					   
else echo $content;
		
	
	
?>
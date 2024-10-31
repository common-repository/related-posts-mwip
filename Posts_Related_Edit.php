<?php

    $array = get_post_meta($post->ID);
	
	if(isset($array["Post_related1"][0])) { $corr1=$array["Post_related1"][0];}
	
    if(isset($array["Post_related2"][0])) { $corr2=$array["Post_related2"][0]; }
	
    if(isset($array["Post_related3"][0]))  {  $corr3=$array["Post_related3"][0];}
	
	if(isset($array["Related_post_true"][0])){$related_true=$array["Related_post_true"][0];}
	
	else { $related_true=NULL;  }
	
	if(isset($array["Random_post_true"][0])){$random_post=$array["Random_post_true"][0];}
	
	else { $random_post=NULL;  }
	
	$id=get_the_ID();
	$args=array('suppress_filters' => 0, 'posts_per_page'=>-1, 'orderby'=> 'title', 'order' => 'ASC', 'exclude' => $id );
    $list_posts=get_posts($args);       
        ?>
        
	<p><label class="mwip-left">Enable Related Posts:</label> <input name="related_true" id="RelatedBox" type="checkbox" <?php if ($related_true==1) { echo 'checked'; } ?> /></p>
    <p><label class="mwip-left">Random Posts:</label> <input name="mwip_random_post" id="RandomBox" type="checkbox" <?php    if ($random_post==1) { echo 'checked'; } ?> /></p>
	
    <div id="mwip-label-container">
		
	 <label class="mwip-left">Related Post 1:</label>
       <select id="mwip_related_field1" class="mwip_related_field mwip-left" name="mwip_related_1" <?php if ($related_true==0) { echo 'disabled'; } ?>>
          <option value="" >None</option>
          <?php foreach($list_posts as $value) { echo '<option ';
          if (get_post_meta( $post->ID, 'Post_related1', true) == $value->ID) {
          
          echo 'selected="selected"'; }
          
          else{ echo ''; }
          
          echo ' value="'.esc_attr($value->ID).'">'.esc_html(get_the_title($value->ID)).'</option>' ;  }  ?>
       </select><br />
    <label class="mwip-left">Related Post 2:</label>
       <select id="mwip_related_field2" class="mwip_related_field mwip-left" name="mwip_related_2" <?php if ($related_true==0) { echo 'disabled'; } ?>>
    
          <option value="" >None</option>
          
           <?php foreach($list_posts as $value) { echo '<option ';
          if (get_post_meta( $post->ID, 'Post_related2', true) == $value->ID) {
          
          echo 'selected="selected"'; }
          
          else{ echo ''; }
          
          echo ' value="'.esc_attr($value->ID).'">'.esc_html(get_the_title($value->ID)).'</option>' ;  }  ?>
       </select><br />
    <label style="margin-left:10px;">Related Post 3:</label>
       <select id="mwip_related_field3" class="mwip_related_field mwip-left"name="mwip_related_3" <?php if ($related_true==0) { echo 'disabled'; } ?>>
          <option value="" >None</option>
           <?php foreach($list_posts as $value) { echo '<option ';
          if (get_post_meta( $post->ID, 'Post_related3', true) == $value->ID) {
          
          echo 'selected="selected"'; }
          
          else{ echo ''; }
          
          echo ' value="'.esc_attr($value->ID).'">'.esc_html(get_the_title($value->ID)).'</option>' ;  }  ?>
       </select>
	   </div>

<script>
    document.getElementById('RelatedBox').onchange = function() {
    document.getElementById('mwip_related_field1').disabled = !this.checked;
    document.getElementById('mwip_related_field2').disabled = !this.checked;
	document.getElementById('mwip_related_field3').disabled = !this.checked;
	document.getElementById('RandomBox').disabled = !this.checked;
};

   if (document.getElementById('RandomBox').checked)
	
	{
	document.getElementById('mwip-label-container').style.display="none";	
	}

    document.getElementById('RandomBox').onchange = function() {
		
	    if (document.getElementById('RandomBox').checked)
		{
			document.getElementById('mwip-label-container').style.display="none";
			}
	
	    else
		{
			document.getElementById('mwip-label-container').style.display="inline";
			}
	}
	
</script> 
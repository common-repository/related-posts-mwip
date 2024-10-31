<?php
/*Add fields in Settings*/
if (isset($_POST['title_r'])) { $title=sanitize_text_field($_POST['title_r']); }
if (isset($_POST['color_related'])) { $color=sanitize_text_field($_POST['color_related']);  }
if (isset($_POST['border_color_related'])) {$border=sanitize_text_field($_POST['border_color_related']); }
if (isset($_POST['border_true'])) {  $disable=$_POST['border_true'];  }
if(isset($_POST['title_font_size'])) { $font_size=intval($_POST['title_font_size']); }    

?>
<?php
if( !empty($_POST['mwip_submit'])) {
	  
   if (isset($title) && !empty($title)) {
	  
	  if(strlen($title)>64){ $title=substr(0, 64);}
      update_option('mwip_title_related', $title);  }
	  
   if (isset($color) && !empty($color)) {
	  
	   if($color[0]!='#'){ $color='#'.$color; }
	   if(strlen($color)>7){ $color=substr(0, 7);}
       update_option('mwip_color_related', $color);  }
	   
   if (isset($font_size) && !empty($font_size)) {
	  if($font_size>256){ $font_size=256;   }
	  update_option('mwip_title_font_size', $font_size);  
   }

   if (isset($border) && !empty($border)) {
	   
	   if($border[0]!='#'){ $border='#'.$border; }
	   if(strlen($border)>7){ $border=substr(0, 7);}
       update_option('mwip_border_related', $border);  }

   if (isset($disable)) {
       update_option('mwip_border_true', 1); }
   else {
       update_option('mwip_border_true', 0);}
}
	?>
<div class="mwip_wrap">
    <h2>Related Posts Options</h2>
    <form action="#" method="post" class="mwip_form_setting">
        <label>Text Title: </label>
        <input type="text" value="<?php echo esc_attr(get_option('mwip_title_related')); ?>" name="title_r" /><br />
		<h4>Style Settings</h4>
        <label>Title Color: </label><br />
        <input value="<?php echo esc_attr(get_option('mwip_color_related')); ?>" type="text" class="mwip-color-setting" name="color_related"/><br />
		<label class="mwip_input_margin">Font size: </label>
        <input class="mwip_small_input" value="<?php echo esc_attr(get_option('mwip_title_font_size')); ?>" type="text" name="title_font_size"/>px<br />
        <label>Enable border top:</label><br />
        <input name="border_true" id="mwip_relatedbox" type="checkbox" <?php if (get_option('mwip_border_true')==1) { echo 'checked'; } ?> /><br />
        <div id="mwip_hidden_border">
		  <label>Border Color:</label><br />
          <input id="mwip_relatedborder" class="mwip-color-setting" value="<?php echo esc_attr(get_option('mwip_border_related')); ?>" type=text <?php if (get_option('mwip_border_true')==0) { echo 'disabled'; } ?>  name="border_color_related"/>	</br>
        </div>
		<input class="mwip_input_margin" type="submit" name="mwip_submit" value="Save" onClick="window.location.reload()"/><br /> 
	</form>		   
</div>
<script>
 if (!document.getElementById('mwip_relatedbox').checked)
	
	{
	document.getElementById('mwip_hidden_border').style.display="none";	
	}

    document.getElementById('mwip_relatedbox').onchange = function() {
		
	    if (!document.getElementById('mwip_relatedbox').checked)
		{
			document.getElementById('mwip_hidden_border').style.display="none";
			}
	
	    else
		{
			document.getElementById('mwip_hidden_border').style.display="inline";
			}
	}
</script> 

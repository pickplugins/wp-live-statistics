<?php

	if(empty($_POST['wpls_hidden']))
		{
			$wpls_refresh_time = get_option( 'wpls_refresh_time' );	
			$wpls_delete_data = get_option( 'wpls_delete_data' );
			$wpls_google_api_key = get_option( 'wpls_google_api_key' );
						
					
		}

	else
		{
		
		if($_POST['wpls_hidden'] == 'Y')
			{
			//Form data sent
			
			
			$wpls_delete_data = $_POST['wpls_delete_data'];
			update_option('wpls_delete_data', $wpls_delete_data);			

			$wpls_refresh_time = $_POST['wpls_refresh_time'];
			update_option('wpls_refresh_time', $wpls_refresh_time);

				$wpls_google_api_key = $_POST['wpls_google_api_key'];
				update_option('wpls_google_api_key', $wpls_google_api_key);

			
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>
 
<?php
			}
		} 
?>

 
 
 
 
 
 
 
<div class="wrap">
 
	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(wpls_plugin_name.' Settings')."</h2>";?>
<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="wpls_hidden" value="Y">
        <?php settings_fields( 'wpls_options' );
				do_settings_sections( 'wpls_options' );
		?>



    <div class="para-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Options</li>
            <li nav="2" class="nav2">Help & Upgrade</li>
           
        </ul> <!-- tab-nav end --> 

		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">


            
				<div class="option-box">
                    <p class="option-title">Refresh time to check visitor online.</p>
                    <p class="option-info">Time in millisecond's. (minimum: 3000)</p>
                    
                    
                    
                    <input type="text" name="wpls_refresh_time" value="<?php  if(!empty($wpls_refresh_time)) echo $wpls_refresh_time; else  echo '5000'; ?>" /> 

                    
                </div>



				<div class="option-box">
					<p class="option-title">Google map api key.</p>
					<p class="option-info"><a href="https://developers.google.com/maps/documentation/javascript/adding-a-google-map#key"> Get an API key</a> </p>



					<input type="text" name="wpls_google_api_key" value="<?php  if(!empty($wpls_google_api_key)) echo $wpls_google_api_key; ?>" />


				</div>










				<div class="option-box">
                    <p class="option-title">Reset Data ?</p>
                    <p class="option-info">Delete all data on table when uninstall or delete plugin.</p>
					<label ><input type="radio" name="wpls_delete_data"  value="yes" <?php  if($wpls_delete_data=='yes') echo "checked"; ?>/><span title="yes" class="wpls_delete_data_yes <?php  if($wpls_delete_data=='yes') echo "selected"; ?>">Yes</span></label>
            
 					<label ><input type="radio" name="wpls_delete_data"  value="no" <?php  if($wpls_delete_data=='no') echo "checked"; ?>/><span title="no" class="wpls_delete_data_no <?php  if($wpls_delete_data=='no') echo "selected"; ?>">No</span></label>
                    
                </div>









            
            
            </li>
            <li style="display: none;" class="box2 tab-box ">

            
            </li>

            
		</ul>
	</div> <!-- para-settings --> 	  
	
    <p class="submit">
    	<input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
	</p>


</form>

</div>
<div class="wrap">
	<h2><?php echo wpls_plugin_name; ?> - Filters</h2>
    <div class="para-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Top Factors</li>
            <li nav="2" class="nav2">Help & Upgrade</li>
           
        </ul> <!-- tab-nav end --> 

		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
            	<div class="wpls-fliters">
                	<div class="filter-tools">
                    Filter for
                    	<select name="filter_for" class="filter-for">
                        	<option value="url_id">URL</option>                        
                        	<option value="userid">User</option>
                        	<option value="platform">Device Platform(OS)</option>
                        	<option value="browser">Device Browser</option>
                        	<option value="screensize">Device Screensize</option>
                            <option value="referer_doamin">Referer Domain</option>                     
                        	<option value="referer_url">Referer URL</option>
                         	<option value="city">City</option>                           
                         	<option value="countryName">Country</option>
                         	<option value="url_term">Link Type</option>                            
                                                        
                        </select>
                        <br />
                        Maximum items: 
                        <input type="text" size="4" class="max-items" name="max_items" value="10" /><br />
                        First Date: <input type="text" size="7" class="first-date" name="first_date" value="<?php echo date("Y-m-d");?>" /><br />
                        Second Date: <input type="text" size="7" class="second-date" name="second_date" value="<?php echo date("Y-m-d");?>" />
                        
                        <br />
                        <input class="filter-submit button" type="submit" value="Submit" /> 
                        <script>
						jQuery(document).ready(function($) {
							$('.first-date, .second-date').datepicker({
								dateFormat : 'yy-mm-dd'
							});
						});
						</script>
                    </div>
                    <div class="filter-result">
                    
                    </div>
                
                </div>
            
            
            </li>
            
            <li style="display: none;" class="box2 tab-box">
            </li>
        </ul>
        
        
        
        
        
        
</div>

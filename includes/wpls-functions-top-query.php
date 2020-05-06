<?php

if ( ! defined('ABSPATH')) exit; // if direct access 






// Display url_term start
	function wpls_TopPageTerms($url_term)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $url_term FROM $table GROUP BY $url_term ORDER BY COUNT($url_term) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($url_term=="url_term")
				{
					$count_url_term = $wpdb->get_results("SELECT url_term, COUNT(*) AS url_term FROM $table GROUP BY url_term ORDER BY COUNT(url_term) DESC LIMIT 10", ARRAY_A);
				}

					$top_url_term ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$url_term]=="none" || $result[$i][$url_term]=="direct" || $result[$i][$url_term]==NULL || $result[$i][$url_term]==""  )
								{
					
								}
							else
								{
					
								
								if($url_term=="url_term")
									{
										$top_url_term.= "['".$result[$i][$url_term]."(".$count_url_term[$i]['url_term'].")',";
										$top_url_term.= 	$count_url_term[$i]['url_term'];
									}
								$top_url_term.= "],";
					
								}
							
							$i++;
						}
				return $top_url_term;

		}











// Display userid start
	function wpls_TopUser($userid)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $userid FROM $table GROUP BY $userid ORDER BY COUNT($userid) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($userid=="userid")
				{
					$count_userid = $wpdb->get_results("SELECT userid, COUNT(*) AS userid FROM $table GROUP BY userid ORDER BY COUNT(userid) DESC LIMIT 10", ARRAY_A);
				}

					$top_userid ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$userid]=="guest" || $result[$i][$userid]==NULL || $result[$i][$userid]==""  )
								{
					
								}
							else
								{
					
								
								if($userid=="userid")
									{
										$top_userid.= "['".$result[$i][$userid]."(".$count_userid[$i]['userid'].")',";
										$top_userid.= 	$count_userid[$i]['userid'];
									}
								$top_userid.= "],";
					
								}
							
							$i++;
						}
				return $top_userid;

		}









// Display url_id start
	function wpls_TopPages($url_id)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $url_id FROM $table GROUP BY $url_id ORDER BY COUNT($url_id) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($url_id=="url_id")
				{
					$count_url_id = $wpdb->get_results("SELECT url_id, COUNT(*) AS url_id FROM $table GROUP BY url_id ORDER BY COUNT(url_id) DESC LIMIT 10", ARRAY_A);
				}

					$top_url_id ="";
					$top_url_id .='<table class="para-data-table">';
					$top_url_id .='<tr><th style="width:80%">Link</th><th>Count</th></tr>';

					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$url_id]=="unknown" || $result[$i][$url_id]==NULL || $result[$i][$url_id]==""  )
								{
					
								}
							else
								{
									$top_url_id .="<tr>";
									
									if( is_numeric($result[$i][$url_id]))
										{
											$page_url = get_permalink($result[$i][$url_id]);
										}
									else
										{
											$page_url = $result[$i][$url_id];
										}
									$top_url_id .='<td><a href="'.$page_url.'">'.$page_url.'</a>';
									$top_url_id .="</td>";
									
									$top_url_id .="<td>".$count_url_id[$i]['url_id'];
									$top_url_id .="</td>";


									$top_url_id .="</tr>";
					
								}
							
							$i++;
						}
						
						$top_url_id .="</table>";
						
						
				return $top_url_id;

		}









// Display referer_doamin start
	function wpls_TopReferers($referer_doamin)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $referer_doamin FROM $table GROUP BY $referer_doamin ORDER BY COUNT($referer_doamin) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($referer_doamin=="referer_doamin")
				{
					$count_referer_doamin = $wpdb->get_results("SELECT referer_doamin, COUNT(*) AS referer_doamin FROM $table GROUP BY referer_doamin ORDER BY COUNT(referer_doamin) DESC LIMIT 10", ARRAY_A);
				}

					$top_referer_doamin ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$referer_doamin]=="none" || $result[$i][$referer_doamin]=="direct" || $result[$i][$referer_doamin]==NULL || $result[$i][$referer_doamin]==""  )
								{
					
								}
							else
								{
					
								
								if($referer_doamin=="referer_doamin")
									{
										$top_referer_doamin.= "['".$result[$i][$referer_doamin]."(".$count_referer_doamin[$i]['referer_doamin'].")',";
										$top_referer_doamin.= 	$count_referer_doamin[$i]['referer_doamin'];
									}
								$top_referer_doamin.= "],";
					
								}
							
							$i++;
						}
				return $top_referer_doamin;

		}











// Display city start
	function wpls_TopCities($city)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $city FROM $table GROUP BY $city ORDER BY COUNT($city) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($city=="city")
				{
					$count_city = $wpdb->get_results("SELECT city, COUNT(*) AS city FROM $table GROUP BY city ORDER BY COUNT(city) DESC LIMIT 10", ARRAY_A);
				}

					$top_city ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$city]=="unknown" || $result[$i][$city]==NULL || $result[$i][$city]==""  )
								{
					
								}
							else
								{
					
								
								if($city=="city")
									{
										$top_city.= "['".$result[$i][$city]."(".$count_city[$i]['city'].")',";
										$top_city.= 	$count_city[$i]['city'];
									}
								$top_city.= "],";
					
								}
							
							$i++;
						}
						
						
				return $top_city;

		}







// Display countryName start
	function wpls_TopCountries($countryName)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $countryName FROM $table GROUP BY $countryName ORDER BY COUNT($countryName) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($countryName=="countryName")
				{
					$count_countryName = $wpdb->get_results("SELECT countryName, COUNT(*) AS countryName FROM $table GROUP BY countryName ORDER BY COUNT(countryName) DESC LIMIT 10", ARRAY_A);
				}

					$top_countryName ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$countryName]=="unknown" || $result[$i][$countryName]==NULL || $result[$i][$countryName]==""  )
								{
					
								}
							else
								{
					
								
								if($countryName=="countryName")
									{
										$top_countryName.= "['".$result[$i][$countryName]."(".$count_countryName[$i]['countryName'].")',";
										$top_countryName.= 	$count_countryName[$i]['countryName'];
									}
								$top_countryName.= "],";
					
								}
							
							$i++;
						}
				return $top_countryName;

		}





// Display screensize start
	function wpls_TopScreenSize($screensize)
		{	
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $screensize FROM $table GROUP BY $screensize ORDER BY COUNT($screensize) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($screensize=="screensize")
				{
					$count_screensize = $wpdb->get_results("SELECT screensize, COUNT(*) AS screensize FROM $table GROUP BY screensize ORDER BY COUNT(screensize) DESC LIMIT 10", ARRAY_A);
				}

					$top_screensize ="";
					$i=0;
					while($total_rows>$i)
						{	
							if($result[$i][$screensize]=="unknown" || $result[$i][$screensize]==NULL || $result[$i][$screensize]==""  )
								{
					
								}
							else
								{
					
								
								if($screensize=="screensize")
									{
										$top_screensize.= "['".$result[$i][$screensize]."(".$count_screensize[$i]['screensize'].")',";
										$top_screensize.= 	$count_screensize[$i]['screensize'];
									}
								$top_screensize.= "],";
					
								}
							
							$i++;
						}
				return $top_screensize;

		}

	//screensize







		
	// Display Browser start
	function wpls_TopBrowsers($browser)
		{
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $browser FROM $table GROUP BY $browser ORDER BY COUNT($browser) DESC LIMIT 10", ARRAY_A);
			$total_rows = $wpdb->num_rows;

			if($browser=="browser")
				{
					$count_browser = $wpdb->get_results("SELECT browser, COUNT(*) AS browser FROM $table GROUP BY browser ORDER BY COUNT(browser) DESC LIMIT 20", ARRAY_A);
				}

			$top_browser ="";



			$i=0;

			while($total_rows>$i)
				{	
					if($result[$i][$browser]=="unknown" || $result[$i][$browser]==NULL || $result[$i][$browser]==""  )
						{

						}
					else
						{
							


							if($browser=="browser")
								{	
									$top_browser.= "['".$result[$i][$browser]."(".$count_browser[$i]['browser'].")',";
									$top_browser.= 	$count_browser[$i]['browser'];
								}
							$top_browser.= "],";

						}
		
					$i++;
				}
			return $top_browser;


		}


	// trace Browser








//query top operating system(Platform)
	function wpls_TopOS($platform)
		{
			global $wpdb;
			$table = $wpdb->prefix . "wpls";
			$result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
			$total_rows = $wpdb->num_rows;




			if($platform=="platform")
				{
					$count_platform = $wpdb->get_results("SELECT platform, COUNT(*) AS platform FROM $table GROUP BY platform ORDER BY COUNT(platform) DESC LIMIT 10", ARRAY_A);
				}

			$top_platform ="";

			$i=0;

			while($total_rows>$i)
				{	
					if($result[$i][$platform]==NULL || $result[$i][$platform]==""  )
						{

						}
					else
						{

							
							if($platform=="platform")
								{
									$top_platform.= "['".$result[$i][$platform]."(".$count_platform[$i]['platform'].")',";
									$top_platform.= $count_platform[$i]['platform'];
								}
							$top_platform.= "],";

						}
		
				$i++;
			}
		return $top_platform;
	}



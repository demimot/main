<?php
    /*************************************************************************
	   This is our 'front controler'
	   It is loaded on each request and
	   Treat all POST/GET request to deceid what page to show
	   populate all variables that page might need (content, styles, meta-data, links...)
	   choose which template to load (also a variable to be populated)
	   make everything available to smarty
	 *************************************************************************/
	
	// Set language or default language
	if(isset($_GET['lang']) and ($_GET['lang']=="en" or $_GET['lang']=="fr" or $_GET['lang']=="pt")) { 
	    $_SESSION['language'] = $_GET['lang']; 
	} elseif (!isset($_SESSION['language'])) $_SESSION['language'] = DMM_DEFAULT_LANGUAGE;
	
	/* try to log someone in if requested*/ 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' )
    { 
        /**** Submit forms MUST use a hidden field named frm_submit and with a value not equal to 0;
			  e.g. 1 = login form, 2 = other form... ****/
		if($location = post_handler($_POST)){
			header('Location: ' . $location); /* So one can use "back" to come to this page from other site they navigated to */
            exit;
		}
    }
	else
	{
		$_SESSION['form_xss'] = set_form_xss();
	}
	
	$smarty->assign('title', strip_tags(DMM_TITLE));
	
	if(isset($_GET['debug'])) $smarty->assign('debug', true);
	
	$not_demimot = strpos($_SERVER['HTTP_HOST'],"demimot.com")===false;
	$smarty->assign('not_demimot', $not_demimot);
	if($not_demimot and  $_SERVER['REQUEST_URI']=="/"){
		$slug_start = strpos($_SERVER['HTTP_HOST'],"www.");
		$slug_start = ($slug_start===false) ? 0 : 4;
		$slug_end = strpos($_SERVER['HTTP_HOST'],".",$slug_start) - $slug_start;
		$this_slug = substr($_SERVER['HTTP_HOST'],$slug_start, $slug_end);
		$_GET['ta'] = 1;
		$_GET['slug'] = $this_slug;
		$_GET['pid'] = NULL;
//		$smarty->assign('name', ucwords($this_slug) . " @ " . DMM_TITLE);
	}
	
	// default template...
	$currenttemplate = 'home.tpl';
    if(isset($_GET['ta']) and $_GET['ta']){
        switch ($_GET['ta']) {
			case 1:
			case 2:
			case 3:
			    if($thispub = get_pub_by_slug($_GET['slug'], $_GET['pid'])){ 
			        $smarty->assign('this_pub', $thispub);
			        $smarty->assign('title', $thispub['pub_name'] . " @ " .  strip_tags(DMM_TITLE));
                    $_SESSION['pub_issue_id']=$thispub['pub_issue_id']; 
        			/* Get Past issues*/

		        	$old_issues = get_old_issues($thispub['pub_id'], $thispub['pub_issue']);
			        $smarty->assign('old_issues', $old_issues);
            		if($not_demimot) $smarty->assign('name', ucwords($_GET['slug']) . " @ " . DMM_TITLE);
					
   				}else{
      	            page_not_found();
				}
				
			    if(isset($_GET['aslug']) and $_GET['aslug']) {
    			    if($this_content = get_article_by_pub_issue_slug($thispub['pub_issue_id'], $_GET['aslug'])){	
	    		        $smarty->assign('this_content', $this_content);
		    		    $currenttemplate = 'article.tpl';
			    	}else{
          	            page_not_found();
				    }
			    }
				else
				{
					$this_content = get_articles_by_issue($thispub['pub_issue_id']);
			        $smarty->assign('this_content', $this_content);
				    $currenttemplate = 'pub.tpl';	
				}
				break;
			case 5:
			    if(isset($_GET['piid']) and $_GET['piid']){ 
					if($thispub = pub_handler($_GET['piid'])) {
		                $smarty->assign('this_pub', $thispub);
						$smarty->assign('title', $thispub['pub_name'] . " @ " . strip_tags(DMM_TITLE));
                        $_SESSION['pub_issue_id'] = $thispub['pub_issue_id']; 
                        /* Get Past issues*/
    		        	$old_issues = get_old_issues($thispub['pub_id'], $thispub['pub_issue']);
	    		        $smarty->assign('old_issues', $old_issues);					
					}else{
      	                page_not_found();
				    }
	                if($this_content = get_article_by_id($_GET['artid'], 1)) { // passing 1 makes it ignore author id = session user id
                        $smarty->assign('this_content', $this_content);
                        $currenttemplate = "article.tpl";
		            }
					else{
          	            page_not_found();					
					}
				}else{
      	            page_not_found();
				}
			    break;
			case 6:
			case 7:
			    if(isset($_SESSION['user_id']) and $_SESSION['user_id']){
			        if($thispub = get_pub_by_slug($_GET['slug'], $_GET['pid'], 1)){ 
					    if($thispub['user_id']==$_SESSION['user_id']){
			                $smarty->assign('this_pub', $thispub);
			                $smarty->assign('title', $thispub['pub_name'] . " @ " . strip_tags(DMM_TITLE));
                            $_SESSION['pub_issue_id']=$thispub['pub_issue_id']; 
			                $smarty->assign('ispreview', true);
       		    
    			            if(isset($_GET['aslug']) and $_GET['aslug']) {
        		    	        if($this_content = get_article_by_pub_issue_slug($thispub['pub_issue_id'], $_GET['aslug'])){	
	            		            $smarty->assign('this_content', $this_content);
    	        	    		    $currenttemplate = 'article.tpl';
        		    	    	}else{
              	                    page_not_found();
			    	            }
    			            }
	    			        else
		    		        { 
        		    			$this_content = get_articles_by_issue($thispub['pub_issue_id']);
	        		            $smarty->assign('this_content', $this_content);
		        		        $currenttemplate = 'pub.tpl';	
    			    	    }
					    }else{
          	                page_not_found();
		    	        }
	                }else{
          	            page_not_found();
		    	    }
				}
				break;

			case 10:
                $currenttemplate = "terms.tpl";
			    break;
			case 11:
                $currenttemplate = "privacy_police.tpl";
			    break;
            case 100:
                if (isset($_GET['pubid']) and $_GET['pubid'] and isset($_SESSION['user_id'])){
	                if($_GET['pubid']=="new"){
                         $currenttemplate = "my_pub.tpl";
						 $smarty->assign('page_has_form', true);
						 $this_forms=array("frm_publication_form");
						 $smarty->assign('this_forms', $this_forms);
                         $pub_options['pub_types'] = get_pub_types( $_SESSION['language'] );
						 $pub_options['pub_income_status'] = get_pub_income_status( $_SESSION['language'] );
						 $smarty->assign('publication_options', $pub_options);
                    } 
                }
                break;
			case 101:
			    if (isset($_GET['pubid']) and $_GET['pubid'] and isset($_SESSION['user_id'])){
					if($this_pub = get_pub_by_pub_id($_GET['pubid'])) {
		                 $smarty->assign('this_publication', $this_pub);
		   				 $smarty->assign('no_edit', 0);
                         $pub_options['pub_types'] = get_pub_types( $_SESSION['language'] );
        				 $pub_options['pub_income_status'] = get_pub_income_status( $_SESSION['language'] );
						 $smarty->assign('publication_options', $pub_options);
                         $currenttemplate = "my_pub.tpl";
						 $smarty->assign('page_has_form', true);
						 $this_forms=array("frm_publication_form", "frm_pub_published_issue_form", "frm_pub_unpublished_issue_form", "frm_pub_css_form", "frm_pub_sections_form", "frm_pub_logo_form", "frm_pub_columns_form", "frm_pub_staff_form");
						 $smarty->assign('this_forms', $this_forms);
		            }
					else{
          	            page_not_found();					
					}
				}
                break;
			case 150:
			    if(isset($_GET['piid']) and $_GET['piid'] and isset($_SESSION['user_id'])){
                    if($this_issue = get_this_issue_data($_GET['piid'])){
					    $smarty->assign('this_issue', $this_issue);
                        $currenttemplate = "my_issue.tpl";
						$smarty->assign('page_has_form', true);
						$this_forms=array("frm_publish_issue_form", "frm_issue_css_form", "frm_issue_sections_form", "frm_cover_file_form", "frm_logo_file_form", "frm_pub_issue_section_articles_form", "frm_issue_article_image_form");
					    $smarty->assign('this_forms', $this_forms);
					}
					else{
       	                page_not_found();					
				    }
				}
                break;
			case 200:
			    if (isset($_GET['artid']) and $_GET['artid'] and isset($_SESSION['user_id'])){
	        	    if($_GET['artid']=="new"){
			            $currenttemplate = "my_article.tpl";
						$smarty->assign('page_has_form', true);
						$this_forms=array("frm_edit_article_form");
					    $smarty->assign('this_forms', $this_forms);
						$staff_of = get_pubs_of_contibuter($_SESSION['user_id']);
					    $smarty->assign('staff_of', $staff_of);		
                    } 
				}
                break;
			case 201:
			    if (isset($_GET['artid']) and $_GET['artid'] and isset($_SESSION['user_id'])){
					if($this_article = get_article_by_id($_GET['artid'])) {
						if($this_images = get_article_images($_GET['artid'])){
							$this_article['article_images'] = $this_images;
						}
		                $smarty->assign('this_article', $this_article);
						if($this_article['pub_issue_published']) $noedit=1;
                        $smarty->assign('no_edit', $noedit);
						if($this_article['article_spontaneous'] or !$this_article['article_issue_id']){
    						$staff_of = get_pubs_of_contibuter($_SESSION['user_id']);
	    				    $smarty->assign('staff_of', $staff_of);		
						}
						$currenttemplate = "my_article.tpl";
						$smarty->assign('page_has_form', true);
						$this_forms=array("frm_edit_article_form", "frm_article_image_form");
					    $smarty->assign('this_forms', $this_forms);
						
		            }
					else{
          	            page_not_found();					
					}
				}
                break;
			case 202:
			    if (isset($_GET['artid']) and $_GET['artid'] and isset($_SESSION['user_id'])){
					if($this_article = get_article_by_id($_GET['artid'])) {
						if($this_images = get_article_images($_GET['artid'])){
							$this_article['article_images'] = $this_images;
						}
		                $smarty->assign('this_article', $this_article);
		                $smarty->assign('no_edit', 1);
                        $currenttemplate = "my_article.tpl";
						//$this_forms=array("frm_edit_article_form"); // does not need.... read only
						//$smarty->assign('page_has_form', true);
		            }
					else{
          	            page_not_found();					
					}
				}
                break;
			case 300:
			    if (isset($_GET['usrid']) and $_GET['usrid'] and !isset($_SESSION['user_id'])){
                    if($this_user = get_user_data($_GET['usrid'])){
		                $smarty->assign('this_user', $this_user);
    					$currenttemplate = "new_user.tpl";
					}
				}
				break;
			case 301:
			    if (isset($_GET['usrid']) and $_GET['usrid'] and isset($_GET['ars']) and $_GET['ars'] and !isset($_SESSION['user_id'])){
                    if($activate_user = activate_user($_GET['usrid'], $_GET['ars'])){
                        if($this_user = get_user_data($_GET['usrid'])){
		                    $smarty->assign('this_user', $this_user);
    					    $currenttemplate = "new_user_valid.tpl";
					    }
					}
				}			    
			    break;
            case 404:
			    header("HTTP/1.0 404 Not Found");
                $currenttemplate = 'page404.tpl';
                break;
            case 900:
                $currenttemplate = 'login.tpl';
				$smarty->assign('page_has_form', true);
                break;
            case 901:
                if(isset($_SESSION['user_id'])) {
					unset($_SESSION['user_id']);
					$location = str_replace("/page-not-found", "", $_GET['loc']);
		    		header("Location: " . $location);
                    exit();
				}
                break;
            case 910:
                if(!isset($_SESSION['user_id'])) {
                    $currenttemplate = 'signup.tpl';
					$smarty->assign('page_has_form', true);
					$smarty->assign('recaptcha', true);
					$this_forms=array("user_registration");
					$smarty->assign('this_forms', $this_forms);
				}
                break;
			default:
			    page_not_found();
        }	
	}


    /* Now that we know if one is loged in or not ...*/
    if(isset($_SESSION['user_id']) and $_SESSION['user_id']){ 
        /* if logged in */
        /* links  and menu items */
        $log_in_out = "Logout";
		$log_in_out_url = "/logout?loc=" . urlencode($_SERVER['REQUEST_URI']);
		
		/* load pubs owned by user for admin links etc. */
		$smarty->assign('user_publications', have_pubs($_SESSION['user_id']));
		
        /* Load common user data */
        $smarty->assign('dmm_user', get_user_data($_SESSION['user_id']));
		
        $smarty->assign('your_unpublished_articles', get_unpublished_articles_by_author($_SESSION['user_id']));
		$smarty->assign('your_published_articles', get_published_articles_by_author($_SESSION['user_id']));
        
    }
	else
	{   /* links and menu items */
		$log_in_out = "Login";
		$log_in_out_url = "#";
	}

    $smarty->assign('LoginMenuUrl', $log_in_out_url );
	
	/* set the footer to DMM footer to show our footer
	   might change to include logic on what footer show 	*/
	$smarty->assign('current_footer_tpl', 'dmm_footer.tpl');
	
	/* populate array with featured publications for home page
	   This function will need some intel to decide what to bring to each user 	*/
    if($currenttemplate == 'home.tpl' or $currenttemplate == 'new_user.tpl' or $currenttemplate == 'new_user_valid.tpl' or $currenttemplate == 'page404.tpl')
	{
        $smarty->assign('current_featured', get_featured($_GET['search_pub']));
	};
	
	/* set the real template for BODY */
	$smarty->assign('current_pub_tpl', $currenttemplate);
	/*
	
	/* smarty default image path */
    $smarty->assign('default_img_path', default_image_dir ());	
	
	/* uri */
    $smarty->assign('called_uri', $_SERVER['REQUEST_URI']);
	
	/* test */
	$smarty->assign('teste', "<p>" . Slugfy("My Session ID : ","'") . session_id () . " - remove this on " . __FILE__ . "</strong> line <strong>" . __LINE__ . "</strong></p>");

    $smarty->assign('date_format', DMM_DATE_FORMAT);
	$smarty->assign('smarty_date_format', SMARTY_DATE_FORMAT);
	
	
	/* Link of Login Menu */
	$smarty->assign('LoginMenu', $log_in_out);

	?>
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
	
	$smarty->assign('title', "DemiMot");
	
	// default template...
	$currenttemplate = 'home.tpl';
    if(isset($_GET['ta']) and $_GET['ta']){
        switch ($_GET['ta']) {
			case 1:
			case 2:
			case 3:
			    if($thispub = get_pub_by_slug($_GET['slug'], $_GET['pid'])){ 
			        $smarty->assign('this_pub', $thispub);
			        $smarty->assign('title', $thispub['pub_name'] . "@DemiMot");
                    $_SESSION['pub_issue_id']=$thispub['pub_issue_id']; 
        			/* Get Past issues*/

		        	$old_issues = get_old_issues($thispub['pub_id'], $thispub['pub_issue']);
			        $smarty->assign('old_issues', $old_issues);
					
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
						$smarty->assign('title', $thispub['pub_name'] . "@DemiMot");
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
            case 100:
                if (isset($_GET['pubid']) and $_GET['pubid'] and isset($_SESSION['user_id'])){
	                if($_GET['pubid']=="new"){
                         $currenttemplate = "my_pub.tpl";
						 $smarty->assign('page_has_form', true);
						 $this_forms=array("frm_publication_form");
						 $smarty->assign('this_forms', $this_forms);

                    } 
                }
                break;
			case 101:
			    if (isset($_GET['pubid']) and $_GET['pubid'] and isset($_SESSION['user_id'])){
					if($this_pub = get_pub_by_pub_id($_GET['pubid'])) {
		                $smarty->assign('this_publication', $this_pub);
						$smarty->assign('no_edit', 0);
						
						$this_pub_sections = get_sections_from_template_by_pub($_GET['pubid']);
						$smarty->assign('this_pub_sections', $this_pub_sections);
						
						$this_pub_unpublished_issues = get_issues_by_pub($_GET['pubid']);
						$smarty->assign('unpublished_issues', $this_pub_unpublished_issues);

						$this_pub_published_issues = get_issues_by_pub($_GET['pubid'], 1);
						$smarty->assign('published_issues', $this_pub_published_issues);

                        $this_pub_columns = get_columns_by_pub($_GET['pubid']);
						$smarty->assign('this_pub_columns', $this_pub_columns);

                        $this_pub_staff = get_staff_by_pub($_GET['pubid']);
						$smarty->assign('contributors', $this_pub_staff);						
						
						
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
						$this_forms=array("frm_publish_issue_form", "frm_issue_css_form", "frm_issue_sections_form", "frm_cover_file_form", "frm_logo_file_form");
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
			            $currenttemplate = "new_article.tpl";
						$smarty->assign('page_has_form', true);
						$this_forms=array("frm_edit_article_form");
					    $smarty->assign('this_forms', $this_forms);
                    } 
				}
                break;
			case 201:
			    if (isset($_GET['artid']) and $_GET['artid'] and isset($_SESSION['user_id'])){
					if($this_article = get_article_by_id($_GET['artid'])) {
		                $smarty->assign('this_article', $this_article);
		                $smarty->assign('no_edit', 0);
                        $currenttemplate = "new_article.tpl";
						$smarty->assign('page_has_form', true);
						$this_forms=array("frm_edit_article_form");
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
		                $smarty->assign('this_article', $this_article);
		                $smarty->assign('no_edit', 1);
                        $currenttemplate = "new_article.tpl";
						$smarty->assign('page_has_form', true);
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
		$log_in_out_url = "/login";
	}

    $smarty->assign('LoginMenuUrl', $log_in_out_url );
	
	/* set the footer to DMM footer to show our footer
	   might change to include logic on what footer show 	*/
	$smarty->assign('current_footer_tpl', 'dmm_footer.tpl');
	
	/* populate array with featured publications for home page
	   This function will need some intel to decide what to bring to each user 	*/
    if($currenttemplate == 'home.tpl' or $currenttemplate == 'new_user.tpl' or $currenttemplate == 'new_user_valid.tpl')
	{
        $smarty->assign('current_featured', get_featured());
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

	/* Start bringing from CMS DB */
	switch ($_SESSION['language']) {
    case "fr":
        $smarty->assign('LoginMenu', $log_in_out );
        $smarty->assign('InfoMenu', 'Infos');
        $smarty->assign('NewsMenu', 'Actualités');
        $smarty->assign('CalendarMenu', 'Calendrier');
        $smarty->assign('ResultsMenu', 'Résultats');
        $smarty->assign('MediaMenu', 'Médias');
        $smarty->assign('GalleryMenu', 'Galleries');
        $smarty->assign('VideoMenu', 'Vidéos');
        $smarty->assign('AboutMenu', 'À propos');
        $smarty->assign('WhoMenu', 'Qui sommes nous');
        $smarty->assign('ContactMenu', 'Contact');
        $smarty->assign('SocialMenu', 'Engagement social');
        break;
    case "en":
        $smarty->assign('LoginMenu', $log_in_out);
        $smarty->assign('InfoMenu', 'Info');
        $smarty->assign('NewsMenu', 'News');
        $smarty->assign('CalendarMenu', 'Calendar');
        $smarty->assign('ResultsMenu', 'Results');
        $smarty->assign('MediaMenu', 'Media');
        $smarty->assign('GalleryMenu', 'Galeries');
        $smarty->assign('VideoMenu', 'Videos');
        $smarty->assign('AboutMenu', 'About us');
        $smarty->assign('WhoMenu', 'Whow we are');
        $smarty->assign('ContactMenu', 'Contact');
        $smarty->assign('SocialMenu', 'Social Engagement');
        break;
    case "pt":
        $smarty->assign('LoginMenu', $log_in_out);
        $smarty->assign('InfoMenu', 'Informações');
        $smarty->assign('NewsMenu', 'Notícias');
        $smarty->assign('CalendarMenu', 'Calendário');
        $smarty->assign('ResultsMenu', 'Resultados');
        $smarty->assign('MediaMenu', 'Media');
        $smarty->assign('GalleryMenu', 'Galerias');
        $smarty->assign('VideoMenu', 'Vídeos');
        $smarty->assign('AboutMenu', 'Sobre nós');
        $smarty->assign('WhoMenu', 'Quem somos');
        $smarty->assign('ContactMenu', 'Contatos');
        $smarty->assign('SocialMenu', 'Engajamento Social');
        break;
	default :         $smarty->assign('LoginMenu', 'Language not supported');
    }

	?>
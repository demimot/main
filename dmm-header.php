<?php
    /*************************************************************************
	
	   This would be our front controler
	   
	   It should be loaded on each request and
	   
	   Treat all POST/GET request to deceid what page to show
	   
	   populate all variables that page might need (content, styles, meta-data, links...)
	   
	   choose which template to load (also a variable to be populated)
	   
	   make everything available to smarty
	   
	   
	 *************************************************************************/
	
	// Set language or default language
	if(isset($_GET['lang']) and ($_GET['lang']=="en" or $_GET['lang']=="fr" or $_GET['lang']=="pt")) { 
	    $_SESSION['language'] = $_GET['lang']; 
	} elseif (!isset($_SESSION['language'])) $_SESSION['language'] = $default_language;
	
	if(!isset($_SESSION['form_xss']))	{ // anti xss initialization for any POST forms
        $_SESSION['form_xss'] = set_form_xss();
    }
	
	/* try to log someone in if requested*/ 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' )
    { 
        /**** Submit forms MUST use a hidden field named frm_submit and with a value not equal to 0;
			  1 = login form
			  2 = other form...
		****/
		if($location = post_handler($_POST)){
			 
			header('Location: /' . ($location == 1 ? "" : $location));/* So one can use "back" to come to this page from other site they navigated to */
            exit;
		}
    }

    $smarty->assign('teste', "<p><strong>injection test</strong> css from pub_css.php - This line content is being set on <strong>". __FILE__ . "</strong> line <strong>" . __LINE__ . "</strong></p>");
	
	$smarty->assign('title', "DemiMot");
	
   // Try to GET the template for the current issue of the current publication
   if(isset($_GET['piid']) and $_GET['piid']){
		if($thispub=pub_handler($_GET['piid'])){ 
			$smarty->assign('this_pub', $thispub);
			$smarty->assign('title', $thispub['pub_name'] . "@DemiMot");
            $_SESSION['pub_issue_id']=$thispub['pub_issue_id'];
			
			/* alterar funçao para que retorne array de artigos, fotos, etc ... */		
			$this_content = article_handler($thispub['pub_issue_id']);
			$smarty->assign('this_content', $this_content);
			
			/* Get Past issues*/
			$old_issues = get_old_issues($thispub['pub_id'], $thispub['pub_issue']);
			$smarty->assign('old_issues', $old_issues);
			
			// set template
			$currenttemplate = 'pub.tpl';
		}elseif($_GET['piid']="BBBB") { /* to be removed... leftovers from beggining of dev */
	        $currenttemplate = 'test1.tpl';
		} else $currenttemplate = 'home.tpl';		
	} elseif (isset($_GET['artid']) and $_GET['artid']) { /* AND check article ownership or delegation */
	    /* prepare article stuff to load on the template
		   New article (empty fields)
		   Edit article (bring from db)
		   ...
		   Approved? flag
		   Ready? flag
		   publishing is not done by the authro but by the editor... don't forget to mark article as published, timestamp, etc
		  */
        $currenttemplate = "new_article.tpl";
	} else {
		$currenttemplate = 'home.tpl';
	}
    
	if(isset($_GET['login']) and $_GET['login'] and !$_SESSION['user_id']){
        $currenttemplate = 'login.tpl';
		$_GET['login']=0;
		unset($_GET['login']);
	} elseif(isset($_GET['logout']) and $_GET['logout']){
		$_GET['logout']=0;
		unset($_GET['logout']);
		$smarty->assign('user_id',1);
		if(isset($_SESSION['user_id'])){
		    unset($_SESSION['user_id']);
			/*session_unregister('user_id'); - deprecated */
		};
	}
    
    /* Now that we know if one is loged in or not ...*/
    if(isset($_SESSION['user_id']) and $_SESSION['user_id']){ 
	    /* if logged in */
		/* links  and menu items */
		$log_in_out = "Logout";
		$log_in_out_url = (isset($_GET['piid']) and $_GET['piid']) ? $log_in_out_url = "logout=1&piid=" . $_GET['piid'] : "logout=1";
		
		/* load pubs owned by user for admin links etc. */
		$smarty->assign('user_publications', have_pubs($_SESSION['user_id']));
		
        /* Load common user data */
        $smarty->assign('dmm_user', get_user_data($_SESSION['user_id']));
        
    }
	else
	{   /* links and menu items */
		$log_in_out = "Login";
		$log_in_out_url = "login=1";
	}

    $smarty->assign('LoginMenuUrl', $log_in_out_url );
	/* sets the footer to DMM footer to show our footer
	   might change to include logic on what footer show
	*/
	$smarty->assign('current_footer_tpl', 'dmm_footer.tpl');
	
	/* test for url injections 
	   display smarty $injection var somewhere and check if a tag or sql command made it through
	   like...

	   http://www.demimot.com/?inject=%3Cscript%3Eaaaaa%3C/script%3E

       Then display on some .tpl with 
	   
	   <p><!--[$inject]--></p>
	*********************************************************************
	   
	$smarty->assign('inject', $_GET['inject']);
	
	*/
	
	/* populate array with featured publications for home page
	   This function will need some intel to decide what to bring to each user
	*/
    if($currenttemplate == 'home.tpl')
	{
         $smarty->assign('current_featured', get_featured());
	};
	
	/* set the real template for BODY */
	$smarty->assign('current_pub_tpl', $currenttemplate);
	/*
	
	/* smarty default image path */
    $smarty->assign('default_img_path', default_image_dir ());	
	
	
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
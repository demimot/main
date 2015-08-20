<?php require($_SERVER["DOCUMENT_ROOT"] . '/config/dmm_config.php');
      require($_SERVER["DOCUMENT_ROOT"] . '/smarty/libs/Smarty.class.php');
      $smarty = new Smarty();    
      require($_SERVER["DOCUMENT_ROOT"] . '/smarty/configs/smartyconf.php');
	  require($_SERVER["DOCUMENT_ROOT"] . '/vatrack/VATrack.php');
	  $smarty->assign('name', 'DemiMot');

      /* Clean up all POST/GET variable agains JS/SQL injection; */ 

      foreach($_POST as $key => $value) {
          $_POST[$key] = clean_arrayorstring($value);
      }
	  foreach($_GET as $key => $value) {
          $_GET[$key] = clean_arrayorstring($value);
      }

      /* the actual front controller to load everything a page could ever want */
      include "dmm-header.php";

      /* Track user activity */
      VATrack();


	  /* Show View */
	  
	  /* 
	      Elaborate.... cache only when $_SERVER['REQUEST_URI'] has '/' in it to avoid caching read-publication uris that should always bring the latest issue... ???? 
	      or test IF there is 'read-publication' AND '/' Then do not pass $my_cache_id ELSE pass cache $my_cache_id
	 
	  $my_cache_id = $_SERVER['REQUEST_URI'];
	  $my_cache_id = str_replace('/','|',$my_cache_id);
	  
	  Also will need to use:
	  
	  <!--[dynamic]-->
	   dynamic content
	  <!--[/dynamic]-->
	  
	  Or even the left and right blocks won't change if you login or out for instance...
	  
	  maybe cache only pages of pub/issues and pub/issues/articles ... that's what would bring the performance...
	  
	  Not to mention changing languages for instance...
	  
	  orrrrrr
	  
	  forget rui and use the GET/POST parameters to decide whether and what to cache...
	  
	  long working hours ahead.... right now cache is off on smarty/configs/smartyconf.php
	   */

	  $smarty->display('index.tpl', $my_cache_id); 
?>
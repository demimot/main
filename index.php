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
	  $smarty->display('index.tpl'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $HEADER_TITLE ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="<?php echo $THEME_FOLDER ?>/css/style.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $THEME_FOLDER ?>/js/jquery-ui/css/cupertino/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo $THEME_FOLDER ?>/js/jquery-ui/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="<?php echo $THEME_FOLDER ?>/js/jquery-ui/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <!--Script de fancybox-->
	<script type="text/javascript" src="<?php echo $THEME_FOLDER ?>/js/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?php echo $THEME_FOLDER ?>/js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $THEME_FOLDER ?>/js/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

        <script language="javascript">
            function mostrar(b,s,p){
                b2 = document.getElementById(b);
                s2 = document.getElementById(s);
                p2 = document.getElementById(p);
                p2Aux = "p."+p
		
                if(b2.style.display == "none") {
                    p2.style.display = "none";
                    b2.style.display = "inline";
                    s2.style.display = "inline";
			
                } else {
                    b2.style.display = "none";
                    s2.style.display = "none";
                    $(p2Aux).addClass("ohmy").show("slow");			
                }
            }
        </script>
    </head>
    <body>
        <div class="main">
            <div class="main_resize">
                <div class="header">
                    <div class="logo">
                        <a href="<?php echo base_url() ?>"><span class="al">Al</span><span class="dia">dia</span></a>
                        <br />
                        <span class="eslogan">Su proyecto al alcance de todos</span>
                    </div>

                    <?php
                    if (user_is_login()) {
                        get_sidebar('user-menu');
                    }
                    ?>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>

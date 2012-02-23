<?php
/*
Plugin Name: Dynamic Content generator
Plugin URI: http://www.talk2.com.br
Description: Plugin que genrencia e desenvolve páginas estáticas de listas personalizadas.
Version: 0.1
Author: Talk2 - Marcelo Vitorino - Felipe Signorini
Author URI: http://www.talk2.com.br/
*/

/*  Copyright 2011  Talk2 - Marcelo Vitorino e Felipe Signorini (email: felipe.klerk@talk2.com.br)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
*/

/* --- globa variables --- */
define('DDC_VERSION', '0.1');
define('DDC_PATH', WP_PLUGIN_URL.'/dynamic-content');
define('DDC_NAME', plugin_basename(dirname(__FILE__)) );

require_once(dirname(__FILE__) .'/class-ddc-model.php');
require_once(dirname(__FILE__) .'/class-ddc-manage.php');
require_once(dirname(__FILE__) .'/class-ddc-filter.php');
require_once(dirname(__FILE__) .'/class-ddc-connection-plugins.php');

require_once(dirname(__FILE__) .'/class-ddc-widgets.php');
require_once(dirname(__FILE__) .'/ddc-single-list.php');


/* --- Create a post type Dynamic Content and taxonomie --- */
require_once(dirname(__FILE__) .'/ddc-post-types.php');

/* --- creat a meta box to new custom post type --- */
require_once(dirname(__FILE__) .'/ddc-metabox.php'); 


/* --- inizalittaion plugin -- */
$ddc=new ddc_manage();





?>
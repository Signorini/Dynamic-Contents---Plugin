<?php 

class ddc_manage {
    function __construct () {
      add_action('admin_print_scripts', array($this, 'ddc_scripts'));
      add_action('admin_print_styles', array($this, 'ddc_styles'));
      
      add_action('admin_menu', array($this, 'ddc_menu'));
    }
    
    
    /**
    * 
    * Construction a view generator
    */
    function get_view($view=null) {
      if(!empty($view))
      {
        $url='/views/ddc-'.$view.'.php';
        require_once(dirname(__FILE__) .$url);
      }
    }
  
  
  
    /**
    * 
    * Registro do menu
    */
    function ddc_menu()
    {
     add_submenu_page('edit.php?post_type=content_list', 'Settings', 'Settings', 'manage_options', 'ddc-settings', array($this,'ddc_settings'));
    }
    
    
    /**
    * 
    * Métodos para criação das paginas do menu de configuracao, bastando somente um get_view para puxar seu devido html
    */
    function ddc_settings () {
      $this->get_view('setting');
    }

    
    
   /**
   * 
   * Métodos para controle de entrada de js e css do plugin
   */
  function ddc_styles() {
    wp_enqueue_style('ddc-style-admin', DDC_PATH . '/css/ddc-style-admin.css');
  }
    
  function ddc_scripts() {
    wp_register_script('ddc-scripts-admin', DDC_PATH.'/js/ddc-script-admin.js', array('jquery'));
    wp_enqueue_script('ddc-scripts-admin');
  }
  
}


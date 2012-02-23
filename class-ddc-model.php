<?php 

class ddc_model {
    
   public static function add_setting($dados,$campo) {
       $check=self::get_setting($campo);
       
       if(is_null($check)) {
           self::insert_setting($dados,$campo);
       } else {
           self::update_setting($dados,$campo);
       }
       
       return true;
   }
   
   public static function insert_setting($dados,$campo) {
     return add_option($campo, $dados);
   }
   
   public static function update_setting($dados,$campo) {
       return update_option($campo, $dados);
   }
   
   public static function get_setting($campo) {
       return get_option( $campo, null );
   }
    
}


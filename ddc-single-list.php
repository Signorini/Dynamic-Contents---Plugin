<?php

class ddc_list {
    
    public static function get_choosens($list_id) {
        $list=get_transient('ddc_posts_cache_'.$list_id);
        
        if(false===$list) {
            $option=get_post_meta($list_id, '_ddc_meta_options', true);
            $filter=new ddc_filter($option['filter']);
            $filter->apply_filter();
            $list=$filter->get_choosens(); //return os post escolhidos
            
            set_transient('ddc_posts_cache_'.$list_id, $list);
        }
        
        return $list;
    }
    
    public static function get_post_args($list_id=null) {
        if(empty($list_id)) {
            $list_id=get_the_ID();
        }
        $list=self::get_choosens($list_id);
        $option=ddc_model::get_setting('ddc_setting');
        $args=array(
          'post__in'=>$list,
          'posts_per_page'=>$option['pag'],
          'paged'=>get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1
        );
        
        return $args;
    }
    
    public static function template_control() {
        if(is_single()) {
            global $post;
            
            if(get_post_type($post->ID)=='content_list') {
                $args=ddc_list::get_post_args();
                query_posts($args);
                
                if(file_exists(TEMPLATEPATH.'/archive-ddc.php')) {
                    include (TEMPLATEPATH . '/archive-ddc.php');
                    exit;
                }
                
                include (TEMPLATEPATH.'/archive.php');
                exit;
            }
        }
    }
    
}

add_action('template_redirect', array('ddc_list','template_control'));

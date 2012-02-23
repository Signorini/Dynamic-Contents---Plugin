<?php
add_action('admin_init','ddc_creat_metabox');
function ddc_creat_metabox() {
    add_meta_box('ddc-meta', 'Settings this list', 'ddc_meta_setup', 'content_list', 'normal', 'high');
    // add a callback function to save any data a user enters in
    add_action('save_post','ddc_meta_save');
}

function ddc_meta_setup() {
    global $post;
 
    // using an underscore, prevents the meta variable
    $meta = get_post_meta($post->ID,'_ddc_meta_options',TRUE);
    if(!isset($meta['filter']['keyword']) || sizeof($meta['filter']['keyword'])<=1) {
        $meta['filter']['keyword'][0]='';
        $meta['filter']['role'][0]=0;
    }
 
    // instead of writing HTML here, lets do an include
    include(dirname(__FILE__).'/views/ddc-metabox.php');
 
    // create a custom nonce for submit verification later
    echo '<input type="hidden" name="ddc_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}

function ddc_meta_save($post_id) {
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['ddc_noncename'],__FILE__)) return $post_id;
    
    // check user permissions
    if ($_POST['post_type'] == 'content_list') {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
 
    $current_data = get_post_meta($post_id, '_ddc_meta_options', TRUE); 
    $new_data = $_POST['_ddc_meta_options'];
    
    my_meta_clean($new_data);
    // seleciona os posts que se apliquem ao filtro feito
    $filter=new ddc_filter($new_data['filter']);
    $filter->apply_filter();
    $choosen=$filter->get_choosens(); //return os post escolhidos
    
    set_transient('ddc_posts_cache_'.$post_id, $choosen);
    

    if ($current_data) {
        if (is_null($new_data)) delete_post_meta($post_id,'_ddc_meta_options');
        else update_post_meta($post_id,'_ddc_meta_options',$new_data);
    } elseif (!is_null($new_data)) {
        add_post_meta($post_id,'_ddc_meta_options',$new_data,TRUE);
    }
 
    return $post_id;
}

/**
 * 
 * &$arr novo post da meta tag, usada para eliminar os dados em brancos corretamente.
 */
function ddc_clean_filter(&$arr) {
    if(isset($arr['filter']['keyword']) && is_array($arr['filter']['keyword'])) {
         foreach($arr['filter']['keyword'] as $i => $v) {
             if(trim($v)=='') {
                 unset($arr['filter']['role'][$i]);
                 unset($arr['filter']['keyword'][$i]);
             }
         }
     }
}


function my_meta_clean(&$arr) {
    ddc_clean_filter(&$arr);
    
    if (is_array($arr)) {
        foreach ($arr as $i => $v)
        {
            if (is_array($arr[$i]))
            {
                my_meta_clean($arr[$i]);
 
                if (!count($arr[$i]))
                {
                    unset($arr[$i]);
                }
            }
            else
            {
                
                if (trim($arr[$i]) == '')
                {
                    unset($arr[$i]);
                }
            }
        }
 
        if (!count($arr))
        {
            $arr = NULL;
        }
    }
}

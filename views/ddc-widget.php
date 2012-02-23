<?php

$cache='ddc-wdget-'.sanitize_title_with_dashes($title);
$html= get_transient($cache);

if(false===$html) {
    if (!empty($title))
        echo $before_title . $title . $after_title;
    
    //criação dos box de categorias e seleções
    if (!empty($catsele)) {
        $catsele = unserialize($catsele);
        $qargs = array('post_type' => 'content_list', 'tax_query' => array( array('taxonomy' => 'content_organizer', 'field' => 'slug', 'terms' => 'all')));
        
        $html = '<ul class="box-link">';
        foreach ($catsele as $value) {
            $term = get_term_by('name', $value, 'content_organizer');
            $slug = $term -> slug;
        
            $html .= '<li>';
            $html .= '<h4>' . $value . '</h4>';
            $qargs['tax_query'][0]['terms'] = $slug;
            $query = new WP_Query($qargs);
        
            if ($query -> have_posts()) :
                while ($query -> have_posts()) : $query -> the_post();
                    $list_id=get_the_ID();
                    $content=ddc_list::get_choosens($list_id);
                    if(!empty($content)) {
                    $html .= '<a href="' . get_permalink() . '" alt="' . get_the_title() . '">' . get_the_title() . '</a>';
                    }
                endwhile;
            endif;
        
            $html .= '</li>';
        }
        $html .= '</ul>';
        set_transient($cache,$html);
    }
}
echo $html;
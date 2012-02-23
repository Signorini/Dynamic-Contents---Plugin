<?php 
class ddcWidgets extends WP_Widget {
  function ddcWidgets() {
        parent::__construct(
            'ddc_widget', // Base ID
            'DDC - Links Box', // Name
            array( 'description' => __( 'Create a box with all dynamic content.', 'ddc' ), ) // Args
        );
  }
  
  
  function form($instance) {
        $title = esc_attr( $instance['title']);
        $sele=$instance['widget-cat'];

        if(!empty($sele)) {
            $sele=unserialize($sele);
        } else {
            $sele='all';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Título:' ); ?></strong></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <br/>
        <p>
            <label for="<?php echo $this->get_field_id( 'categorie' ); ?>"><strong><?php _e( 'Blocos inclusos:' ); ?></strong></label> 
            <ul>
            <?php
                $cat=get_terms('content_organizer');
              
                foreach($cat as $value) {
                    $checked='';
                    $slug=$value->name;
                    if($sele=='all' || in_array($slug, $sele)) {
                        $checked='checked="checked"';
                    }
                    echo '<li>';
                    echo '<span>'.$value->name.'</span>';
                    echo '<input class="checkers" '.$checked.' id="'.$this->get_field_name('widget-cat').'" name="'.$this->get_field_name('widget-cat').'[]" type="checkbox" value="'.$value->name.'"/>';
                    echo '</li>';
                }
            ?>
            </ul>
        </p>
        <?php 
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
    delete_transient('ddc-wdget-'.sanitize_title_with_dashes($instance['title']));
  
    $instance['widget-cat'] = serialize($new_instance['widget-cat']);
    return $instance;
  }

  function widget($args, $instance) {
    extract( $args );
    
    $title = apply_filters( 'widget_title', $instance['title'] );
    $catsele=$instance['widget-cat'];
    
    echo $before_widget;
        require_once(dirname(__FILE__).'/views/ddc-widget.php');
    echo $after_widget;
  }

}

add_action( 'widgets_init', create_function( '', 'register_widget( "ddcWidgets" );' ) );
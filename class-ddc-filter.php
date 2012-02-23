<?php 

class ddc_filter {
    private $choosens=array();
    private $filters=array();
    private $ky=1;
    private $opt;
    
    function __construct($filter) {
        $this->opt=get_option('ddc_setting', 'medio');
        
        foreach ($filter['role'] as $key=>$status) {
            switch($status) {
                case 0:
                    $this->filters['positive'][]=strtolower($filter['keyword'][$key]);
                break;
                case 3:
                    $this->filters['negative'][]=strtolower($filter['keyword'][$key]);
                break;
                case 2:
                    $this->filters['tag']=$this->prepare_gomma($filter['keyword'][$key], 'tag', '+');
                break;
                case 1:
                    $this->filters['categorie']=$this->prepare_gomma($filter['keyword'][$key], 'categorie', '+');
                break;
                case 4:
                    $this->filters['postype']=$this->prepare_posttype($filter['keyword'][$key]);
                break;
            }
        }
        
    }

    function prepare_posttype($post) {
         if($post=='all') {
           $args=array('rewrite'=>true,'public'=> true, '_builtin' => false);
           $types=get_post_types($args,'names');
           $eli=array_search('content_list', $types);
           if($eli) {
             unset($types[$eli]);
           }
           $types[]='post';
         } else {
           $types=$post;
         }
         
         return $types;
    }
    
    function prepare_gomma($slug,$cat,$separator=', ') {
        $tmp=$this->filters[$cat];
     
        if(!empty($tmp)) {
            $tmp.=$separator;
        }
        
        $tmp=$tmp.''.$slug;
        return $tmp;
    }
   
    
    function apply_filter() {
        query_posts($this->get_params());
            if ( have_posts() ) :
                while (have_posts()) : the_post();
                    $mathp=0;
                    $divider=0;
                    $id=get_the_ID();
                    
                    $conteudo=$this->density_keyword(get_the_content());
                    $conteudo['titles'].=' '.strtolower(get_the_title());
                   
                    if(in_array('titulos',$this->opt['campos'])) {
                        $mathp+=$this->count_density($conteudo['titles'],$this->filters['positive'],6);
                        $mathp-=$this->count_density($conteudo['titles'],$this->filters['negative'],6,-1);
                        $divider++;
                    }
                     
                    if(in_array('metatags',$this->opt['campos'])) {
                        $title=ddc_plugins::get_content_meta($id, 'title');
                        $desc=ddc_plugins::get_content_meta($id, 'description');
                        $metacontent=strtolower($title.$desc);
                       
                        if(!empty($desc) && !empty($title)) {
                            $divider++;
                            $mathp+=$this->count_density($metacontent,$this->filters['positive'],4);
                            $mathp-=$this->count_density($metacontent,$this->filters['negative'],4,-1);
                        }
                    }
 
                    if(in_array('contents',$this->opt['campos'])) {
                        $mathp+=$this->count_density($conteudo['contents'], $this->filters['positive']);
                        $mathp-=$this->count_density($conteudo['contents'], $this->filters['negative'],1,-1);
                        $divider++;
                    }
               
                    if($this->nivel_entrace()<=($mathp/$divider)) {
                        $this->choosens[]=$id;
                    }
                    set_time_limit(0);
                endwhile;
            endif;
         
        wp_reset_query();
    }

    function get_params() {
        $arg=array(
            'posts_per_page'=>'10',
            'post_type' => $this->filters['postype']
        );
               
        if(!empty($this->filters['categorie'])) {
            $arg['category_name']=$this->filters['categorie'];
        }
          
        if(!empty($this->filters['tag'])) {
            $arg['tag']=$this->filters['tag'];
        }
        
        return $arg;
    }

    function density_keyword($content) {
        $density=0;
        $content=str_replace(array("\r","\n","\r\n","  "), " ", $content);
        $content=strtolower(trim($content));
        
        $sepp=$this->separe_titles($content);
        $sepp['contents']=strip_tags($sepp['contents']);
        
        return $sepp;
    }
    
    function separe_titles($html) {
        $pattern="{<h[0-9][^>]*>(.*?)</h[0-9]>.}";
        preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
          
        $tt['titles']=implode($matches[1],' ');
        $tt['contents']=preg_replace($pattern,'',$html);
        return $tt;
    }
    
    function count_density($string,$keywords,$multiplier=1) {
        $n=0;
        if(is_array($keywords)) {
          foreach($keywords as $word) {
            $n+=substr_count($string,$word);  
          }
        }
      
        return (int)($n*$multiplier);
    }
    
    function nivel_entrace() {
        $parameter=array('baixa'=>1,'media'=>3,'alta'=>7);
        return  $parameter[$this->opt['dencidade']];
    }
    
    function get_choosens() {
        return $this->choosens;
    }
}


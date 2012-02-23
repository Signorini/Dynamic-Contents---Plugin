<div class="my_meta_control">
 <div class="ddc-wrapper">
    <div class="ddc-wrapper">
    <label>Label da Lista</label>
    
        <input class="ddc-text" type="text" name="_ddc_meta_options[label]" value="<?php if(!empty($meta['label'])) echo $meta['label']; ?>"/>
        <span>Como será representado a lista.</span>
    </div>
 
 
    <div class="ddc-wrapper">
    <p><strong>Personalizar listas</strong> <span>(filtragem)</span></p>
    

   <div class="ddc-left-filter">Regra</div>
   <div class="ddc-right-filter">Keyword</div>
   
    
    <ul id="filter-list">
        <?php
  
            foreach($meta['filter']['keyword'] as $key=>$value):
                $role=(int)$meta['filter']['role'][$key];
                if($role!==4) :
            ?>
          <li>
              <div class="ddc-left-filter">
                    <select name="_ddc_meta_options[filter][role][]">
                        <option value="0" <?php echo $role==0?'selected="selected"':'';?>>Contiver</option>
                        <option value="1" <?php echo $role==1?'selected="selected"':'';?>>Contiver na categoria</option>
                        <option value="2" <?php echo $role==2?'selected="selected"':'';?>>Contiver na tag</option>
                        <option value="3" <?php echo $role==3?'selected="selected"':'';?>>Não Contiver</option>
                    </select>
                </div>
                
                <div class="ddc-right-filter">
                    <input class="ddc-text" type="text" name="_ddc_meta_options[filter][keyword][]" value="<?php echo $value?>"/>
                    <a href="#Deletar" title="Deletar" class="ddc-bt"><img src="<?php echo DDC_PATH.'/img/dele.png'; ?>" alt="Deletar"/></a>
                </div>
                
            </li>
            <?php 
            endif;
            endforeach;
        ?>
    </ul>
    
    <ul>
        <li>
          <div class="ddc-left-filter">
                <select name="_ddc_meta_options[filter][role][]">
                    <option value="4" selected="selected">Post Type</option>
                </select>
            </div>
            
            <div class="ddc-right-filter">
                <?php
                 $d=null;
                 $pos=array_search(4,$meta['filter']['role']);
                 if($pos) {
                     $d=$meta['filter']['keyword'][$pos];
                 }
                 ?>
               <select name="_ddc_meta_options[filter][keyword][]">
                   
                   <option value="all" <?php echo $d=='all'?'selected="selected"':'';?>>Todos</option>
                   <option value="post" <?php echo $d=='post'?'selected="selected"':'';?>>Posts</option>
                    <?php
                    $args=array('rewrite'=>true,'public'=> true);
                    $posts=get_post_types($args,'object');
                    foreach($posts as $post) {                        
                        if($post->rewrite['slug']!='content_list') {
                            $sel=$post->rewrite['slug']==$d?'selected="selected"':'';
                            echo '<option value="'.$post->rewrite['slug'].'" '.$sel.'>'.$post->labels->name.'</option>';
                        }
                    }
                    ?>   
                </select>
            </div>
            
        </li>
    </ul>
    
    <span>Poderá aplicar quantos filtros achar necessario, todos os filtros são aplicados.</span>
    
    </div>
 </div>
   
 
</div>
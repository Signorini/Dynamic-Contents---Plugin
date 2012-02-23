<?php
$dados=array('pag'=>10,'dencidade'=>'baixa','campos'=>array('titulos','metatags','contents'));
if(isset($_POST['ddc_setting']) && !empty($_POST['ddc_setting'])) {
    $dados['dencidade']=$_POST['ddc_setting']['dencidade'];
    
    $sobra=array();
    if(is_array($_POST['ddc_setting']['campos'])) {
        foreach($_POST['ddc_setting']['campos'] as $val) {
            $sobra[]=$val;
        }
    }
    
    $dados['campos']=$sobra;
    $dados['pag']=$_POST['ddc_setting']['pag'];
    ddc_model::add_setting($dados, 'ddc_setting');
}

$get=ddc_model::get_setting('ddc_setting');
if(!is_null($get)) {
    $dados=$get;
}
?>


<div class="wrap">
            <h2><?php echo __('Settings - Dynamic Content', 'ddc'); ?></h2>
            <p>Nesta área poderá configurar o modo com o conteúdo dinâmico é filtrado.</p>
            
            <div id="poststuff" class="metabox-holder my_meta_control">
                <form method="post" action="<?php echo admin_url( 'admin.php?page=ddc-settings');?>">
                   
                    <div class="stuffbox">
                        <h3><?php echo __('Settings', 'post-page-notes'); ?></h3>
                        <div class="inside">
                        <p class="errorPPN">
                         <?php echo $msg; ?>
                        </p>
                           
                           
                            <div class="ddc-wrapper">
                                <label>Clear Cache</label>
                            
                                <a href="<?php echo admin_url( 'admin.php?page=ddc-settings');?>" title="Clear cache">Clear Cache</a>
                                <br/><span>Os resultados das listas são armazenado em cache, são atualizados todas vez que se cria ou atualiza um post, porém se quiser forçar uma atualização clique no link "Clear cache".</span>
                            </div>
                            
                            <div class="ddc-wrapper">
                                <label>Quantidade de post por páginação</label>
                            
                                <input class="ddc-input" type="text" name="ddc_setting[pag]" value="<?php echo $dados['pag']; ?>" />
                                <br/><span>Número de post aonde cada lista conterá.</span>
                            </div>
                            
                            <div class="ddc-wrapper">
                                <label>Modo de busca das keywords</label>
                                <span>O filtro de busca de keywords analisa somente os respectivos campos abaixo.</span>
                                <br/><br/>
                                
                                <input class="ddc-check" type="checkbox" name="ddc_setting[campos][]" value="titulos" <?php echo in_array('titulos',$dados['campos'])?'checked="checked"':'';?>/>
                                <p class="label-left">Títulos (h1, h2, h3 ..., e títulos do wordpress)</p>
                                <br/><br/>
                                
                                <input class="ddc-check" type="checkbox" name="ddc_setting[campos][]" value="metatags" <?php echo in_array('metatags',$dados['campos'])?'checked="checked"':'';?>/>
                                <p class="label-left">Metatags (meta descrition, keywords, meta title..., campos excerpt)<br/>Está opção utiliza as informações dos seguintes plugins da Yoast Wordpress Seo, All Seo in One ou Seo Ultimate</p>
                               <br/><br/>
                               
                                <input class="ddc-check" type="checkbox" name="ddc_setting[campos][]" value="contents" <?php echo in_array('contents',$dados['campos'])?'checked="checked"':'';?>/>
                                <p class="label-left">Contéudo (div, p, span..., dentro do content)</p>

                             
                            </div>
                            
                            <div class="ddc-wrapper">
                                <label>Densidade de  captura de keywords</label>
                                <br/><span>O filtro de busca de keywords trabalha com três tipos de dencidade.</span>
                                <br/><br/>
                                
                                <input class="ddc-radio" type="radio" name="ddc_setting[dencidade]" value="baixa" <?php echo $dados['dencidade']=='baixa'?'checked="checked"':'';?>/>
                                <p class="label-left">Baixa</p>
                                <br/>
                                <span>Adiciona o post na lista bastando ter poucas palavras chaves.</span>
                                <br/><br/>
                                
                                <input class="ddc-radio" type="radio" name="ddc_setting[dencidade]" value="media" <?php echo $dados['dencidade']=='media'?'checked="checked"':'';?>/>
                                <p class="label-left">Média</p>
                                <br/>
                               <span>Adiciona o post na lista, aqueles com uma quantidade mediana de palavras chaves.</span>
                                <br/><br/>
                                
                                <input class="ddc-radio" type="radio" name="ddc_setting[dencidade]" value="alta" <?php echo $dados['dencidade']=='alta'?'checked="checked"':'';?>/>
                                <p class="label-left">Alta</p>
                                <br/>
                                <span>Adiciona o post na lista, somente os posts que realmente possuem uma grande quantidade de palavras chaves.</span>
                            </div>
                           
                           
                        </div>
                    </div>
               

                <input name="save" value="<?php echo __('Salvar atualizações', 'post-page-notes');?>" class="button-primary" type="submit">
                </form>
            </div>
        
        
        
     
</div>
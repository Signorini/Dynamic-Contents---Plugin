jQuery(document).ready(function() {
    ul=jQuery('#filter-list');
    metabox=ul.find('li:first').html();

    
    ul.delegate('.ddc-text', 'focus', function() {
    	idx=(jQuery(this).parent().parent().index())+1;
    	li=ul.find('li');
    	total=li.size();
      
    	if(total==idx) {
    		ul.append('<li class="ddc-hide">'+metabox+'</li>');
    		ul.find('.ddc-hide').find('.ddc-text').val('');
    		ul.find('.ddc-hide').slideDown('normal', function() {
    			jQuery(this).removeClass('ddc-hide');
    		});
    	}
    });
    
    ul.delegate('.ddc-bt', 'click', function() {
    	obj=jQuery(this).parent().parent();
    	idx=(obj.index())+1;
    	li=ul.find('li');
    	total=li.size();
      
    	if(1!=total) {
    		obj.slideUp('normal', function() {
    			jQuery(this).remove();
    		});
    	}
    });

});

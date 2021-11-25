
<form  class="search" action="<?php bloginfo('url'); ?>/" method="GET" role="search">	
  <div class="ml-1 txt-blur">
    <button id="close" type="submit"><i class="fa fa-search"></i></button>      
  </div>
  <input 
    type="search" 
    name="s" 
    placeholder="<?php _e('Tìm kiếm ...','isokoma'); ?>" 
    value="<?php the_search_query( ); ?>"
    id="search-form"
    class="form-control shadow-none"
    />
  
</form>

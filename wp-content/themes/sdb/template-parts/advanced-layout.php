<?php     
if( have_rows('page_layouts') ):
    while( have_rows('page_layouts') ) :
        the_row();

        /* Standard Section */ 
        if( get_row_layout() == 'module_standard' ) :
            get_template_part('template-parts/modules/columns/columns');
            
        /* Standard Callout */ 
        elseif( get_row_layout() == 'module_callout' ) :
            get_template_part('template-parts/modules/callout/callout');
        
        /* Image Gallery Layout */ 
        elseif( get_row_layout() == 'module_gallery' ) : 
            get_template_part('template-parts/modules/gallery/gallery');

        /* Service Card List */ 
        elseif( get_row_layout() == 'module_service_card_list' ) : 
            get_template_part('template-parts/modules/service-card-list/service-card-list');

        /* Pages Layout */	
        elseif( get_row_layout() == 'module_pages' ) :
            get_template_part('template-parts/modules/pages/pages');

        /* Table Layout */ 
        elseif( get_row_layout() == 'module_table' ) :
            get_template_part('template-parts/modules/tables/tables');

        /* Tab Layout */ 
        elseif( get_row_layout() == 'module_tabs' ) :
            get_template_part('template-parts/modules/tabs/tabs');        

        /* Toggle Layout */ 
        elseif( get_row_layout() == 'module_toggles' ) : 
            get_template_part('template-parts/modules/toggles/toggles');

        /* Testimonials Layout */	
        elseif( get_row_layout() == 'module_testimonials' ) :
            get_template_part('template-parts/modules/testimonials/testimonials');
            
        endif; // end if switching statement over layout types
    endwhile; // end while(layouts) loop
endif; // end have(layouts) check
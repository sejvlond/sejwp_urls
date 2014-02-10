<?php

namespace sejvlond\wordpress\plugins\urls\templates\admin;

use sejvlond\wordpress\plugins\urls\templates\ITemplate;
use sejvlond\wordpress\plugins\urls\FlashMessage;

/**
 * Edit url template
 * 
 * @author Ondrej Sejvl
 */
class Settings implements ITemplate {
    
    public static function render ( $data = NULL ) {
        ?>

            <div class="wrap">
                <h2><?php _e ( "Settings" ); ?></h2>

                <?php 
                    
                    foreach ( FlashMessage::getInstance()->getAll() as $msg ) {
                        echo "<div id=\"message\" class=\"updated below-h2\">".$msg."</div>";
                    }
                    FlashMessage::getInstance()->delete();
                ?>
                
                <div class="metabox-holder columns-1">
                    <form method="post" action=""> 
                        <label for="page"><?php _e ( 'Page to show after' ) ?></label> 
                        <select name="page">
                            <?php 
                                foreach ( $data['pages'] as $page ) {
                                    echo "<option value='".$page->ID."'".($page->ID == $data['selected'] ? " selected" : "" ).">"
                                            .$page->post_title."</option>";
                                }
                            ?>
                        </select>
                        
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>

        <?php
    }
    
}


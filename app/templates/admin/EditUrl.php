<?php

namespace sejvlond\wordpress\plugins\urls\templates\admin;

use sejvlond\wordpress\plugins\urls\templates\ITemplate;
use sejvlond\wordpress\plugins\urls\FlashMessage;

/**
 * Edit url template
 * 
 * @author Ondrej Sejvl
 */
class EditUrl implements ITemplate {
    
    public static function render ( $data = NULL ) {
        ?>

            <div class="wrap">
                <h2><?php _e ( "Edit url" ); ?></h2>
                
                <?php 
                    
                    foreach ( FlashMessage::getInstance()->getAll() as $msg ) {
                        echo "<div id=\"message\" class=\"updated below-h2\">".$msg."</div>";
                    }
                    FlashMessage::getInstance()->delete();
                ?>
                
                <div class="metabox-holder columns-1">
                    <form method="post" action=""> 
                        <label for="url"><?php _e ( 'Url' ) ?></label> <input type="url" id="url" name="url" value="<?php echo $data['entity']->url ?>"><br>
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>

        <?php
    }
    
}



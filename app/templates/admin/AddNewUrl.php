<?php

namespace sejvlond\wordpress\plugins\urls\templates\admin;

use sejvlond\wordpress\plugins\urls\templates\ITemplate;
use sejvlond\wordpress\plugins\urls\FlashMessage;

/**
 * Add new url template
 * 
 * @author Ondrej Sejvl
 */
class AddNewUrl implements ITemplate {
    
    public static function render ( $data = NULL ) {
        ?>

            <div class="wrap">
                <h2><?php _e ( "Add new url" ); ?></h2>

                <?php 
                    
                    foreach ( FlashMessage::getInstance()->getAll() as $msg ) {
                        echo "<div id=\"message\" class=\"updated below-h2\">".$msg."</div>";
                    }
                    FlashMessage::getInstance()->delete();
                ?>
                
                <div class="metabox-holder columns-1">
                    <form method="post" action=""> 
                        <label for="url"><?php _e ( 'Url' ) ?></label> <input type="url" id="url" name="url"><br>
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>

        <?php
    }
    
}





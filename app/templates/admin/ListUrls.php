<?php

namespace sejvlond\wordpress\plugins\urls\templates\admin;

use sejvlond\wordpress\plugins\urls\templates\ITemplate;
use sejvlond\wordpress\plugins\urls\FlashMessage;
/**
 * List of templates
 * 
 * @author Ondrej Sejvl
 */
class ListUrls implements ITemplate {
    
    public static function render ( $data = NULL ) {
        ?>

            <div class="wrap">
                <h2><?php _e ( "List registered urls" ); ?>
                    <a class="add-new-h2" href="<?php menu_page_url ( 'sejwp_urls_new' ) ?>">Vytvořit příspěvek</a>
                </h2>
                
                <?php 
                    
                    foreach ( FlashMessage::getInstance()->getAll() as $msg ) {
                        echo "<div id=\"message\" class=\"updated below-h2\">".$msg."</div>";
                    }
                    FlashMessage::getInstance()->delete();
                ?>
                <table class="wp-list-table widefat fixed posts" cellspacing="0">
                    <thead>
                        <tr class="">
                            <th id="title" class="manage-column column-title sortable desc" style="" scope="col">
                                <a><?php _e ( "Date") ?></a`>
                        </tr>
                    </thead>
                    
                <?php
                    $i = 0;
                    foreach ( $data ['urls' ] as $url ) { 
                        ?>
                
                        <tr id="post-1" class="<?php echo ( $i % 2 == 0 ? 'alternate' : '' ) ?> post-1 type-post status-publish format-standard hentry iedit author-self level-0" valign="top">
                            <td class="post-title page-title column-title"><?php echo $url->url ?>
                                <div class="row-actions">
                                    <span class="edit">
                                        <a title="<?php _e ( "Edit item" ) ?>" href="<?php menu_page_url ( 'sejwp_urls_edit' ) ?>&id=<?php echo $url->id ?>"><?php _e ( "Edit" ) ?></a>
                                    |
                                    </span>
                                    
                                    <span class="trash">
                                        <a onclick="return confirm('<?php _e("Really delete this url?") ?>');" class="submitdelete" href="<?php menu_page_url ( 'sejwp_urls_delete' ) ?>&id=<?php echo $url->id ?>" title="<?php _e ( "Delete item" ) ?>"><?php _e ( "Delete" ) ?></a>
                                    </span>
                                </div>
                        </tr>
                    <?php
                        $i ++;
                    }
                ?>
                </table>
                
            </div>

        <?php
    }
    
}




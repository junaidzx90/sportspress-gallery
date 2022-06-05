<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Gallery
 * @subpackage Gallery/admin/partials
 */
?>

<div class="sp_gallery">
<?php
$post_author = get_post()->post_author;
$galleries = get_user_meta($post_author, 'gcb_gallery', true );
    if(!is_array($galleries)){
        $galleries = [];
    }

    if(sizeof($galleries) > 0){
        foreach($galleries as $gallery){
            ?>
            <div class="item public">
              <div class="img" style="background-image: url(<?php echo $gallery ?>);">
                <div class="action_buttons">
                  <a class="imageview" data-fancybox="gallery-<?php echo $post_author ?>" href="<?php echo $gallery ?>"></a>
                </div>
              </div>
            </div>
            <?php
        }
    }else{
      echo "No gallery item found!";
    }
?>
</div>
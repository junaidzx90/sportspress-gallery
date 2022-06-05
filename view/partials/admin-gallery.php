<div id="spg_gallery">
    <div class="sp_gallery">
        <?php
        global $post;
        $post_author = $post->post_author;
        $galleries = get_user_meta($post_author, 'gcb_gallery', true );
        if(!is_array($galleries)){
            $galleries = [];
        }

        echo '<input type="hidden" id="current_user_id" value="'.$post_author.'">';
        if(sizeof($galleries) > 0){
            foreach($galleries as $key => $gallery){
                ?>
                <div class="item">
                    <div class="img" style="background-image: url(<?php echo $gallery ?>);">
                        <div class="action_buttons">
                            <span data-key= "<?php echo $key ?>" class="delete_spg_gallery_item"></span>
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
</div>
<div class="sp_gallery myaccount">
    <div class="button-box item">
        <button class="add_galery_item"></button>
    </div>

    <input type="hidden" id="current_user_id" value="<?php echo get_current_user_id(  ) ?>">
    <?php
    $galleries = get_user_meta(get_current_user_id(  ), 'gcb_gallery', true );
    if(!is_array($galleries)){
        $galleries = [];
    }

    if(sizeof($galleries) > 0){
        foreach($galleries as $key => $gallery){
            ?>
            <div class="item">
                <div class="img" style="background-image: url(<?php echo $gallery ?>);">
                    <div class="action_buttons">
                        <span data-key= "<?php echo $key ?>" class="delete_spg_gallery_item"></span>
                        <a class="imageview" data-fancybox="gallery-<?php echo get_current_user_id(  ) ?>" href="<?php echo $gallery ?>"></a>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<div id="add_new_image_popup" class="add_new_image_popup dnone">
    <form method="post" enctype="multipart/form-data" class="spg_popup_content">
        <span class="close_g_popup">+</span>
        <div id="spg_image_preview"></div>
        <div class="spg_form_data">
            <div id="warnings"></div>
            <div class="spg-input">
                <label class="upload_button" for="spg_upload_image">Upload</label>
                <input name="spg_upload_image" type="file" id="spg_upload_image">
            </div>
            <div class="devider_lines">
                <h3>OR</h3>
                <span class="g_line"></span>
            </div>
            <div class="spg-input">
                <label for="spg_image_url">Image URL</label>
                <input name="spg_image_url" type="url" placeholder="Image URL" id="spg_image_url">
            </div>

            <div class="sub_button">
                <input type="submit" id="add_new_image" value="Add Image"/>
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" width="50px" height="50px"> <path fill="red" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"> <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform> </path> </svg>
            </div>
        </div>
    </form>
</div>
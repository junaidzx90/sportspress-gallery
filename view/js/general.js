jQuery(function ($) {
    $('[data-fancybox]').fancybox({
        // Options will go here
        buttons : [
            "zoom",
            // "share",
            "fullScreen",
            // "thumbs",
            "close"
        ],
        wheel : false,
        transitionEffect: "slide",
        loop            : true,
        keyboard        : true,
        toolbar         : true,
        clickContent    : false
    });

    $(document).on("click", ".delete_spg_gallery_item", function(){
        if(confirm("The image will be deleted.")){
            let dindex = $(this).data("key");
            let userId = $('#current_user_id').val();
            let btn = $(this);
            $.ajax({
                type: "post",
                url: gallery_ajax.ajaxurl,
                data: {
                    action: "delete_gallery_item",
                    index: dindex,
                    user_id: userId
                },
                dataType: "json",
                success: function (response) {
                    if(response.success){
                        btn.parents(".item").remove();
                    }
                }
            });
        }
    });
});

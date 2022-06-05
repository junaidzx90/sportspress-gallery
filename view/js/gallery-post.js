jQuery(function ($) {
    // Popup handle
    $(".add_galery_item").on("click", function(){
        $("#add_new_image_popup").removeClass("dnone");
        $(".close_g_popup").on("click", function(){
            $("#add_new_image_popup").addClass("dnone");
            $("#spg_image_url").val("");
            $('#spg_upload_image').val("");
            $('#spg_image_preview').css('background-image', 'url()');
        });
    });

    let thumbnail = function (input) {
        if (input.files && input.files[0]) {
          let reader = new FileReader();
          reader.onload = function (e) {
            $('#spg_image_preview').css('background-image', 'url('+e.target.result+')');
          };
          reader.readAsDataURL(input.files[0]);
        }
    };

    function isImage(url) {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    }
    $("#spg_image_url").on("input", function(){
        let url = $(this).val();
        if(isImage(url)){
            $('#spg_image_preview').css('background-image', 'url('+url+')');
        }
    });
    $('#spg_upload_image').on("change", function(){
        if ($(this).val() !== '') {
            let imgName = $(this)
              .val()
              .replace(/.*(\/|\\)/, '');
            let exten = imgName.substring(imgName.lastIndexOf('.') + 1);
            let expects = ['jpg', 'jpeg', 'png', 'PNG', 'JPG', 'gif'];
      
            if (expects.indexOf(exten) == -1) {
              $('#spg_image_preview').css('background-image', 'url()');
              $('#spg_upload_image').val("")
              alert('Invalid Image!');
              return false;
            }
            thumbnail(this);
        } else {
            $('#spg_image_preview').css('background-image', 'url()');
        }
    });

    $(".spg_popup_content").on("submit", function(e){
        e.preventDefault();

        $(this).ajaxSubmit({
            url: gallery_ajax.ajaxurl,
            data: {
                action: "store_gallery_image",
            },
            dataType: "json",
            beforeSend: function(){
                $("#add_new_image").prop("disabled", true);
                $('.sub_button').find("svg").show();
            },
            success: function (response) {
                $("#add_new_image").removeAttr("disabled");
                $('.sub_button').find("svg").hide();
                if(response.success){
                    $("#warnings").html(`<div class="gcb_warning success"><p>${response.success}</p></div>`);
                    setTimeout(() => {
                        $("#warnings").html("");
                        location.reload();
                    }, 3000);
                }
                if(response.error){
                    $("#warnings").html(`<div class="gcb_warning"><p>${response.error}</p></div>`);
                    setTimeout(() => {
                        $("#warnings").html("");
                    }, 3000);
                }
            }
        });
    })
});
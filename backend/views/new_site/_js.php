
<script>
    var agentId = "<?php echo $agent['id'] ? $agent['id'] : '' ?>"; //Don't forget the extra semicolon!
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>




<script>
    //agent
    $('.agent_join').click(function() {

        $.ajax({
            url: "/admin/apartment/realty",
            type: "post",
            success: function (response) {
                if(response.error) {
                    alert(response.error);
                } else {
                    alert(response.result);
                    if(response.refresh) {
                        window.location.reload();
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }

        });
    });



    //preview
    var realtyId = "<?= $model->id ?>";
    var type = "<?= $model->id ?>";

    $(function() {
        $('.file-footer-caption').after('<div class="chose-preview">Обложка</div>');
        $('.chose-preview').click(function() {

            var previewButton = $(this);


            var id = $(this).closest('.file-preview-frame').find('.kv-file-remove').attr('data-key');


            $('.file-preview-frame');
            $.ajax({
                url: "/admin/image/preview",
                type: "post",
                data: {id: id},
                success: function (response) {
                    $('.chose-preview').css({
                        background: '#e9e9e9'
                    });
                    previewButton.css({
                        background: '#fa441b'
                    });
                    // if(response.error) {
                    //     alert(response.error);
                    // }

                    // else {
                    //     if(response.refresh) {
                    //         window.location.reload();
                    //     }
                    // }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                }

            });
        });
    });


    $(function() {
        $.ajax({
            url: "/admin/image/getpreviewid",
            type: "post",
            success: function (response) {
                if(response.id) {
                    $('[data-key="' + response.id + '"]').closest('.file-preview-frame').find('.chose-preview').css({
                            background: '#fa441b'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }

        });
    });
</script>
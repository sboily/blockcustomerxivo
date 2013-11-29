$('document').ready(function(){
    $('#call_button').fancybox({
        'hideOnContentClick': false
    });

    $('#sendCall').click(function(){
        var phone_number = $('#phone_number').val();
        var id_product = $('#id_product_comment_send').val();
        var module_dir = $('#module_dir').val();
        if (phone_number && !isNaN(id_product))
            {
                $.ajax({
                    url: module_dir + "doCall.php",
                    type: "POST",
                    headers: {"cache-control": "no-cache"},
                    data: {action: 'callUs', secure_key: '', phone_number: phone_number, id_product: id_product},
                    dataType: "json",
                    success: function(result) {
                        $.fancybox.close();
                        var msg = result ? "Waiting for the call" : "Call has been fail";
                        var title = "Call us";
                        fancyMsgBox(msg, title);
                    }
                });
            }
            else
                $('#call_form_error').text("You did not fill required fields");
    });

});

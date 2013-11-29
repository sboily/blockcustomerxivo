$('document').ready(function(){
    $('#call_button').fancybox({
        'hideOnContentClick': false
    });

    $('#sendCall').click(function(){
        var phone_number = $('#phone_number').val();
        var product_id = $('#product_id').val();
        var product_link = $('#product_link').val();
        var product_title = $('#product_title').val();
        var module_dir = $('#module_dir').val();
        if (phone_number && !isNaN(id_product))
            {
                $.ajax({
                    url: module_dir + "doCall.php",
                    type: "POST",
                    headers: {"cache-control": "no-cache"},
                    data: {action: 'callUs', phone_number: phone_number, product_id: product_id, product_link: product_link, product_title: product_title},
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

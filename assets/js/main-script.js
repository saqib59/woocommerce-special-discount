(function($){

    $("#special-discount-menu").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serializeArray();
        $.ajax({
                type:"POST",
                url: object.ajax_url,
                data:  {"cat_id":formData[0].value,
                        "discount_in_per":formData[1].value,
                        "action":'update_prod_discount'
                    },
                dataType : 'json',
              success: function (response) {
                    var error = response.error;
                    if (error) { 
                        window.location.href = response.redirect_url;
                    } else {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            });
                       // console.log(response);
                    }
                },
                error: function (errorThrown) {
                        console.log(errorThrown);
                    },
            });
      
    });

})(jQuery)
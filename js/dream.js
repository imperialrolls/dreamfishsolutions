// Initialize collapse button
$(".button-collapse").sideNav();
// Initialize collapsible (uncomment the line below if you use the dropdown variation)
//$('.collapsible').collapsible();


$(document).ready(function(){
    //$('.parallax').parallax();

    $("#contact-submit").click(function () {
        let form = {
            name: $("input[name=name]").val(),
            email: $("input[name=email]").val(),
            message: $("textarea[name=message]").val(),
            recaptcha: $("input[name=captcha]").val()
        };

        $.ajax({
            url: 'php/contact_verify.php',
            data: form,
            type: 'post',
            success: function(result) {
                let res = JSON.parse(result);
                Materialize.toast(res['result'][0], 4000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              console.log(xhr.status);
              console.log(thrownError);
            }
        });
    });

});

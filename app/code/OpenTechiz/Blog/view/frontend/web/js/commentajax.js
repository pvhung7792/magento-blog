define([
    "jquery",
    "jquery/ui"
], function ($){
    "use strict";
    function main(config, element){
        var $element = $(element);
        var AjaxCommentPostUrl = config.AjaxCommentPostUrl;

        var dataFrom = $('#comment-form');

        $(document).on('click','#submit',function (event){
            event.preventDefault();
            var param = dataFrom.serialize();

            $.ajax({
                showLoader: true,
                url: AjaxCommentPostUrl,
                data: param,
                type: "POST"
            }).done(function (data){
                alert(data);
                $('#note').html(data);
                $('#note').css('color','red');
                document.getElementById("comment-form").reset();
                return true;
            });
        });
    }
    return main;
})

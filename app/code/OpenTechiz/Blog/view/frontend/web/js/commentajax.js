define([
    "jquery",
    "jquery/ui"
], function ($){
    "use strict";

    function main(config, element){
        var $element = $(element);
        var AjaxCommentPostUrl = config.AjaxCommentPostUrl;

        var dataFrom = $('#comment-form');
        dataFrom.mage('validation', {});

        $(document).on('click','.submit',function (){
            if(dataFrom.valid()){
                event.preventDefault();
                var param = dataFrom.serialize();

                $.ajax({
                    showLoader: true,
                    url: AjaxCommentPostUrl,
                    data: parm,
                    type: "POST"
                }).done(function (data){
                    $('note').html(data);
                    $('note').css('color','red');
                    document.getElementById("comment-form").reset();
                    return true;
                });
            }
        });
    };
    return main;
})

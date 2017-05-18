/*global $*/
$(document).ready(init);
function init()
{
    $(".message").click(getMsg);
}

function getMsg()
{
    var id = $(this).attr("id");
    $(".msgfield").empty();
	$.ajax({
            dataType: "json",
            url: "js/getMsg.php?id="+id
    })
    .done(function( data, textStatus, jqXHR ) {
        $("#from").html(data.sender).fadeIn();
        $("#date").html(data.date).fadeIn();
        $("#subj").html(data.subject).fadeIn();
        $("#body").html(data.body).fadeIn();
    });
    if( ! ($(this).hasClass("noupdate")))
        updateMsgStatus(id);
}

function updateMsgStatus(id)
{
    $.ajax({
        dataType: "json",
        url: "js/updateMsgStatus.php?id="+id
    })
    .done(function( data, textStatus, jqXHR ) {
        if(data.success == true)
        {
            $("#"+id).parent().siblings().removeAttr("style");
            $("#"+id).parents(".msgrow").removeAttr("style");
            $("#"+id).removeClass("btn-primary");
            $("#"+id).addClass("btn-default");
        }
    });
}
/*global $*/
$(document).ready(init);
function init()
{
    $("#change").click(change);
}

function getMsg()
{
    $("#instruments select").empty();
	$.ajax({
            type: "POST",
            url: "js/getMsg.php",
            success: function(response)
            {
                $('#instruments select').html(response).fadeIn();
            }
    });
}
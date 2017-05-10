/*global $*/
var type = 0; // 0 = login, 1 = registro
$(document).ready(init);
function init()
{
    $("#change").click(change);
}

function change()
{
    if(type)
    {
        $("#form-type").html("Iniciar sesión");
        $("#register").slideUp();
        $("#submit-type").attr("name", "login");
        $("#submit-type").attr("value", "¡Inicia sesión!");
        $("#change").html("¡Regístrate!");
        type = 0;
    }
    else
    {
        $("#form-type").html("Registro de usuario");
        $("#register").slideDown();
        $("#submit-type").attr("name", "register");
        $("#submit-type").attr("value", "¡Regístrate!");
        $("#change").html("Iniciar sesión");
        type = 1;
    }
}
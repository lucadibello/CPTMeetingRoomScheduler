$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
    var lcase = new RegExp("[a-z]+");
    var num = new RegExp("[0-9]+");

    /* 8 Characters check */
    if($("#password1").val().length >= 8){
        $("#8char").removeClass("fa-times");
        $("#8char").addClass("fa-check");
        $("#8char").css("color","#00A41E");
    }else{
        $("#8char").removeClass("fa-check");
        $("#8char").addClass("fa-times");
        $("#8char").css("color","#FF0004");
    }
    /* END CHECK */

    /* Uppercase check */
    if(ucase.test($("#password1").val())){
        $("#ucase").removeClass("fa-times");
        $("#ucase").addClass("fa-check");
        $("#ucase").css("color","#00A41E");
    }else{
        $("#ucase").removeClass("fa-check");
        $("#ucase").addClass("fa-times");
        $("#ucase").css("color","#FF0004");
    }
    /* END CHECK */

    /* Lowercase check */
    if(lcase.test($("#password1").val())){
        $("#lcase").removeClass("fa-times");
        $("#lcase").addClass("fa-check");
        $("#lcase").css("color","#00A41E");
    }else {
        $("#lcase").removeClass("fa-check");
        $("#lcase").addClass("fa-times");
        $("#lcase").css("color", "#FF0004");
    }
    /* END CHECK */

    /* Number check */
    if(num.test($("#password1").val())){
        $("#num").removeClass("fa-times");
        $("#num").addClass("fa-check");
        $("#num").css("color","#00A41E");
    }else{
        $("#num").removeClass("fa-check");
        $("#num").addClass("fa-times");
        $("#num").css("color","#FF0004");
    }
    /* END CHECK */


    /* Password match check */
    if($("#password1").val() == $("#password2").val() &&
        $("#password1").val().length > 0 && $("#password2").val().length > 0){

        $("#pwmatch").removeClass("fa-times");
        $("#pwmatch").addClass("fa-check");
        $("#pwmatch").css("color","#00A41E");
    }else{
        $("#pwmatch").removeClass("fa-check");
        $("#pwmatch").addClass("fa-times");
        $("#pwmatch").css("color","#FF0004");
    }
    /* END CHECK */
});
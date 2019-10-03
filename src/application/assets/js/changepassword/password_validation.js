$("input[type=password]").keyup(function(){
    //is-valid | is-invalid

    if($("#newPassword").text().length >= 8){

    }

    if($('#newPassword').val() == $('#retypePassword').val()){
        $('#retypePassword').addClass("is-valid");
        $('#retypePassword').removeClass("is-invalid");
    }
    else{
        $('#retypePassword').addClass("is-invalid");
        $('#retypePassword').removeClass("is-valid");
    }



    function addValidFeedback(){
        let a = "<div class='valid-feedback'> + msg "</div>";

    }

    function addInvalidFeedback(msg) {
        let a = "<div class='invalid-feedback'> + msg "</div>";
    }
});
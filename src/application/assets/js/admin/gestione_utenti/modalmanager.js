$('.delete-user-button').on("click", function(){
    // get category id
    let username = $(this).attr("user-target");

    console.log("[!] Start opening delete modal for user: " + username);

    // Insert data into modal
    $('#modalEliminaMessaggio').text("Sei sicuro di voler eliminare l'utente '" + username + "'?");

    // change url. It will call the websites APIs
    $("#eliminaButton").attr("href", '/api/user/delete/' + username);

    // Show modal
    $('#modalConfirmDelete').modal('show');

    console.log("[*] Opened delete confirmation modal")

    // API/USER/DELETE/1
});
$('.delete-user-button').on("click", function(){
    // get category id
    let username = $(this).attr("user-target");

    console.log("[!] Start opening delete modal for user: " + username);

    // Insert data into modal
    $('#modalEliminaMessaggio').text("Sei sicuro di voler eliminare l'utente '" + username + "'?");

    // change url. It will call the websites APIs
    $("#eliminaButton").attr("href", '../api/user/delete/' + username);

    // Show modal
    $('#modalConfirmDelete').modal('show');

    console.log("[*] Opened delete confirmation modal")

    // API/USER/DELETE/1
});

$('.edit-user-button').on("click", function () {
    //get username
    let username = $(this).attr("user-target");
    // get row
    let row = document.getElementById(username);

    // get extra data
    let nome = $(row).find(".nome").text();
    let cognome = $(row).find(".cognome").text();
    let email = $(row).find(">.email").attr("partial-mail");

    // Insert data into modal
    $('#editModalUsername').val(username).trigger("change");
    $('#editModalNome').val(nome).trigger("change");
    $('#editModalCognome').val(cognome).trigger("change");
    $('#editModalEmail').val(email).trigger("change");

    // Setup API call url
    $("#editModalForm").attr("action", '../api/user/update/' + username);
    $('#editModal').modal('show');
    
    $('#editModalSubmitButton').on("click", function () {
        $("#editModalForm").submit();
    })
});

$('.promote-user-button').on("click", function(){
    // get username
    let username = $(this).attr("user-target");

    // get row
    let row = document.getElementById(username);
    // read user permission name
    let permission_name = $(row).find(".permessi").text();

    console.log("[!] Starting opening update confirmation modal");

    $("#updateModalCurrentPermissions").val(permission_name).trigger("change");
    //console.log("[!] Start opening promote modal for user: " + username);

    // change url. It will call the websites APIs
    $("#updateModalForm").attr("action", '../api/user/promote/' + username);

    // Show modal
    $('#updateModal').modal('show');

    console.log("[*] Opened update confirmation modal");

    $("#updateModalSubmitButton").on("click", function () {
        $("#updateModalForm").submit();
    })
});
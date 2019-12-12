var json_config_path = "config.json";
var global_error_message = "c'è stato un errore durante l'aggiornamento dei dati...";

// Set in runtime
var config;
var bookings;

// Load config
get_json_settings();

// Fetch data
read_bookings_json(config);

function read_bookings_json(config) {
    $.ajax(config.api_url, {
            dataType: 'json', // type of response data
            method: 'post',
            data: {token: config.api_token},
            success: function (json, status, xhr) {
                console.log("[!] JSON data found");

                // Check if apis returned an error json or bookings json
                if (typeof json["code"] != 'undefined'){
                    console.log("[!] Detected API error");

                    // Show api error
                    $('#update-error-body').removeClass("d-none");
                    $('#update-error-message').text(json["message"] + ". Codice: " + json["code"]);
                    $('#booking-data').addClass("d-none");
                }
                else
                {
                    console.log("[!] Booking data found");
                    console.log(json);


                    // Hide error body and show data
                    $('#update-error-body').addClass("d-none");
                    $('#booking-data').removeClass("d-none");

                    // Update last update time
                    $("#last-update-datetime").text(moment().format("D/M/Y HH:mm"));


                    // Show first booking in the featured section
                    if(json.length > 0){
                        // Hide error
                        $('#no-data-error').removeClass('d-none');

                        let featured = json[0];
                        show_featured(
                            featured.start,
                            featured.start,
                            featured.end,
                            featured.title,
                            featured.note.length > 0 ? featured.note : "-"
                        );

                        if(json.length > 1){
                            // Show table
                            $('#booking-table-full').removeClass("d-none");

                            // Clear table
                            $('#booking-table-full').detach();
                            $('#booking-table-full').append($('<tbody>'));

                            for(let i = 1; i < json.length && i < config["max_shown_booking"]; i++){
                                console.log(json[i]);
                                add_row(
                                    json[i].start,
                                    json[i].start,
                                    json[i].end,
                                    json[i].title,
                                    json[i].note.length > 0 ? json[i].note : "-"
                                );
                            }
                        }
                        else{
                            add_error_row("Non ci sono dati da mostrare")
                        }
                    }
                    else{
                        // Hide featured table
                        $('#featured-booking').addClass('d-none');
                        // Show error message
                        $('#no-data-error').removeClass('d-none');
                    }
                }
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback
                bookings = false;
                console.log("[!] Error while fetching bookings");

                // Show error
                $('#update-error-body').removeClass("d-none");
                $('#update-error-message').text(global_error_message);
            }
        }
    );
}

function add_error_row(msg){
    table_body.append($('<tr>').append("" +
        "<td style='column-span: 4; color:red;'>" + msg + "</td>"));
}

function add_row(data, ora_inizio, ora_fine, utente, osservazioni){
    let table_body = $('#booking-table-body');

    data = moment(data).format("D/M/Y");
    ora_inizio = moment(ora_inizio).format("HH:mm");
    ora_fine = moment(ora_fine).format("HH:mm");

    table_body.append($('<tr>').append("" +
        "<td>" + data + "</td>" +
        "<td>" + ora_inizio + " - " + ora_fine + "</td>" +
        "<td>" + utente + "</td>" +
        "<td>" + osservazioni + "</td>"));
}

function show_featured(data, ora_inizio, ora_fine, utente, osservazioni){
    console.log(ora_inizio + " - " + ora_fine);

    data = moment(data).format("D/M/Y");
    ora_inizio = moment(ora_inizio).format("HH:mm");
    ora_fine = moment(ora_fine).format("HH:mm");

    $('#featured-date').text(data);
    $('#featured-time-start').text(ora_inizio);
    $('#featured-time-end').text(ora_fine);
    $('#featured-professor').text(utente);
    $('#featured-osservazioni').text(osservazioni);
}

function get_json_settings() {
    $.ajax({
        dataType: 'json',
        url: json_config_path,
        async: false,
        success: function (json) {
            console.log("[Config] Config file read");
            config = json;
        }
    });
}
var json_config_path = "config.json";
var global_error_message = "c'è stato un errore durante l'aggiornamento dei dati...";

// Set in runtime
var config;

// Load config
get_json_settings();

// Fetch data
read_bookings_json(config);

function read_bookings_json(config) {
    // Update data
    $("#current-data").text(moment().format("D/M/Y"));

    // Request data
    $.ajax(config.api_url, {
        dataType: 'json', // type of response data
        method: 'post',
        data: {token: config.api_token},
        success: function (json, status, xhr) {
            console.log("[!] JSON data found:");
            console.log(json);
            // Check if apis returned an error json or bookings json
            if (typeof json["code"] != 'undefined') {
                console.log("[!] Detected API error");

                // Show api error
                $('#update-error-body').removeClass("d-none");
                $('#update-error-message').text(json["message"] + ". Codice: " + json["code"]);
                $('#booking-data').addClass("d-none");
            } else {
                console.log("[!] Booking data found");

                // Update last update time
                $("#last-update-datetime").text(moment().format("D/M/Y HH:mm"));

                if(json.length > 0){
                    // Hide error and show data
                    $('#update-error-body').addClass("d-none");
                    $('#booking-data').removeClass("d-none");

                    // Show table
                    $('#booking-table-container').removeClass("d-none");

                    // Clear table
                    $('#booking-table-body').empty();
                    console.log("[!] Table cleared");

                    for (let i = 0; i < json.length && i < config["max_shown_booking"]; i++) {
                        console.log(json[i]);

                        let note = config["osservazioni_default_value"];
                        if (json[i].note != null) {
                            note = json[i].note.length > 0 ? json[i].note : config["osservazioni_default_value"];
                        }

                        add_row(
                            json[i].start,
                            json[i].start,
                            json[i].end,
                            json[i].title
                        );
                    }
                }
                else{
                    // Clear table
                    $('#booking-table-body').empty();
                    console.log("[!] Table cleared");

                    add_error_row("Non ci sono prenotazioni.");
                }
            }
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback
            console.log("[!] Error while fetching bookings: " + textStatus + " " + errorMessage);

            // Show error
            $('#update-error-body').removeClass("d-none");
            $('#update-error-message').text(global_error_message);
        }
    });
}

function add_error_row(msg) {
    console.log("[!] Added error row to table");
    $('#booking-table-body').append($('<tr>').append("" +
        "<td colspan='3' style='color:red;'>" + msg + "</td>"));
}

function add_row(data, ora_inizio, ora_fine, utente) {
    let table_body = $('#booking-table-body');

    data = moment(data).format("D/M/Y");
    ora_inizio = moment(ora_inizio).format("HH:mm");
    ora_fine = moment(ora_fine).format("HH:mm");

    table_body.append($('<tr>').append("" +
        "<td>" + data + "</td>" +
        "<td>" + ora_inizio + " - " + ora_fine + "</td>" +
        "<td>" + utente + "</td>"));
}

function show_featured(data, ora_inizio, ora_fine, utente, osservazioni) {
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

/**
 * This function is used to refresh/refetch all the events of the calendar
 */
function refreshAgenda() {
    // Clear console
    console.clear();

    // Refresh config
    get_json_settings();

    // Refresh bookings
    read_bookings_json(config);


    console.log("[!] Agenda refreshed on " + moment().format("D/M/Y HH:mm:ss"));
}

// Set refresher interval
setInterval(refreshAgenda, 1000 * 30); // Update agenda every 30 seconds
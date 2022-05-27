function minoti() {
    $.ajax({
        url: "https://pos.loginweb.dev/api/notificaciones",
        dataType: "json",
        success: function (response) {
            $('#minoti').html(response.length)
        }
    });
}

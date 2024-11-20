export function sendData(url = null, payload = null, options = null, successCallback = null, errorCallback = null) {

    let headers = [];
    let body;
    let method;

    if ((options && options.contentType) === 'application/json') {
        headers['Content-Type'] = 'application/json';
        headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        body = JSON.stringify(payload);
    } else if (options && options.contentType === 'multipart/form-data') {
        // } else if (payload instanceof FormData) {
        body = payload;
    } else {
        console.error('Unsupported content type or data format');
        // return;
    }

    if (options && options.headers) {
        headers = {
            ...headers,
            ...options.headers
        };
    }
    // console.log(headers);

    const config = {
        method: options && options.method ? options.method : 'POST',
        headers: headers,
        ...options,
    }

    if (options && options.method.toUpperCase() === 'GET') {
        url += '?' + new URLSearchParams(payload).toString();
    } else {
        config['body'] = body;
    }
    // console.log(config);

    fetch(url, config)
        .then(response => {
            // Check if the response status is OK (200-299)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Parse the response as JSON
        })
        .then(data => {
            // If the request is successful, call the success callback with the response data
            // if (options && options.successCallback) {
            successCallback(data);
            // }
        })
        .catch(error => {
            // If there's an error, call the error callback with the error object
            // if (options && options.errorCallback) {
            errorCallback(error);
            // } else {
            // console.error('Error:', error);
            // }
        });
}


export function associateErrors(errors, formId) {
    let $form = $(`#${formId}`);
    $form.find('.form-group .invalid-msg').text('');
    $form.find('.form-group .form-control').removeClass('is-invalid');

    Object.keys(errors).forEach(function (fieldName) {
        let $group = $form.find('[name="' + fieldName + '"]');
        $group.addClass('is-invalid');
        $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
    });
}

export function ajaxRequest(url = "", payload = {}, method = "GET") {

    if (!url) {
        alert('url not found')
        return;
    }
    var res = "";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: method,
        url: url,
        data: payload,
        async: false,
        dataType: 'json',

        beforeSend: function () {
            $("#p-bar").show();
            $("#p-bar").css("width", "100%");
            $("#p-bar").css("background-color", "blue");
            $("#p-bar").attr("aria-valuenow", "100");
        },

        success: function (response, e) {
            res = response;
        },

        complete: function (response) {
            addProgressBar();
        },

        error: function (data) {
            console.log(data);
        }
    });

    return res;

}

export function ajaxJsonRequest(url = "", payload = {}, method = "GET") {

    if (!url) {
        alert('url not found')
        return;
    }
    var res = "";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: method,
        url: url,
        data: JSON.stringify(payload), // Convert payload to JSON string
        async: false,
        dataType: 'json',
        contentType: 'application/json', // Set content type to JSON
        success: function (response) {
            res = response;
        },
        error: function (data) {
            console.log(data);
        }
    });

    return res;

}

export function myAjax() {}

export function resetProgressBar() {
    // Reset progress bar to 0%
    $("#p-bar").show();
    $("#p-bar").css("width", "0%");
    $("#p-bar").attr("aria-valuenow", "0");
    $("#p-bar").css("background-color", "blue");
}

export function addProgressBar() {
    setTimeout(() => {
        $("#p-bar").hide();
        $("#p-bar").css("width", "0%");
        $("#p-bar").css("background-color", "blue");
        $("#p-bar").attr("aria-valuenow", "0");
    }, 1000);

    setTimeout(() => {
        $("#p-bar").css("width", "0%");
        $("#p-bar").hide(500);
    }, 2000);
}

export function errorProgressBar() {
    // Reset progress bar to 0%
    $("#p-bar").show();
    $("#p-bar").css("width", "100%");
    $("#p-bar").attr("aria-valuenow", "100");
    $("#p-bar").css("background-color", "red");
}

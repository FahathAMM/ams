import Toastify from 'toastify-js'
import * as ajax from '../../js/ajax.js';

export {
    ajax
}; // Export ajax module for use in app.js


export function textRight(value) {
    return `<p class='p-0 m-0 text-end'>${value}</p>`
}


export function ActiveStatus(value = null) {
    if (value !== null) {
        return ` <span class="badge ${value ? 'bg-success' : 'bg-danger'}">${value ? 'Active' : 'Pending'}</span> `;
        // badge bg-success
    }
}

export function redirectTo(url) {
    window.location.href = url;
}

export function ActiveStatusold(value = null) {
    if (value !== null) {
        return `<p class="p-0 m-0 rounded text-center ${value ? 'bg-success' : 'bg-danger'}" style="width:50%; margin: 0 auto !important;">
                    <span class="badge ${value ? 'bg-success' : 'bg-danger'}">${value ? 'Active' : 'Pending'}</span>
                </p>`;
        // badge bg-success
    }
}


export function convertToDateFormat(data) {
    const parts = data.split("-");
    const day = parts[2];
    const month = parts[1];
    const year = parts[0];
    const formattedDate = `${day}-${month}-${year}`;
    return formattedDate || "";
}

export function validateField(fieldSelector) {
    const field = $(fieldSelector);
    field.removeClass('is-invalid');
    if (!field.val()) {
        field.addClass('is-invalid');
        field.addClass('is-invalid-select');
        return false;
    }
    return true;
}

export function activeTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
}

export function disableTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').addClass('disabled');
}

export function enableTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').removeClass('disabled');
}

export function clearField(field) {
    $(`#${field}`).val('');
    $(`#${field}`).val(null).trigger('change');
}

export function getValue(field) {
    return $(`#${field}`).val();
}

export function setValue(field, val) {
    return $(`#${field}`).val(val);
}

export function setValueByName(field, val) {
    $(`input[name="${field}"]`).val(val);
    $(`textarea[name="${field}"]`).val(val);
}

export function clearForm(form) {
    $(`#${form}`)[0].reset();
}

export function sAlert(msg = "", type = 'success', isEnable = false) {
    if (isEnable) {
        Swal.fire(createSwalConfig('Message', msg, type, 'OK'));
    }
}

export function sLoading(btnIdName) {

    $(`#${btnIdName}`).prop("disabled", true);
    $(`#${btnIdName}`).html(`<span class="fa fa-spinner fa-spin fa-lg me-2"" role="status" aria-hidden="true"></span>Loading...`);

    $(`.${btnIdName}`).prop("disabled", true);
    $(`.${btnIdName}`).html(`<span class="fa fa-spinner fa-spin fa-lg me-2"" role="status" aria-hidden="true"></span>Loading...`);
}

export function eLoading(btnIdName, title = 'Submit') {

    $(`#${btnIdName}`).prop("disabled", false);
    $(`#${btnIdName}`).html(title);

    $(`.${btnIdName}`).prop("disabled", false);
    $(`.${btnIdName}`).html(title);
}

export function formBtnSLoading(btnIdName) {
    $(`#${btnIdName}`).prop("disabled", true);
    $(`#${btnIdName}`).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
}

export function formBtnELoading(btnIdName) {
    $(`#${btnIdName}`).prop("disabled", false);

    if (btnIdName == 'storeBtn') {
        $(`#${btnIdName}`).html('<i class="far fa-save"></i>');
    }

    if (btnIdName == 'permstoreBtn') {
        $(`#${btnIdName}`).html('<i class="far fa-save"></i>');
    }
}

export function alertNotify(msg, status) {

    let sts = status || 'success';

    const arr = {
        success: 'success',
        error: 'danger',
        warning: 'info',
    }

    // Toastify({
    //     text: msg || '',
    //     duration: 3000,
    //     newWindow: true,
    //     close: true,
    //     gravity: "top", // `top` or `bottom`
    //     position: "center", // `left`, `center` or `right`
    //     stopOnFocus: true, // Prevents dismissing of toast on hover
    //     className: arr[sts],
    //     // style: {
    //     //     background: "linear-gradient(to right, #00b09b, #96c93d)",
    //     // },
    //     onClick: function () {} // Callback after click
    // }).showToast();

    Toastify({
        text: msg || '',
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: true,
        className: arr[sts], // Use the appropriate class for the status
        style: {
            background: sts === 'success' ? '#00b09b' : sts === 'error' ? '#dc3545' : '#17a2b8', // Adjust colors as needed
        },
        onClick: function () {} // Callback after click
    }).showToast();
}

export function myfun() {
    return 'myfum';
}

export function closeModal(modalId) {
    $(`#${modalId}`).modal('hide');
}

export function refreshContent(pageUrl = "", area = "") {
    var xhr = new XMLHttpRequest();
    // let currentUrl = pageUrl;
    // var url = `{{ url('${currentUrl}') }}`;
    var url = pageUrl;
    console.log('urle', url);
    xhr.open('GET', url, true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            var responseHTML = xhr.responseText;

            // Create a temporary element to parse the response HTML
            var tempElement = document.createElement('div');
            tempElement.innerHTML = responseHTML;

            // Find the specific div you want to replace
            var newContent = tempElement.querySelector(`#${area}`).innerHTML;

            // Replace the content of #area-my with the new content
            document.getElementById(`${area}`).innerHTML = newContent;
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    };

    xhr.send();
}

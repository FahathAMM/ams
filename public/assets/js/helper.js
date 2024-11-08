function textRight(value) {
    return `<p class='p-0 m-0 text-end'>${value}</p>`
}


function ActiveStatus(value = null) {
    if (value !== null) {
        return ` <span class="badge ${value ? 'bg-success' : 'bg-danger'}">${value ? 'Active' : 'Pending'}</span> `;
        // badge bg-success
    }
}

function redirectTo(url) {
    window.location.href = url;
}

function ActiveStatusold(value = null) {
    if (value !== null) {
        return `<p class="p-0 m-0 rounded text-center ${value ? 'bg-success' : 'bg-danger'}" style="width:50%; margin: 0 auto !important;">
                    <span class="badge ${value ? 'bg-success' : 'bg-danger'}">${value ? 'Active' : 'Pending'}</span>
                </p>`;
        // badge bg-success
    }
}


function convertToDateFormat(data) {
    const parts = data.split("-");
    const day = parts[2];
    const month = parts[1];
    const year = parts[0];
    const formattedDate = `${day}-${month}-${year}`;
    return formattedDate || "";
}

function validateField(fieldSelector) {
    const field = $(fieldSelector);
    field.removeClass('is-invalid');
    if (!field.val()) {
        field.addClass('is-invalid');
        field.addClass('is-invalid-select');
        return false;
    }
    return true;
}

function activeTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
}

function disableTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').addClass('disabled');
}

function enableTab(tab) {
    $('.nav-tabs a[href="#' + tab + '"]').removeClass('disabled');
}

function clearField(field) {
    $(`#${field}`).val('');
    $(`#${field}`).val(null).trigger('change');
}

function getValue(field) {
    return $(`#${field}`).val();
}

function setValue(field, val) {
    return $(`#${field}`).val(val);
}

function sAlert(msg = "", type = 'success', isEnable = false) {
    if (isEnable) {
        Swal.fire(createSwalConfig('Message', msg, type, 'OK'));
    }
}

function sLoading(btnIdName) {
    $(`#${btnIdName}`).prop("disabled", true);
    $(`#${btnIdName}`).html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...`);
}

function eLoading(btnIdName, title = 'Submit') {
    $(`#${btnIdName}`).prop("disabled", false);
    $(`#${btnIdName}`).html(title);
}

function formBtnSLoading(btnIdName) {
    $(`#${btnIdName}`).prop("disabled", true);
    $(`#${btnIdName}`).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
}

function formBtnELoading(btnIdName) {
    $(`#${btnIdName}`).prop("disabled", false);

    if (btnIdName == 'storeBtn') {
        $(`#${btnIdName}`).html('<i class="far fa-save"></i>');
    }

    if (btnIdName == 'permstoreBtn') {
        $(`#${btnIdName}`).html('<i class="far fa-save"></i>');
    }
}

function alertNotify(msg, status) {

    let sts = status || 'success';

    const arr = {
        success: 'success',
        error: 'danger',
        warning: 'info',
    }

    Toastify({
        text: msg || '',
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        className: arr[sts],
        // style: {
        //     background: "linear-gradient(to right, #00b09b, #96c93d)",
        // },
        onClick: function () {} // Callback after click
    }).showToast();
}

function myfun() {
    return 'myfum';
}

function closeModal(modalId) {
    $(`#${modalId}`).modal('hide');
}

function refreshContent(pageUrl = "", area = "") {
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

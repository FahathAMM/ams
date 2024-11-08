$(document).ready(function () {
    var CurrentUrl = window.location.href;
    const selectedValue = sessionStorage.getItem('dataTablePageSize');
    const sesCurrentUrl = sessionStorage.getItem('sesCurrentUrl');
    if (selectedValue && (sesCurrentUrl == CurrentUrl)) {
        setTimeout(function () {
            // $('#datatable-crud_length select').val(selectedValue).change();
        }, 100);

    }
});

$(document).on('change', '#datatable-crud_length select', function () {
    const selectedValue = $(this).val();
    var sesCurrentUrl = window.location.href;
    sessionStorage.setItem('dataTablePageSize', selectedValue);
    sessionStorage.setItem('sesCurrentUrl', sesCurrentUrl);
});

$('#datatable-crud tbody').on('click', 'tr', function () {
    $('#datatable-crud tbody tr').removeClass('selected-row');
    $(this).addClass('selected-row');
});

$('.datatable-crud tbody').on('click', 'tr', function () {
    $('.datatable-crud tbody tr').removeClass('selected-row');
    $(this).addClass('selected-row');
});

$('#datatable-crud1 tbody').on('click', 'tr', function () {
    $('#datatable-crud1 tbody tr').removeClass('selected-row');
    $(this).addClass('selected-row');
});

$('body').on('click', '#datatable-crud tr', function () {
    $('#datatable-crud tbody tr').removeClass('selected-row');
    $(this).addClass('selected-row');
});

$('body').on('click', '#datatable tr', function () {
    $('#datatable tbody tr').removeClass('selected-row');
    $(this).addClass('selected-row');
});

$('body').on('click', '.delete', function () {
    var id = $(this).attr('id');
    var deleteUrl = $(this).attr('delete-url');
    var deleteItem = $(this).attr('delete-item');
    Swal.fire({
        title: `<span style="font-size: 14px;">Are you sure want to delete "${deleteItem}"?</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        // confirmButtonText: 'Yes, delete it!',
        confirmButtonText: '<span class="custom-button-text" style="font-size: 14px;">Yes</span>',
        cancelButtonText: '<span class="custom-button-text" style="font-size: 14px;">No</span>',
        customClass: {
            icon: 'sweet-icon-size',
            container: 'delete-swal-container',
            // confirmButton: 'your-custom-button-class'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `${deleteUrl}/${id}`,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (res) {

                    const dataTable = $('#datatable-crud').DataTable();
                    dataTable.draw(false);

                    const title = res.status ? 'Deleted!' : 'Oops...';
                    const message = res.status ? (res.message || 'Your file has been deleted.') : (res.message || res.message.errorInfo[2] || 'Your file could not be deleted.');
                    const icon = res.status ? 'success' : 'error';
                    Swal.fire(createSwalConfig(title, message, icon, 'OK'));
                }
            });
        }
    })
});


// =====================js functions===================================

function createSwalConfig(title, message, icon, buttonText) {
    return {
        title: `<span style="font-size: 14px;">${title}</span>`,
        html: `<span style="font-size: 14px;">${message}</span>`,
        icon: icon,
        confirmButtonText: `<span class="custom-button-text" style="font-size: 14px;">${buttonText}</span>`,
        customClass: {
            icon: 'sweet-icon-size',
            container: 'success-delete-swal-container',
            confirmButton: 'success-delete-swal-confirm-btn',
        }
    };
}

function textRight(value) {
    return `<p class='p-0 m-0 text-end'>${value}</p>`
}

function formAction(value) {
    const arr = {
        Create: 'bg-success',
        Update: 'bg-primary',
        Delete: 'bg-danger',
    }
    return `<p class="p-0 m-0 rounded text-center ${arr[value]}" style="width:30%; margin: 0 auto !important;"> <span class="text-white py-0"> ${value} </span> </p>`;
}


function getExportButtons(pdf = false, excel = false, print = false, copy = false, actionColumnIndex = null) {
    const buttons = [];

    if (excel) {
        buttons.push({
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':not(:eq(' + actionColumnIndex + '))', // Exclude the Action column
                modifier: {
                    selected: null
                }
            },

            text: '<i class="fa fa-file-excel fa-1x text-white" style="font-size: 12px;"></i>',
            className: 'bg-success text-white border-success me-1',
            titleAttr: 'Excel',

        });
    }

    if (print) {
        buttons.push({
            extend: 'print',
            exportOptions: {
                columns: ':not(:eq(' + actionColumnIndex + '))' // Exclude the Action column
            },
            text: '<i class="fa fa-print fa-1x text-white" style="font-size: 12px;"></i>',
            className: 'bg-info text-white border-info me-1',
            titleAttr: 'Print',
        });
    }

    if (pdf) {
        buttons.push({
            extend: 'pdfHtml5',
            orientation: 'portrait',
            pageSize: 'A3',
            text: '<i class="fa fa-file-pdf"></i>',
            className: 'bg-success text-white border-success me-1',
            titleAttr: 'PDF',
        });
    }

    if (copy) {
        buttons.push({
            extend: 'copy',
            text: '<i class="fa fa-copy"></i>',
            titleAttr: 'Copy',
        });
    }

    return buttons;
}

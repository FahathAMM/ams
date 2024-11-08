//
import "../assets/libs/bootstrap/js/bootstrap.bundle.min.js";
import "../assets/libs/simplebar/simplebar.min.js";
import "../assets/libs/feather-icons/feather.min.js";
// import "../assets/js/pages/plugins/lord-icon-2.1.0.js";
import "../assets/js/plugins.js";
// import "https://cdn.jsdelivr.net/npm/toastify-js";

import "../assets/libs/choices.js/public/assets/scripts/choices.min.js";
// import "../assets/js/choices.min.js";

import "../assets/libs/flatpickr/flatpickr.min.js";

//  <!-- external plugin -->

import "../assets/libs/prismjs/prism.js";
import "../assets/libs/apexcharts/apexcharts.min.js";

// <!-- Sweet Alerts js -->
import "../assets/libs/sweetalert2/sweetalert2.min.js";

//   apexcharts
import "../assets/libs/apexcharts/apexcharts.min.js";

//   Vector map
import "../assets/libs/jsvectormap/js/jsvectormap.min.js";
import "../assets/libs/jsvectormap/maps/world-merc.js";

//   Swiper slider js
import "../assets/libs/swiper/swiper-bundle.min.js";

// Toastify notification
import Toastify from 'toastify-js'

//   Dashboard init
import "../assets/js/pages/dashboard-ecommerce.init.js";
import "../assets/js/custom.js";

//  <!-- external plugin -->

import "../assets/js/app.js";
import "../assets/js/custom-table.js";

//  <!-- helper file -->
import * as helper from '../assets/js/helper.js';

const functionsToAssign = [

    // toastify.js
    'Toastify',

    //helper.js
    'convertToDateFormat',
    'validateField',
    'activeTab',
    'disableTab',
    'enableTab',
    'clearField',
    'getValue',
    'setValue',
    'sAlert',
    'sLoading',
    'eLoading',
    'formBtnSLoading',
    'formBtnELoading',
    'alertNotify',
    'textRight',
    'ActiveStatus',
    'myfun',
    'redirectTo',
    'closeModal',
    'refreshContent',

    //ajax.js
    'myAjax',
    'ajaxRequest',
    'ajaxJsonRequest',
    'associateErrors',
    'sendData'
];

// functionsToAssign.forEach(fn => {
//     window[fn] = helper[fn];
// });


functionsToAssign.forEach(fn => {
    if (helper[fn]) {
        window[fn] = helper[fn];
    } else if (helper.ajax[fn]) {
        window[fn] = helper.ajax[fn];
    }
});

//
import "../css/app.css";

import "../sass/app.scss";


//  <!-- external plugin -->

import "../assets/js/custom.js";
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
    'clearForm',
    'getValue',
    'setValue',
    'setValueByName',
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

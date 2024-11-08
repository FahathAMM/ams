// let form = document.getElementById('employee-form');
// var url = form.getAttribute('action');
// // var method = form.getAttribute('method');
// let formData = new FormData(form);
// var payload = {};
// // const url = 'https://example.com/api';
// // const payload = formData;

let form = $('#employee-form');
var url = form.attr('action');
var payload = {};

form.find('input, select').each(function() {
payload[$(this).attr('name')] = $(this).val();
});

// form.find('input, select').each(function() {
// payload[$(this).attr('name')] = $(this).val();
// });

// const url = 'https://example.com/api';
// const payload = formData;
// const payload = {
// key: 'value',
// '_token': document.querySelector('meta[name="csrf-token"]').content
// };
const options = {
contentType: 'application/json', // or 'multipart/form-data' for FormData
method: 'POST', // optional, defaults to 'POST'
headers: {
// Additional headers can be provided here
// 'Authorization': 'Bearer YOUR_ACCESS_TOKEN',
},
successCallback: (data) => {
console.log('Success:', data);
},
errorCallback: (error) => {
console.error('Error:', error);
},
};

sendData(url, payload, options);

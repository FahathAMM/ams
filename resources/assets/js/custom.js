export function textRight(value) {
    return `<p class='p-0 m-0 text-end'>${value}</p>`
}



export function ActiveStatus(value = null) {
    if (value !== null) {
        return `<p class="p-0 m-0 rounded text-center ${value ? 'bg-success' : 'bg-danger'}" style="width:50%; margin: 0 auto !important;">
                    <span class="text-white py-0">${value ? 'Active' : 'Pending'}</span>
                </p>`;
    }
}

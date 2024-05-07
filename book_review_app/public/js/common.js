// close the message
document.addEventListener('DOMContentLoaded', (event) => {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        alertBox.addEventListener('click', function () {
            this.style.display = 'none';
        });
    }
});

// clear search
function clearKeywordAndRedirect() {
    const keywordInput = document.getElementById('keyword');
    keywordInput.value = '';
    keywordInput.form.submit();
}
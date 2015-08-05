console.log('hello world');

var deleteForm = document.querySelector('form');
var action = deleteForm.getAttribute('action');
console.log(action);

var button = document.querySelector('#form_submit');
button.addEventListener('click', function(e) {
    e.preventDefault();
    var answer = confirm('Are you sure');

    if (answer) {
        deleteForm.submit();

        // var xhr = new XMLHttpRequest();
        //
        // xhr.onreadystatechange = function() {
        //     if (xhr.readyState === 4) {
        //         window.location = '/blog_app/web/articles/';
        //     }
        // }
        //
        // xhr.open('POST', action);
        // xhr.send();
    } else {
        console.log('quit');
        return;
    }
});

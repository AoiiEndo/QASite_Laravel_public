document.addEventListener("DOMContentLoaded", function() {
    if (typeof MathJax !== 'undefined') {
        MathJax.typesetPromise().catch(function(err) {
        });
    }
});
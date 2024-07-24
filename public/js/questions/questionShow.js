document.addEventListener("DOMContentLoaded", function() {
    if (typeof MathJax !== 'undefined') {
        // MathJaxのスクリプトが読み込まれているか確認
        MathJax.typesetPromise().catch(function(err) {
            console.log(err.message);
        });
    } else {
        console.error("MathJax is not loaded");
    }
});

document.addEventListener("DOMContentLoaded", function() {
    if (typeof MathJax !== 'undefined') {
        MathJax.typesetPromise().catch(function(err) {
        });
    }
});

// ###############################################
// お気に入り登録
// ###############################################
document.addEventListener('DOMContentLoaded', function () {
    const favoriteBtn = document.getElementById('favorite-btn');
    const favoriteIcon = favoriteBtn.querySelector('.favorite-icon');

    favoriteBtn.addEventListener('click', function () {
        const exerciseId = Number(document.getElementById('exercise-id').value);
        const form = document.getElementById('favorite-form');
        const formData = new FormData(form);
        const isFavorited = favoriteBtn.classList.contains('favorited');
        
        fetch(`favorites/${exerciseId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (!isFavorited) {
                    favoriteBtn.classList.add('favorited');
                    favoriteIcon.classList.remove('fa-star-o');
                    favoriteIcon.classList.add('fa-star');
                    favoriteIcon.style.color = 'yellow';
                } else {
                    favoriteBtn.classList.remove('favorited');
                    favoriteIcon.classList.remove('fa-star');
                    favoriteIcon.classList.add('fa-star-o');
                    favoriteIcon.style.color = '';
                }
                alert(data.message);
            } else {
                alert('失敗しました。再度行ってください。');
            }
        })
        .catch(error => {
            alert("予想外のエラーが発生しました。");
        });
    });
});

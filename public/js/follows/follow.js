document.addEventListener('DOMContentLoaded', function () {
    const followForm = document.getElementById('follow-form');
    const unfollowForm = document.getElementById('unfollow-form');

    function handleFormSubmit(form, errorMessage) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (form.id === 'follow-form') {
                        alert("フォローしました。");
                        document.getElementById('follow-form').style.display = 'none';
                        document.getElementById('unfollow-form').style.display = 'block';
                    } else {
                        alert("フォローを解除しました。");
                        document.getElementById('follow-form').style.display = 'block';
                        document.getElementById('unfollow-form').style.display = 'none';
                    }
                } else {
                    alert(errorMessage);
                }
            })
            .catch(error => 
                alert('エラーが発生しました: ')
            );
        });
    }

    if (followForm) {
        handleFormSubmit(followForm, 'フォローに失敗しました。');
    }

    if (unfollowForm) {
        handleFormSubmit(unfollowForm, 'フォロー解除に失敗しました。');
    }
});

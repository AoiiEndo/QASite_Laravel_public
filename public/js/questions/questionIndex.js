let nextPageUrl = "{{ $questions->nextPageUrl() }}";
const loadMoreBtn = document.getElementById('load-more-btn');

// loadMoreBtn.addEventListener('click', function() {
//     fetchQuestions();
// });

function fetchQuestions() {
    fetch(nextPageUrl)
        .then(response => response.json())
        .then(data => {
            const questionList = document.getElementById('question-list');
            data.data.forEach(question => {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question';
                questionDiv.innerHTML = `
                    <h2>${question.title}</h2>
                    <div class="tags">
                        ${question.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                    </div>
                    <div class="info">
                        <span>${question.created_at}</span>
                        <span>${question.user.name}</span>
                    </div>
                `;
                questionList.appendChild(questionDiv);
            });

            nextPageUrl = data.next_page_url;
            if (!nextPageUrl) {
                loadMoreBtn.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching questions:', error));
};

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.question').forEach(function(element) {
        element.addEventListener('click', function() {
            const url = this.getAttribute('data-href');
            if (url) {
                window.location.href = url;
            }
        });
    });
});

// ###############################################
// 質問一覧出力の背景色を時間で変更
// ###############################################
function setBackgroundColorBasedOnTime(element, createdAt) {
    const currentTime = new Date();
    const createdAtDate = new Date(createdAt);
    const diffInMinutes = Math.floor((currentTime - createdAtDate) / (1000 * 60));

    const minColor = [123, 174, 250];
    const maxColor = [250, 123, 123];

    const ratio = Math.min(diffInMinutes / (24 * 60), 1);
    const rgb = minColor.map((channel, index) => {
        const maxChannel = maxColor[index];
        const blendedChannel = Math.round(channel + (maxChannel - channel) * ratio);
        return blendedChannel;
    });

    const bgColor = `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;

    element.style.backgroundColor = bgColor;
};

document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question');
    questions.forEach(question => {
        const createdAtElement = question.querySelector('.created-at');
        const createdAtTimestamp = createdAtElement.getAttribute('data-timestamp');

        setBackgroundColorBasedOnTime(question, createdAtTimestamp);
    });
});
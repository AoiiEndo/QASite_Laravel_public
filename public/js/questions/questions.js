const tagInput = document.getElementById('tags');
const tagList = document.getElementById('tag-list');
const tagError = document.getElementById('tag-error');

const predefinedTags = ['javascript', 'php', 'laravel', 'html', 'css', 'vuejs', 'react', 'angular'];

tagInput.addEventListener('input', function() {
    const tags = tagInput.value.split('/').filter(tag => tag.trim() !== '');
    if (tags.length > 5 || tags.some(tag => tag.length > 15)) {
        tagError.style.display = 'block';
    } else {
        tagError.style.display = 'none';
    }

    updateTagList(tags);
});

function updateTagList(tags) {
    tagList.innerHTML = '';
    tags.forEach(tag => {
        const tagElement = document.createElement('span');
        tagElement.className = 'tag';
        tagElement.textContent = tag;
        tagElement.addEventListener('click', function() {
            removeTag(tag);
        });
        tagList.appendChild(tagElement);
    });
}

function removeTag(tag) {
    const tags = tagInput.value.split('/').filter(t => t.trim() !== '' && t !== tag);
    tagInput.value = tags.join('/');
    updateTagList(tags);
}

document.addEventListener("DOMContentLoaded", function() {
    // MathJaxの設定
    MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']]
        }
    };
});

const contentInput = document.getElementById('content');
const preview = document.getElementById('preview');

contentInput.addEventListener('input', function() {
    const content = contentInput.value;
    preview.innerHTML = '';
    try {
        // MathJax.typesetClear();
        MathJax.typesetPromise([preview, content]).then(() => {
            // 成功時の処理
            MathJax.typesetPromise([preview]); // プレビュー内の全ての数式を再描画
        }).catch((err) => {
            console.error('Error rendering LaTeX:', err);
        });
    } catch (err) {
        console.error('Error rendering LaTeX:', err);
    }
});
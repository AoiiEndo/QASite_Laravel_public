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

document.getElementById('content').addEventListener('input', function() {
    var input = document.getElementById('content').value;
    var preview = document.getElementById('preview');
    
    // MathJaxに渡すHTML内容を設定
    var latexContent = input.replace(/\$(.*?)\$/g, '\\[$1\\]');
    preview.innerHTML =  latexContent;
    
    // MathJaxで再レンダリング
    MathJax.typesetPromise([preview]).catch(function(err) {
    });
});
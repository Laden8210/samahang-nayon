

document.getElementById('uploadFile').addEventListener('change', function(event) {
    const files = event.target.files;
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = ''; // Clear previous images

    for (const file of files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.classList.add('relative', 'rounded', 'border', 'border-slate-400', 'h-1/2', 'w-1/2', 'bg-slate-100', 'm-2');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('h-full', 'w-full', 'object-cover');

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'p-1', 'm-1', 'hover:bg-red-700');
            removeBtn.addEventListener('click', function() {
                div.remove();
            });

            div.appendChild(img);
            div.appendChild(removeBtn);
            container.appendChild(div);
        }
        reader.readAsDataURL(file);
    }
});

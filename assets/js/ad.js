document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.querySelector('#add-image');
    const container = document.querySelector('#ad_images');
    const counter = document.querySelector('#widgets-counter');

    if (addBtn) {
        addBtn.addEventListener('click', () => {
            const index = +counter.value;
            const proto = container.dataset.prototype.replace(/__name__/g, index);
            container.insertAdjacentHTML('beforeend', proto);
            counter.value = index + 1;
            handleDeleteButtons();
        });
    }

    function handleDeleteButtons() {
        document.querySelectorAll('button[data-action="delete"]').forEach(btn => {
            btn.onclick = function() {
                const target = document.querySelector(this.dataset.target);
                if (target) target.remove();
            };
        });
    }
    handleDeleteButtons();
});

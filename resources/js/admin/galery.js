import Sortable from 'sortablejs'

export function gallerySortable () {
    return {
        initSortable() {
            const el = document.getElementById('image-gallery');
            if (!el) return;

            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: () => {
                    const order = Array.from(el.children)
                        .filter(child => child.dataset.id)
                        .map(child => parseInt(child.dataset.id));

                    fetch('/admin/projects/' + el.dataset.projectId + '/images/reorder', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ order })
                    }).then(r => r.json()).then(console.log);
                }
            });
        }
    };
};

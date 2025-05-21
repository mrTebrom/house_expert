import Sortable from 'sortablejs'

export function gallerySortable(projectId) {
    return {
        lastOrder: [],

        initSortable() {
            const el = document.getElementById('sortable-wrapper');
            if (!el) return;

            const getCurrentOrder = () => {
                return Array.from(el.querySelectorAll('[data-id]'))
                    .map(child => parseInt(child.dataset.id));
            };

            this.lastOrder = getCurrentOrder();

            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                draggable: '.col-md-3',
                onEnd: () => {
                    const newOrder = getCurrentOrder();

                    // Проверка: если порядок не изменился — ничего не делаем
                    if (JSON.stringify(this.lastOrder) === JSON.stringify(newOrder)) {
                        return;
                    }

                    this.lastOrder = newOrder;

                    // Отложенная отправка (debounce-like)
                    setTimeout(() => {
                        fetch(`/admin/projects/${projectId}/images/reorder`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ order: newOrder })
                        }).then(r => r.json()).then(console.log);
                    }, 300);
                }
            });
        }
    };
}

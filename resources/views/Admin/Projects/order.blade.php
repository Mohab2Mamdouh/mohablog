@php
    $title = "Projects Order"
@endphp

@extends('Admin.layouts.page')

@section('section')

<style>
    .order-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-width: 800px;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 24px;
        margin-bottom: 12px;
        cursor: grab;
        transition: all 0.25s ease;
        user-select: none;
    }

    .order-item:active {
        cursor: grabbing;
    }

    .order-item:hover {
        border-color: #6366f1;
        box-shadow: 0 4px 20px rgba(99,102,241,0.15);
        transform: translateX(4px);
    }

    .order-item.dragging {
        opacity: 0.5;
        border-color: #6366f1;
        background: #f1f5f9;
    }

    .order-item.saving {
        border-color: #f59e0b;
        opacity: 0.7;
    }

    .order-item.saved {
        border-color: #10b981;
    }

    .order-item.error {
        border-color: #ef4444;
    }

    .order-item .drag-handle {
        color: #94a3b8;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .order-item .order-number {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .order-item .project-name {
        font-weight: 600;
        color: #0f172a;
        flex: 1;
    }

    .order-item .project-tech {
        color: #94a3b8;
        font-size: 0.8rem;
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-item .status-icon {
        flex-shrink: 0;
        width: 20px;
        text-align: center;
        font-size: 0.85rem;
    }

    .btn-back {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 24px;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .order-hint {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 24px;
    }
</style>

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            <a href="{{ route('projects.show') }}">{{ __('Projects') }}</a>
            <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            <span style="color: #64748b;">{{ __('Order') }}</span>
        </h4>
    </div>
</section>

<section class="content" style="padding-top: 30px;">
    <div class="container">
        <p class="order-hint">
            <i class="fas fa-grip-vertical"></i>
            {{ __('Drag and drop projects to reorder them. Changes are saved automatically.') }}
        </p>

        <ul class="order-list" id="sortable-list">
            @foreach($projects as $project)
                <li class="order-item" data-id="{{ $project->id }}" draggable="true">
                    <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                    <span class="order-number">{{ $loop->iteration }}</span>
                    <span class="project-name">{{ $project->name }}</span>
                    <span class="project-tech">{{ $project->techmologyStack }}</span>
                    <span class="status-icon"></span>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('projects.show') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> {{ __('Back to Projects') }}
        </a>
    </div>
</section>

<script>
    const list = document.getElementById('sortable-list');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const updateUrl = '{{ route("projects.updateOrder") }}';
    let draggedItem = null;

    list.addEventListener('dragstart', (e) => {
        draggedItem = e.target.closest('.order-item');
        if (draggedItem) {
            draggedItem.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    list.addEventListener('dragend', () => {
        if (draggedItem) {
            draggedItem.classList.remove('dragging');
            draggedItem = null;
            updateNumbers();
            saveOrder();
        }
    });

    list.addEventListener('dragover', (e) => {
        e.preventDefault();
        const afterElement = getDragAfterElement(list, e.clientY);
        if (draggedItem) {
            if (afterElement == null) {
                list.appendChild(draggedItem);
            } else {
                list.insertBefore(draggedItem, afterElement);
            }
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.order-item:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function updateNumbers() {
        document.querySelectorAll('.order-item').forEach((item, index) => {
            item.querySelector('.order-number').textContent = index + 1;
        });
    }

    function saveOrder() {
        const items = document.querySelectorAll('.order-item');
        const order = [...items].map(item => parseInt(item.getAttribute('data-id')));

        // Show saving state on all items
        items.forEach(item => {
            item.classList.remove('saved', 'error');
            item.classList.add('saving');
            item.querySelector('.status-icon').innerHTML = '<i class="fas fa-spinner fa-spin" style="color: #f59e0b;"></i>';
        });

        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ order: order }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed');
            return response.json();
        })
        .then(() => {
            items.forEach(item => {
                item.classList.remove('saving');
                item.classList.add('saved');
                item.querySelector('.status-icon').innerHTML = '<i class="fas fa-check" style="color: #10b981;"></i>';
            });
            setTimeout(() => {
                items.forEach(item => {
                    item.classList.remove('saved');
                    item.querySelector('.status-icon').innerHTML = '';
                });
            }, 1500);
        })
        .catch(() => {
            items.forEach(item => {
                item.classList.remove('saving');
                item.classList.add('error');
                item.querySelector('.status-icon').innerHTML = '<i class="fas fa-times" style="color: #ef4444;"></i>';
            });
            setTimeout(() => {
                items.forEach(item => {
                    item.classList.remove('error');
                    item.querySelector('.status-icon').innerHTML = '';
                });
            }, 3000);
        });
    }
</script>

@endsection


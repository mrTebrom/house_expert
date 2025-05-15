@foreach ($sliders as $slider)
    <tr>
        <td>{{ $slider->id }}</td>
        <td>{{ $slider->title }}</td>
        <td>
            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-warning">
                ✏️ Редактировать
            </a>
            <form
                action="{{ route('admin.sliders.destroy', $slider) }}"
                method="POST"
                class="d-inline"
                onsubmit="return confirm('Удалить слайд?');"
            >
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">🗑 Удалить</button>
            </form>
        </td>
    </tr>
@endforeach

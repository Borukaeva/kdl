@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-1">Фото</th>
                <th scope="col" class="col-auto">Название</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            <tr class="js-field_add field_add">
                <td colspan="3">
                    <form action="{{ route('test_tubes.store') }}" method="post">
                        @csrf
                        <table>
                            <tr>
                                <td scope="row" class="col-1">
                                    <div class="list_item-img" title="Загрузить изображение">
                                        <input name="img" id="inputFile" type="file" class="file_uploader">
                                        <label for="inputFile"
                                               class="d-flex justify-content-center align-items-center file_uploader_label"><i
                                                class="bi bi-file-earmark-plus"></i></label>
                                    </div>
                                </td>
                                <td class="col-auto">
                                    <input type="text" name="name" id="name" class="form-control">
                                </td>
                                <td class="col-1">
                                    <ul class="justify-content-end list-unstyled d-flex">
                                        <li class="ml-3">
                                            <a href="javascript:void(0);" class="js-submit" title="Добавить"><i
                                                    class="bi bi-check-lg"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach($elements as $element)
                @include('admin.test_tube.ajax', ['element' => $element, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        {{ $elements->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.test_tube.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td scope="row" class="d-flex justify-content-center align-items-center list_item-img">
            @if ($element->img != '')
                <img src="/storage/{{ $element->img }}">
            @else
                <i class="bi bi-image"></i>
            @endif
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('test_tubes.edit', [$element]) }}"
                       class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('test_tubes.destroy', [$element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('edit')
        <td colspan="3" class="form_row">
            <form action="{{ route('test_tubes.update', [$element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td scope="row" class="col-1">
                            <div class="list_item-img" title="Загрузить изображение">
                                <input name="img" id="inputFile_{{ $element }}" type="file"
                                       class="file_uploader">
                                <label for="inputFile_{{ $element }}"
                                       class="d-flex justify-content-center align-items-center file_uploader_label">
                                    @if ($element->img != '')
                                        <img src="/storage/{{ $element->img }}">
                                    @else
                                        <i class="bi bi-file-earmark-plus"></i>
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td class="col-auto">
                            <input type="text" name="name" id="name_{{ $element }}" class="form-control"
                                   value="{{ $element->name }}">
                        </td>
                        <td class="col-1">
                            <ul class="justify-content-end list-unstyled d-flex">
                                <li class="ml-3">
                                    <a href="javascript:void(0);" class="js-submit" title="Сохранить"><i
                                            class="bi bi-check-lg"></i></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        @break

        @default
    @endswitch
@endif



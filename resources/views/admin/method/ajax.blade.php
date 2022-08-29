@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-auto">Название</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            <tr class="js-field_add field_add">
                <td colspan="2">
                    <form action="{{ route('method.store') }}" method="post">
                        @csrf
                        <table>
                            <tr>
                                <td class="col-auto">
                                    <input type="text" name="name" id="name" class="form-control">
                                </td>
                                <td class="col-auto">
                                    <input type="text" name="template" id="template" class="form-control">
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
                <tr class="js-field field">
                    @include('admin.method.ajax', ['element' => $element, 'ajax' => 'show'])
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $elements->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
        @break

        @case('show')
        @include('admin.method.ajax', ['element' => $element, 'ajax' => 'item'])
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('method.edit', [$element]) }}"
                       class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('method.destroy', [$element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('edit')
        <td colspan="3" class="form_row">
            <form action="{{ route('method.update', [$element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-auto">
                            <input type="text" name="name" class="form-control"
                                   value="{{ $element->name }}">
                        </td>
                        <td class="col-auto">
                            <input type="text" name="template" class="form-control"
                                   value="{{ $element->template }}">
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
        Default case...
    @endswitch
@endif



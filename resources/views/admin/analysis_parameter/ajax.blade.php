@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-auto">Название</th>
                <th scope="col" class="col-3">Единицы измерения</th>
                <th scope="col" class="col-2">Тип</th>
                <th scope="col" class="col-1">Норма&nbsp;1</th>
                <th scope="col" class="col-1">Норма&nbsp;2</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            <tr class="js-field_add field_add">
                <td colspan="6">
                    <form action="{{ route('analysis.parameters.store', [$element]) }}" method="post">
                        @csrf
                        <table>
                            <tr>
                                <td class="col-auto">
                                    <input type="text" name="name" class="form-control">
                                </td>
                                <td class="col-3">
                                    <select name="unit_id" class="form-select" id="unit_id">
                                        <option value="">Выберите единицу измерения</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-2">
                                    <select name="type_id" class="form-select" id="type_id">
                                        <option value="">Выберите тип</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-1">
                                    <input type="text" name="norm1" class="form-control" value="">
                                </td>
                                <td class="col-1">
                                    <input type="text" name="norm2" class="form-control" value="">
                                </td>
                                <td class="col-1">
                                    <input type="hidden" name="analysis_id" value="{{ $element->id }}">
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
            @foreach($element->parameters as $parameter)
                @include('admin.analysis_parameter.ajax', ['element' => $parameter, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.analysis_parameter.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->unit->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->type->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->norm1 }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->norm2 }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('analysis.parameters.edit', [$element->analysis, $element]) }}"
                       class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('analysis.parameters.destroy', [$element->analysis, $element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('edit')
        <td colspan="6" class="form_row">
            <form action="{{ route('analysis.parameters.update', [$element->analysis, $element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-auto">
                            <input type="text" name="name" class="form-control" value="{{ $element->name }}">
                        </td>
                        <td class="col-3">
                            <select name="unit_id" class="form-select" id="unit_id">
                                <option value="">Выберите единицу измерения</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" @if($element->unit->id == $unit->id) selected @endif>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="col-2">
                            <select name="type_id" class="form-select" id="type_id">
                                <option value="">Выберите тип</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" @if($element->type->id == $type->id) selected @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="col-1">
                            <input type="text" name="norm1" class="form-control" value="{{ $element->norm1 }}">
                        </td>
                        <td class="col-1">
                            <input type="text" name="norm2" class="form-control" value="{{ $element->norm2 }}">
                        </td>
                        <td class="col-1">
                            <input type="hidden" name="analysis_id" value="{{ $element->analysis_id }}">
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



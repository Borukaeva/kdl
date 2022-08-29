@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-4">Биоматериалы</th>
                <th scope="col" class="col-4">Пробирки</th>
                <th scope="col" class="col-2">Не выводить в прайсах</th>
                <th scope="col" class="col-2">Действия</th>
            </tr>
            @include('admin.analysis_biomaterial.ajax', ['element' => $element, 'biomaterials' => $biomaterials, 'testtubes' => $testtubes, 'ajax' => 'add'])
            </thead>
            <tbody>
            @foreach($element->biomaterials as $biomaterial)
                @include('admin.analysis_biomaterial.ajax', ['element' => $biomaterial, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        @break

        @case('add')
        <tr class="js-field_add field_add">
            <td colspan="4">
                <form action="{{ route('analysis.biomaterials.store', [$element]) }}" method="post">
                    @csrf
                    <table>
                        <tr>
                            <td class="col-4">
                                <select name="biomaterials_id" class="form-select" id="biomaterials_id">
                                    <option value="">Выберите биоматериал</option>
                                    @foreach($biomaterials as $biomaterial)
                                        <option value="{{ $biomaterial->id }}">{{ $biomaterial->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback error_label biomaterials_id_label"></div>
                            </td>
                            <td class="col-4">
                                <select name="test_tubes_id" class="form-select" id="test_tubes_id">
                                    <option value="">Выберите пробирку</option>
                                    @foreach($testtubes as $testtube)
                                        <option value="{{ $testtube->id }}">{{ $testtube->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback error_label test_tubes_id_label"></div>
                            </td>
                            <td class="col-2">
                                <input type="checkbox" name="hide_in_price" value="1">
                            </td>
                            <td class="col-2">
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
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.analysis_biomaterial.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->biomaterial->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->testTube->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">
                @if($element->hide_in_price)
                    <i class="bi bi-eye-slash text-danger"></i>
                @else
                    <i class="bi bi-eye text-success"></i>
                @endif
            </strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('analysis.biomaterials.edit', [$element->analysis, $element]) }}"
                       class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('analysis.biomaterials.destroy', [$element->analysis, $element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('edit')
        <td colspan="4" class="form_row">
            <form action="{{ route('analysis.biomaterials.update', [$element->analysis, $element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-4">
                            <select name="biomaterials_id" class="form-select" id="biomaterials_id">
                                <option value="">Выберите биоматериал</option>
                                @foreach($biomaterials as $biomaterial)
                                    <option value="{{ $biomaterial->id }}"
                                            @if($element->biomaterial->id == $biomaterial->id) selected @endif>{{ $biomaterial->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback error_label biomaterials_id_label"></div>
                        </td>
                        <td class="col-4">
                            <select name="test_tubes_id" class="form-select" id="test_tubes_id">
                                <option value="">Выберите пробирку</option>
                                @foreach($testtubes as $testtube)
                                    <option value="{{ $testtube->id }}"
                                            @if($element->testTube->id == $testtube->id) selected @endif>{{ $testtube->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback error_label test_tubes_id_label"></div>
                        </td>
                        <td class="col-2">
                            <input type="checkbox" name="hide_in_price"
                                   value="1" {{ $element->hide_in_price ? 'checked' : '' }}>
                        </td>
                        <td class="col-2">
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



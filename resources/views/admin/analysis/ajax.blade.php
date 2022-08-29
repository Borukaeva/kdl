@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-auto">Название</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($elements as $element)
                @include('admin.analysis.ajax', ['element' => $element, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        {{ $elements->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.analysis.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <div class="form-check form-switch">
                        <input class="js-status form-check-input" name="active" type="checkbox" value="1"
                               @if($element->active == 1)
                               checked
                               @endif data-href="{{ route('analysis.status', [$element]) }}"
                               data-csrf-token="{{ csrf_token() }}">
                    </div>
                </li>
                <li class="ml-3">
                    <a href="{{ route('analysis.edit', [$element->id]) }}" title="Редактировать"><i
                            class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('analysis.destroy', [$element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('add')
        <form
            action="@if(isset($element)) {{ route('analysis.update', ['analysi' => $element]) }} @else {{ route('analysis.store') }} @endif"
            method="post">
            @if(isset($element))
                @method('put')
            @endif
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label for="name" class="form-label">Название</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Название"
                           value="@if(isset($element)){{ $element->name }}@endif">
                    @error('name')
                    <div class="invalid-feedback error_label name_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="synonyms" class="form-label">Синонимы</label>
                    <input type="text" name="synonyms" id="synonyms" class="form-control" placeholder="Синонимы"
                           value="@if(isset($element)){{ $element->synonyms }}@endif">
                    @error('synonyms')
                    <div class="invalid-feedback error_label synonyms_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Описание</label>
                    <textarea name="description" id="description" class="form-control"
                              placeholder="Описание">@if(isset($element)){{ $element->description }}@endif</textarea>
                    @error('description')
                    <div class="invalid-feedback error_label description_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="full_description" class="form-label">Полное описание</label>
                    <textarea name="full_description" id="full_description" class="form-control"
                              placeholder="Полное описание">@if(isset($element)){{ $element->full_description }}@endif</textarea>
                    @error('full_description')
                    <div class="invalid-feedback error_label full_description_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="preparation" class="form-label">Подготовка к сдаче анализов</label>
                    <textarea name="preparation" id="preparation" class="form-control"
                              placeholder="Подготовка к сдаче анализов">@if(isset($element)){{ $element->preparation }}@endif</textarea>
                    @error('preparation')
                    <div class="invalid-feedback error_label preparation_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="term" class="form-label">Срок</label>
                    <input type="text" name="term" id="term" class="form-control" placeholder="Срок"
                           value="@if(isset($element)){{ $element->term }}@endif">
                    @error('term')
                    <div class="invalid-feedback error_label term_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="method_id" class="form-label">Метод</label>
                    <select name="method_id" class="form-select" id="method_id">
                        <option value="">Выберите метод</option>
                        @foreach($methods as $method)
                            <option value="{{ $method->id }}"
                                    @if(isset($element) && $element->method_id == $method->id) selected @endif>{{ $method->name }}</option>
                        @endforeach
                    </select>
                    @error('method_id')
                    <div class="invalid-feedback error_label method_id_label d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" name="active" id="active" class="form-check-input" placeholder="Статус"
                       value="1" @if(isset($element) && $element->active) checked @endif>
                <label for="active" class="form-check-label">Статус</label>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">@if(isset($element))Сохранить@else
                    Добавить@endif</button>
        </form>
        @break

        @case('edit')
        <td colspan="3" class="form_row">
            <form action="{{ route('analysis.update', [$element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-auto">
                            <input type="text" name="name" id="name_{{ $element->id }}" class="form-control"
                                   value="{{ $element->name }}">
                            <div class="invalid-feedback error_label name_label"></div>
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



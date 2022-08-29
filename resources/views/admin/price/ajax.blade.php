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
                @include('admin.price.ajax', ['element' => $element, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        {{ $elements->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.price.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="{{ route('price.edit', [$element->id]) }}" title="Редактировать"><i
                            class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('price.destroy', [$element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('add')
        <form
            action="@if(isset($element)) {{ route('price.update', ['price' => $element]) }} @else {{ route('price.store') }} @endif"
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
                    <div class="invalid-feedback error_label name_label"></div>
                </div>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">@if(isset($element))Сохранить@else
                    Добавить@endif</button>
        </form>
        @break

        @case('edit')
        <td colspan="3" class="form_row">
            <form action="{{ route('price.update', [$element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-auto">
                            <input type="text" name="name" id="name_{{ $element->id }}" class="form-control"
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

        @case('test')
        {{ dd($echo) }}
        @break

        @default
    @endswitch
@endif



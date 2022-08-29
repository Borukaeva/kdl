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
                @include('laboratory_assistant.ticket.ajax', ['element' => $element, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        {{ $elements->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
        @break

        @case('show')
        <tr class="js-field field">
            @include('laboratory_assistant.ticket.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">№ {{ $element->id }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="{{ route('ticket.edit', [$element]) }}" title="Редактировать"><i
                            class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('ticket.destroy', [$element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('sub_complex_item')
        <li>
            <input type="checkbox" name="complexes[]" id="item_{{ $complex->id }}" class="js-item"
                   value="{{ $complex->id }}">
            <label for="item_{{ $complex->id }}" class="item">
                {{ $complex->name }}
            </label>
            @if(count($complex->childComplexes))
                <div class="sub js-sub"><i class="bi bi-plus"></i></div>@endif
            @if(count($complex->childComplexes))
                <ul>
                    @foreach($complex->childComplexes as $complex)
                        @include('laboratory_assistant.ticket.ajax', ['complex' => $complex, 'ajax' => 'sub_complex_item'])
                    @endforeach
                </ul>
            @endif
        </li>
        @break

        @case('edit')
        <td colspan="3" class="form_row">
            <form action="{{ route('ticket.update', [$element]) }}" method="post">
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



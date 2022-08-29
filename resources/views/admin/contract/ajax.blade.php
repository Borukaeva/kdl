@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-auto">Название</th>
                <th scope="col" class="col-3">Сумма</th>
                <th scope="col" class="col-1">Прайсы</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            <tr class="js-field_add field_add">
                <td colspan="5">
                    <form action="{{ route('partner.contract.store', [$element]) }}" method="post">
                        @csrf
                        <table>
                            <tr>
                                <td class="col-auto">
                                    <input type="text" name="name" class="form-control" value="">
                                </td>
                                <td class="col-1">
                                    <input type="text" name="sum" class="form-control" value="">
                                </td>
                                <td class="col-3">
                                    <select name="price_id" class="form-select" id="price_id">
                                        <option value="">Выберите прайс</option>
                                        @foreach($prices as $price)
                                            <option value="{{ $price->id }}">{{ $price->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-1">
                                    <input type="hidden" name="partner_id" value="{{ $element->id }}">
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
            @foreach($element->contract as $contract)
                @include('admin.contract.ajax', ['element' => $contract, 'ajax' => 'show'])
            @endforeach
            </tbody>
        </table>
        @break

        @case('show')
        <tr class="js-field field">
            @include('admin.contract.ajax', ['element' => $element, 'ajax' => 'item'])
        </tr>
        @break

        @case('item')
        <td>
            <strong class="text-gray-dark">{{ $element->name }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->sum }}</strong>
        </td>
        <td>
            <strong class="text-gray-dark">{{ $element->price->name }}</strong>
        </td>
        <td>
            <ul class="justify-content-end list-unstyled d-flex">
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('partner.contract.edit', [$element->partner, $element]) }}"
                       class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                </li>
                <li class="ml-3">
                    <a href="javascript:void(0);"
                       data-href="{{ route('partner.contract.destroy', [$element->partner, $element]) }}"
                       data-csrf-token="{{ csrf_token() }}"
                       class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                </li>
            </ul>
        </td>
        @break

        @case('edit')
        <td colspan="5" class="form_row">
            <form action="{{ route('partner.contract.update', [$element->partner, $element]) }}" method="post">
                @method('PATCH')
                @csrf
                <table>
                    <tr>
                        <td class="col-auto">
                            <input type="text" name="name" class="form-control" value="{{ $element->name }}">
                        </td>
                        <td class="col-1">
                            <input type="text" name="sum" class="form-control" value="{{ $element->sum }}">
                        </td>
                        <td class="col-3">
                            <select name="price_id" class="form-select" id="price_id">
                                <option value="">Выберите прайс</option>
                                @foreach($prices as $price)
                                    <option value="{{ $price->id }}" @if($element->price->id == $price->id) selected @endif>{{ $price->name }}</option>
                                @endforeach
                            </select>
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



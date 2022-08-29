@if(isset($ajax))
    @switch($ajax)
        @case('list')
        <div class="container">
            <div class="row">
                <div class="col">
                    Название
                </div>
                <div class="col col-2  d-flex justify-content-end">
                    Активность
                </div>
                <div class="col col-2  d-flex justify-content-end">
                    Действия
                </div>
            </div>
            @include('admin.complex.ajax', ['ajax' => 'add'])
            @foreach($elements as $element)
                @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'show'])
            @endforeach
        </div>
        @break

        @case('add')
        <div class="js-field_add field_add">
            <form action="{{ route('complex.store') }}" method="post">
                <div class="row">
                    @csrf
                    <div class="col">
                        <div class="form-check">
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="col col-2  d-flex justify-content-end">
                        <div class="form-check">
                            <input type="checkbox" name="active" id="active" value="1" class="form-check-input">
                        </div>
                    </div>
                    <input type="hidden" name="parent_id" id="parent_id">
                    <div class="col col-2 action d-flex justify-content-end">
                        <ul class="justify-content-end list-unstyled d-flex">
                            <li class="ml-3">
                                <a href="javascript:void(0);"
                                   class="js-cancel text-danger" title="Отменить"><i class="bi bi-trash"></i></a>
                            </li>
                            <li class="ml-3">
                                <a href="javascript:void(0);" class="js-submit" title="Добавить">
                                    <img src="/storage/admin/img/floppy-disk-svgrepo-com.svg" alt="Сохранить"
                                         style="width:16px;">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        @break

        @case('show')
        <div class="js-field field tree">
            @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'item'])
            <div class="wrapper">
                <div class="js-field_add field_add">
                    <form action="{{ route('complex.store') }}" method="post">
                        <div class="row">
                            @csrf
                            <div class="col">
                                <div class="form-check">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                            <div class="col col-2  d-flex justify-content-end">
                                <div class="form-check">
                                    <input type="checkbox" name="active" id="active" value="1"
                                           class="form-check-input">
                                </div>
                            </div>
                            <input type="hidden" name="parent_id" id="parent_id" value="{{ $element->id }}">
                            <div class="col col-2 action d-flex justify-content-end">
                                <ul class="justify-content-end list-unstyled d-flex">
                                    <li class="ml-3">
                                        <a href="javascript:void(0);"
                                           class="js-cancel text-danger" title="Отменить"><i
                                                class="bi bi-trash"></i></a>
                                    </li>
                                    <li class="ml-3">
                                        <a href="javascript:void(0);" class="js-submit" title="Добавить">
                                            <img src="/storage/admin/img/floppy-disk-svgrepo-com.svg" alt="Сохранить"
                                                 style="width:16px;">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                @if(count($element->childComplexes))
                    @foreach($element->childComplexes as $element)
                        @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'show'])
                    @endforeach
                @endif
            </div>
        </div>
        @break

        @case('item')
        <div class="row">
            <div class="col">
                <strong class="text-gray-dark">{{ $element->name }}</strong>
            </div>
            <div class="col col-2  d-flex justify-content-end">
                <strong class="text-gray-dark">
                    @if($element->active)
                        <i class="bi bi-eye text-success"></i>
                    @else
                        <i class="bi bi-eye-slash text-danger"></i>
                    @endif
                </strong>
            </div>
            <div class="col col-2  d-flex justify-content-end">
                <ul class="justify-content-end list-unstyled d-flex">
                    <li class="ml-3">
                        <a href="javascript:void(0);"
                           data-href="{{ route('complex.edit', [$element]) }}"
                           class="js-edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                    </li>
                    <li class="ml-3">
                        <a href="javascript:void(0);"
                           data-href="{{ route('complex.destroy', [$element]) }}"
                           data-del-text="Уверены, что хотите удалить, все привязанные комплексы удалятся?"
                           data-csrf-token="{{ csrf_token() }}"
                           class="js-del text-danger" title="Удалить"><i class="bi bi-trash"></i></a>
                    </li>
                    <li class="ml-3">
                        <a href="javascript:void(0);"
                           class="js-add_sub text-success" title="Создать"><i class="bi bi-plus-lg"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        @break

        @case('edit')
        <form action="{{ route('complex.update', [$element]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input type="text" name="name" class="form-control"
                               value="{{ $element->name }}">
                    </div>
                </div>
                <div class="col col-2 d-flex justify-content-end">
                    <div class="form-check">
                        <input type="checkbox" name="active" id="active_{{ $element->id }}"
                               class="form-check-input" value="1"
                               @if($element->active)
                               checked
                            @endif
                        >
                    </div>
                </div>
                <input type="hidden" name="parent_id" id="parent_id" value="{{ $element->parent_id }}">
                <div class="col col-2 action d-flex justify-content-end">
                    <ul class="justify-content-end list-unstyled d-flex">
                        <li class="ml-3">
                            <a href="javascript:void(0);"
                               data-href="{{ route('complex.show', [$element]) }}"
                               class="js-cancel text-danger" title="Отменить"><i class="bi bi-trash"></i></a>
                        </li>
                        <li class="ml-3">
                            <a href="javascript:void(0);" class="js-submit" title="Сохранить">
                                <img src="/storage/admin/img/floppy-disk-svgrepo-com.svg" alt="Сохранить"
                                     style="width:16px;">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
        @break

        @case('list_in_analysis')
        <main class="container js-elements_list">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="d-flex text-muted pt-3">
                    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                        <div class="d-flex justify-content-between">
                            <div class="col-auto">
                                <h3 class="pb-2 mb-0">Комплексы</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="js-elements_list-list overflow-auto" data-href="{{ route('complex.ajax') }}">
                    @include('admin.complex.ajax', ['elements' => $elements, 'ajax' => 'read_only_list'])
                </div>
            </div>
        </main>
        @break

        @case('read_only_list')
        <div class="container">
            <div class="row">
                <div class="col-1"></div>
                <div class="col">
                    Название
                </div>
                <div class="col col-2  d-flex justify-content-end">
                    Активность
                </div>
            </div>
            @foreach($elements as $element)
                @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'read_only_show'])
            @endforeach
        </div>
        @break

        @case('read_only_show')
        <div class="js-field field tree">
            @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'read_only_item'])
            <div class="wrapper">
                @if(count($element->childComplexes))
                    @foreach($element->childComplexes as $element)
                        @include('admin.complex.ajax', ['element' => $element, 'ajax' => 'read_only_show'])
                    @endforeach
                @endif
            </div>
        </div>
        @break

        @case('read_only_item')
        <div class="row">
            <div class="col-1">
                <input type="checkbox" name="complex" class="js-complex"
                       @if($analysis->hasComplex($element->id))
                           checked
                       @endif
                       data-href="{{ route('analysis.complex.add', [$analysis, $element]) }}"
                       data-csrf-token="{{ csrf_token() }}">
            </div>
            <div class="col">
                <strong class="text-gray-dark">{{ $element->name }}</strong>
            </div>
            <div class="col col-2  d-flex justify-content-end">
                <strong class="text-gray-dark">
                    @if($element->active)
                        <i class="bi bi-eye text-success"></i>
                    @else
                        <i class="bi bi-eye-slash text-danger"></i>
                    @endif
                </strong>
            </div>
        </div>
        @break

        @default
    @endswitch
@endif

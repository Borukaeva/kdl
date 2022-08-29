@extends('layouts.admin_layout')

@section('content')
    <main class="container js-elements_list">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="d-flex text-muted pt-3">
                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <div class="col-auto">
                            <h3 class="pb-2 mb-0">Биоматериалы</h3>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary js-add" title="Добавить новую пробирку">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="js-elements_list-list overflow-auto" data-href="{{ route('biomaterials.ajax') }}">
                @include('admin.biomaterial.ajax', ['elements' => $elements, 'ajax' => 'list'])
            </div>
        </div>
    </main>
@endsection

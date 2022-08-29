@extends('layouts.admin_layout')

@section('content')
    <main class="container">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="d-flex text-muted pt-3">
                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <div class="col-auto">
                            <h3 class="pb-2 mb-0">Партнёр</h3>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('partner.index') }}" class="btn btn-primary" title="К списку анализов">
                                <i class="bi bi-arrow-left"></i> к списку партнёров
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.partner.ajax', ['ajax' => 'add'])
            @if(isset($element))
                @include('admin.contract.index', ['element' => $element, 'prices' => $prices, 'ajax' => 'list'])
            @endif
        </div>
    </main>
@endsection

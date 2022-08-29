@extends('layouts.laboratory_assistant_layout')

@section('content')
    <main class="container">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="d-flex text-muted pt-3">
                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <div class="col-auto">
                            <h3 class="pb-2 mb-0">Заявка</h3>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('ticket.index') }}" class="btn btn-primary" title="К списку заявок">
                                <i class="bi bi-arrow-left"></i> к списку заявок
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('laboratory_assistant.ticket.add')
        </div>
    </main>
@endsection

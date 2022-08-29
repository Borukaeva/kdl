@if(isset($ajax))
    @switch($ajax)
        @case('index')
        <main class="container js-elements_list">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="d-flex text-muted pt-3">
                    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                        <div class="d-flex justify-content-between">
                            <div class="col-auto">
                                <h3 class="pb-2 mb-0">Биоматериалы анализов</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.analysis_biomaterial.price', ['ajax' => 'filter'])
                <div class="overflow-auto">
                    @include('admin.analysis_biomaterial.price', ['price' => $element, 'analysis_biomaterials' => $analysis_biomaterials, 'ajax' => 'price'])
                </div>
            </div>
        </main>
        @break

        @case('filter')
        <div class="d-flex text-muted pt-3">
            <div class="pb-3 mb-0 small lh-sm w-100">
                <div class="row g-3">
                    <div class="col-6">
                        <input type="text" name="name" id="name" class="form-control js-search-input" placeholder="Название" value="" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        @break

        @case('price')
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="col-6">Анализ (биоматериал/пробирка)</th>
                <th scope="col" class="col-3">Цена наша</th>
                <th scope="col" class="col-3">Цена партнёра</th>
            </tr>
            </thead>
            <tbody class="js-search-container">
            @foreach($analysis_biomaterials as $analysis_biomaterial)
                @include('admin.analysis_biomaterial.price', ['price' => $price, 'analysis_biomaterial' => $analysis_biomaterial, 'ajax' => 'price_show'])
            @endforeach
            </tbody>
        </table>
        @break

        @case('price_show')
        <tr class="field js-search-field">
            @include('admin.analysis_biomaterial.price', ['price' => $price, 'analysis_biomaterial' => $analysis_biomaterial, 'ajax' => 'price_item'])
        </tr>
        @break

        @case('price_item')
        <td colspan="3" class="form_row">
            <form action="{{ route('price.analysis_biomaterial', [$price, $analysis_biomaterial]) }}" method="post" class="js-price_anal_bio">
                @csrf
                <table>
                    <tr>
                        <td class="col-6">
                            <strong class="text-gray-dark">{{ $analysis_biomaterial->analysis->name.' ('.$analysis_biomaterial->biomaterial->name.'/'.$analysis_biomaterial->testTube->name.')' }}</strong>
                        </td>
                        <td class="col-3">
                            <input type="text" name="price1" value="{{ $price->analysisBiomaterial->contains($analysis_biomaterial->id) ? $price->analysisBiomaterialPivot($analysis_biomaterial)->price1 : '' }}" class="js-price1">
                            <div class="invalid-feedback error_label price1_label"></div>
                        </td>
                        <td class="col-3">
                            <input type="text" name="price2" value="{{ $price->analysisBiomaterial->contains($analysis_biomaterial->id) ? $price->analysisBiomaterialPivot($analysis_biomaterial)->price2 : '' }}" class="js-price2">
                            <div class="invalid-feedback error_label price2_label"></div>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        @break

        @default
    @endswitch
@endif

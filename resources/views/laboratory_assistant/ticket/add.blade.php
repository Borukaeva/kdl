<form
    action="@if(isset($element)) {{ route('ticket.update', ['ticket' => $element]) }} @else {{ route('ticket.store') }} @endif"
    method="post"
    class="js-ticket">
    @if(isset($element))
        @method('put')
    @endif
    @csrf
    <div class="row g-3">
        <div class="col-12">
            <h4>Сведения о пациенте
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#foreign_passport_of_rf"
                   role="button" aria-expanded="false" aria-controls="foreign_passport_of_rf">Заграничный
                    паспорт РФ</a>
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#birth_certificate" role="button"
                   aria-expanded="false" aria-controls="birth_certificate">Свидетельство о рождении</a>
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#passport_of_foreign_citizen" role="button"
                   aria-expanded="false" aria-controls="multiCollapseExample2">Паспорт иностранного гражданина</a>
            </h4>
        </div>
        <div class="col-12 collapse multi-collapse" id="foreign_passport_of_rf">
            <div class="row">
                <div class="col-3">
                    <label for="fp_surname_en" class="form-label">Фамилия англ.</label>
                    <input type="text" name="fp_surname_en" id="fp_surname_en" class="form-control"
                           placeholder="Фамилия англ."
                           value="@if(isset($element)){{ $element->patient->fp_surname_en }}@else{{ old("fp_surname_en") }}@endif">
                    @error('fp_surname_en')
                    <div class="invalid-feedback error_label fp_surname_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <label for="fp_name_en" class="form-label">Имя англ.</label>
                    <input type="text" name="fp_name_en" id="fp_name_en" class="form-control" placeholder="Имя англ."
                           value="@if(isset($element)){{ $element->patient->fp_name_en }}@else{{ old("fp_name_en") }}@endif">
                    @error('fp_name_en')
                    <div class="invalid-feedback error_label fp_name_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <label for="fp_number_en" class="form-label">Серия и номер загран. паспорта.</label>
                    <input type="text" name="fp_number_en" id="fp_number_en"
                           class="form-control js-foreign_passport_of_rf"
                           placeholder="Серия и номер загран. паспорта."
                           value="@if(isset($element)){{ $element->patient->fp_number_en }}@else{{ old("fp_number_en") }}@endif">
                    @error('fp_number_en')
                    <div class="invalid-feedback error_label fp_number_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
        </div>
        <div class="col-12 collapse multi-collapse" id="birth_certificate">
            <div class="row">
                <div class="col-3">
                    <label for="bc_number" class="form-label">Серия и номер</label>
                    <input type="text" name="bc_number" id="bc_number" class="form-control js-birth_certificate"
                           placeholder="Серия и номер"
                           value="@if(isset($element)){{ $element->patient->bc_number }}@else{{ old("bc_number") }}@endif">
                    @error('bc_number')
                    <div class="invalid-feedback error_label bc_number_label d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
        </div>
        <div class="col-12 collapse multi-collapse" id="passport_of_foreign_citizen">
            <div class="row">
                <div class="col-3">
                    <label for="pfc_surname_en" class="form-label">Фамилия англ.</label>
                    <input type="text" name="pfc_surname_en" id="pfc_surname_en" class="form-control"
                           placeholder="Фамилия англ."
                           value="@if(isset($element)){{ $element->patient->pfc_surname_en }}@else{{ old("pfc_surname_en") }}@endif">
                    @error('pfc_surname_en')
                    <div class="invalid-feedback error_label pfc_surname_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <label for="pfc_name_en" class="form-label">Имя англ.</label>
                    <input type="text" name="pfc_name_en" id="pfc_name_en" class="form-control" placeholder="Имя англ."
                           value="@if(isset($element)){{ $element->patient->pfc_name_en }}@else{{ old("pfc_name_en") }}@endif">
                    @error('pfc_name_en')
                    <div class="invalid-feedback error_label pfc_name_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <label for="pfc_number_en" class="form-label">Серия и номер загран. паспорта.</label>
                    <input type="text" name="pfc_number_en" id="pfc_number_en"
                           class="form-control js-passport_of_foreign_citizen"
                           placeholder="Серия и номер загран. паспорта."
                           value="@if(isset($element)){{ $element->patient->pfc_number_en }}@else{{ old("pfc_number_en") }}@endif">
                    @error('pfc_number_en')
                    <div class="invalid-feedback error_label pfc_number_en_label d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
        </div>
        <div class="col-3">
            <label for="surname" class="form-label">Фамилия *</label>
            <input type="text" name="surname" id="surname" class="form-control" placeholder="Фамилия"
                   value="@if(isset($element)){{ $element->patient->surname() }}@else{{ old("surname") }}@endif">
            @error('surname')
            <div class="invalid-feedback error_label surname_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3">
            <label for="name" class="form-label">Имя *</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Имя"
                   value="@if(isset($element)){{ $element->patient->name() }}@else{{ old("name") }}@endif">
            @error('name')
            <div class="invalid-feedback error_label name_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <label for="patronymic" class="form-label">Отчество</label>
            <input type="text" name="patronymic" id="patronymic" class="form-control" placeholder="Отчество"
                   value="@if(isset($element)){{ $element->patient->patronymic() }}@else{{ old("patronymic") }}@endif">
            @error('patronymic')
            <div class="invalid-feedback error_label patronymic_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <label for="birthday" class="form-label">Дата рождения</label>
            <input type="text" name="birthday" id="birthday" class="form-control js-datepicker"
                   placeholder="Дата рождения"
                   value="@if(isset($element)){{ $element->patient->birthday }}@else{{ old("birthday") }}@endif">
            @error('birthday')
            <div class="invalid-feedback error_label birthday_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <label for="sex" class="form-label">Пол</label>
            <select name="sex" class="form-select js-sex" id="sex">
                <option value="">-</option>
                <option value="1"
                        @if(isset($element) && $element->patient->sex == 1) selected @endif>Мужской
                </option>
                <option value="2"
                        @if(isset($element) && $element->patient->sex == 2) selected @endif>Женский
                </option>
            </select>
            @error('sex')
            <div class="invalid-feedback error_label sex_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="passport" class="form-label">Серия и номер паспорта</label>
            <input type="text" name="passport" id="passport" class="form-control js-passport"
                   placeholder="1234 567890"
                   value="@if(isset($element)){{ $element->patient->passport }}@else{{ old("passport") }}@endif">
            @error('passport')
            <div class="invalid-feedback error_label passport_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="phone" class="form-label">Номер телефона</label>
            <input type="text" name="phone" id="phone" class="form-control js-phone"
                   placeholder="+7 (123) 456-7890"
                   value="@if(isset($element)){{ $element->patient->phone }}@else{{ old("phone") }}@endif">
            @error('phone')
            <div class="invalid-feedback error_label phone_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="user_id" class="form-label">Лаборант</label>
            <select name="user_id" class="form-select" id="user_id">
                <option value="">-</option>
                @if(count($users))
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                                @if(isset($element) && $element->patient->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('user_id')
            <div class="invalid-feedback error_label user_id_label d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr class="my-4">
    <div class="row g-3">
        <h4>Временные данные о пациенте</h4>
        <div class="col-4">
            <label for="diagnosis" class="form-label">Диагноз</label>
            <input type="text" name="diagnosis" id="diagnosis" class="form-control"
                   placeholder="Диагноз"
                   value="@if(isset($element) && $element->diagnosis){{ $element->diagnosis }}@else{{ old("diagnosis") }}@endif">
            @error('diagnosis')
            <div class="invalid-feedback error_label diagnosis_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="cycle_phase" class="form-label">Фаза цикла</label>
            <select name="cycle_phase" class="form-select js-cycle_phase" id="cycle_phase">
                <option value="">-</option>
                <option value="1" @if(isset($element) && $element->cycle_phase == 1) selected @endif>Фаза 1
                </option>
                <option value="2" @if(isset($element) && $element->cycle_phase == 2) selected @endif>Фаза 2
                </option>
            </select>
            @error('cycle_phase')
            <div class="invalid-feedback error_label cycle_phase_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="pregnancy" class="form-label">Бер. (нед.)</label>
            <input type="text" name="pregnancy" id="pregnancy" class="form-control js-pregnancy"
                   placeholder="Бер. (нед.)"
                   value="@if(isset($element) && $element->pregnancy){{ $element->pregnancy }}@else{{ old("pregnancy") }}@endif">
            @error('pregnancy')
            <div class="invalid-feedback error_label pregnancy_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <label for="height" class="form-label">Рост</label>
            <input type="text" name="height" id="height" class="form-control"
                   placeholder="Рост"
                   value="@if(isset($element)){{ $element->height }}@else{{ old("height") }}@endif">
            @error('height')
            <div class="invalid-feedback error_label height_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <label for="weight" class="form-label">Вес</label>
            <input type="text" name="weight" id="weight" class="form-control"
                   placeholder="Вес"
                   value="@if(isset($element)){{ $element->weight }}@else{{ old("weight") }}@endif">
            @error('weight')
            <div class="invalid-feedback error_label weight_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3">
            <label for="clinic" class="form-label">Клиника</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="clinic[]" id="clinic1" value="1"
                           @if(isset($element) && $element->clinic && in_array(1, explode(',',$element->clinic))) checked @endif>
                    <label class="form-check-label" for="clinic1">Температура</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="clinic[]" id="clinic2" value="2"
                           @if(isset($element) && $element->clinic && in_array(2, explode(',',$element->clinic))) checked @endif>
                    <label class="form-check-label" for="clinic2">Симптомы</label>
                </div>
            </div>
            @error('clinic')
            <div class="invalid-feedback error_label clinic_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3">
            <label for="fence_date" class="form-label">Дата и время забора</label>
            <input type="text" name="fence_date" id="fence_date" class="form-control js-datetimepicker"
                   placeholder="Дата и время забора"
                   value="{{ isset($element) && $element->fence_date ? $element->fence_date : old("fence_date") }}">
            @error('fence_date')
            <div class="invalid-feedback error_label fence_date_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-1 offset-1">
            <div class="form-check">
                <input type="checkbox" name="fence_type[]" id="cervicalis" class="form-check-input"
                       placeholder="Cervicalis"
                       value="1" {{ isset($element) && $element->fence_type && in_array(1, explode(',',$element->fence_type)) ? 'checked' : '' }}>
                <label for="cervicalis" class="form-check-label">Cervicalis</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="fence_type[]" id="vagina" class="form-check-input js-vagina" placeholder="Vagina"
                       value="2" {{ isset($element) && $element->fence_type && in_array(2, explode(',',$element->fence_type)) ? 'checked' : '' }}>
                <label for="vagina" class="form-check-label">Vagina</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="fence_type[]" id="uretra" class="form-check-input" placeholder="Uretra"
                       value="3" {{ isset($element) && $element->fence_type && in_array(3, explode(',',$element->fence_type)) ? 'checked' : '' }}>
                <label for="uretra" class="form-check-label">Uretra</label>
            </div>
        </div>
        <div class="col-3">
            <label for="taking_material_date" class="form-label">Дата и время взятия материала</label>
            <input type="text" name="taking_material_date" id="taking_material_date"
                   class="form-control js-datetimepicker"
                   placeholder="Дата и время забора"
                   value="{{ isset($element) ? $element->taking_material_date : old("taking_material_date") }}">
            @error('taking_material_date')
            <div class="invalid-feedback error_label taking_material_date_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3 offset-6">
            <br>
            <br>
            <div class="form-check">
                <input type="checkbox" name="results_transfer_consent" id="results_transfer_consent"
                       class="form-check-input" placeholder="Статус"
                       value="1" {{ isset($element) && $element->results_transfer_consent ? 'checked' : '' }}>
                <label for="results_transfer_consent" class="form-check-label">Согласен на передачу
                    материалов</label>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="row g-3">
        <h4>Сведения о заказчике</h4>
        <div class="col-4">
            <label for="partner_id" class="form-label">Отделение *</label>
            <select name="partner_id" class="form-select js-partner_id" id="partner_id">
                <option value="">(Не выбрано)</option>
                @if(count($partners))
                    @foreach($partners as $partner)
                        <option value="{{ $partner->id }}"
                                @if(isset($element) && $element->partner_id == $partner->id) selected @endif>{{ $partner->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('partner_id')
            <div class="invalid-feedback error_label partner_id_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="doctor_id" class="form-label">Врач *</label>
            <select name="doctor_id" class="form-select" id="doctor_id">
                <option value="">(Не выбрано)</option>
                @if(count($doctors))
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                                @if(isset($element) && $element->doctor_id == $doctor->id) selected @endif>{{ $doctor->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('doctor_id')
            <div class="invalid-feedback error_label doctor_id_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-4">
            <label for="kdl1" class="form-label">№ заявки (KDL) *</label>
            <input type="text" name="kdl1" id="kdl1" class="form-control"
                   placeholder="№ заявки (KDL) *"
                   value="@if(isset($element)){{ $element->kdl1 }}@else{{ old("kdl1") }}@endif">
            @error('kdl1')
            <div class="invalid-feedback error_label kdl1_label d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3">
            <label for="discount_cart" class="form-label">Номер скидочной карты</label>
            <input type="text" name="discount_cart" id="discount_cart" class="form-control js-discount_card"
                   placeholder="Скидка" data-url="{{ route('discount_card.percent') }}"
                   data-csrf-token="{{ csrf_token() }}"
                   value="@if(isset($element)){{ $element->discount_cart }}@else{{ old("discount_cart") }}@endif">
            @error('discount_cart')
            <div class="invalid-feedback error_label discount_cart_label d-block">{{ $message }}</div>
            @enderror
            <input type="hidden" name="discount_cart_id"
                   value="{{ isset($element) ? $element->patient->user->discount_card->id : old("discount_cart") }}">
        </div>
        <div class="col-2">
            <label for="discount_percent_list" class="form-label">Скидка</label>
            <select name="discount_percent_list" class="form-select js-discount_percent_list"
                    id="discount_percent_list">
                <option value="">-</option>
                @foreach($discounts as $discount)
                    <option value="{{ $discount->percent }}"
                            @if(isset($element) && $element->discount_percent_list == $discount->percent) selected @endif>{{ $discount->percent }}
                        %
                    </option>
                @endforeach
            </select>
            <input type="text" class="form-control d-none js-current_discount_percent" value="" readonly>
            @error('discount_percent_list')
            <div class="invalid-feedback error_label discount_percent_list_label d-block">{{ $message }}</div>
            @enderror
            <input type="hidden" name="discount_percent" class="js-discount_percent"
                   value="{{ isset($element) ? $element->discount_percent : old("discount_percent") }}">
        </div>
        <div class="col-7">
            <label for="discount_note" class="form-label">Примечание для скидки</label>
            <input type="text" name="discount_note" id="discount_note" class="form-control"
                   placeholder="Скидка"
                   value="@if(isset($element)){{ $element->discount_note }}@else{{ old("discount_note") }}@endif">
            @error('discount_note')
            <div class="invalid-feedback error_label discount_note_label d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr class="my-4">
    <div class="ordering_research">
        <div class="row g-3">
            <h2>Заказ исследований</h2>
            <div class="col-4">
                <h5>Комплексы</h5>
                <div class="complex_list js-complex_list" data-url="{{ route('ticket.parameters') }}">
                    <ul>
                        @if(count($complexes))
                            @foreach($complexes as $complex)
                                @include('laboratory_assistant.ticket.ajax', ['complex' => $complex, 'ajax' => 'sub_complex_item'])
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <h5>Введите название/код исследования</h5>
                <div class="params_list js-params_list">
                    <input type="text" class="form-control js-search-input" value="">
                    <ul class="js-search-container">
                    </ul>
                </div>
            </div>
            <div class="col-4">
                <h5>Заказанные исследования</h5>
                <div class="selected_params_list js-selected_params_list">
                    <div class="input-group has-validation">
                        <span class="input-group-text">
                            <input type="checkbox" class="js-selected_params_list_all">
                        </span>
                        <input type="text" class="form-control js-barcode_input" placeholder="штрихкод">
                    </div>
                    <ul>
                        @if(isset($element) && count($element->results()))
                            @foreach($element->results() as $result)
                                @php
                                    $biomaterial = $result->first()->get('result');
                                @endphp
                                <li data-id="{{ $biomaterial->analysisBiomaterial->id }}"
                                    data-name="{{ $biomaterial->analysisBiomaterial->biomaterial->name }}"
                                    data-price1="{{ $biomaterial->price }}"
                                    class="selected_bio_item_wrapper js-selected_bio_item_wrapper">
                                    <input type="checkbox" name="selected_bio[]"
                                           class="d-none js-selected_bio_item"
                                           value="{{ $biomaterial->analysisBiomaterial->id }}" checked>
                                    <input type="checkbox" name="selected_bio_barcode[]"
                                           class="d-none js-selected_bio_item_barcode"
                                           value="{{ $biomaterial->barcode ? $biomaterial->barcode : 1 }}" checked>
                                    <div class="selected_bio_item_title">
                                        <input type="checkbox" name="selected_bio_barcode_checkbox[]"
                                               id="selected_bio_barcode_{{ $biomaterial->id }}"
                                               class="js-selected_bio_item_barcode_checkbox"
                                               value="1">
                                        <label for="selected_bio_barcode_{{ $biomaterial->id }}"
                                               class="selected_bio_item_label">
                                            {{ $biomaterial->analysisBiomaterial->biomaterial->name }}
                                        </label>
                                    </div>
                                    <div
                                        class="{{ $biomaterial->barcode != '' ? '' : 'd-none' }} selected_bio_item_barcode_input js-selected_bio_item_barcode_input">{{ $biomaterial->barcode }}</div>
                                    <div class="price_field">Цена: <span
                                            class="price js-price">{{ $biomaterial->price }}</span> руб.
                                    </div>
                                    @if(count($result))
                                        <span class="params_title">Параметры:</span>
                                        <ul class="params_list">
                                            @foreach($result as $params)
                                                <li>
                                                    {{ $params->get('result')->analysisParameter->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="delete js-delete"><i class="bi bi-trash"></i></div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="row g-3">
        <div class="col-6">
            <button class="btn btn-primary btn-lg" type="submit">@if(isset($element))
                    Сохранить
                @else
                    Добавить
                @endif</button>
        </div>
        <div class="col-6">
            <div class="total fr">
                Выбрано исследований: <span
                    class="total_count js-total_count">{{ isset($element) ? count($element->results()) : '-' }}</span><br>
                Итого: <span class="total_price js-total_price">0</span> руб.
            </div>
        </div>
    </div>
</form>

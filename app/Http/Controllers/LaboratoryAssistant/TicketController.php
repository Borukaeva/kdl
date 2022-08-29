<?php

namespace App\Http\Controllers\LaboratoryAssistant;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaboratoryAssistant\TicketRequest;
use App\Models\AnalysisBiomaterial;
use App\Models\Complex;
use App\Models\Contract;
use App\Models\Discount;
use App\Models\DiscountCard;
use App\Models\Partner;
use App\Models\Patient;
use App\Models\Result;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $elements = Ticket::query()->orderByDesc('id')->paginate(50)->withPath(route('ticket.index'));
        return response()->view('laboratory_assistant.ticket.index', ['elements' => $elements]);
    }

    public function listAjax()
    {
        $elements = Ticket::query()->orderByDesc('id')->paginate(50)->withPath(route('ticket.index'));
        return response()->view('laboratory_assistant.ticket.ajax', ['elements' => $elements, 'ajax' => 'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $users = User::query()->where('type', 5)->orderByDesc('id')->get();
        $partners = Partner::query()->orderByDesc('id')->get();
        $doctors = User::query()->where('type', 6)->orderByDesc('id')->get();
        $complexes = Complex::query()->where('parent_id', null)->orderByDesc('id')->get();
        $discounts = Discount::query()->orderBy('percent')->get();
        return response()->view('laboratory_assistant.ticket.card', ['users' => $users,
            'partners' => $partners,
            'doctors' => $doctors,
            'complexes' => $complexes,
            'discounts' => $discounts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketRequest $request
     */
    public function store(TicketRequest $request)
    {
//        dd($request);
        $patient = new Patient;
        $patient->user_id = $request->input("user_id") ? $request->input("user_id") : 1;
        $patient->fio = $request->input("surname") . ' ' . $request->input("name") . ($request->input("patronymic") ? ' ' . $request->input("patronymic") : '');
        $patient->passport = $request->input("passport");
        $patient->phone = $request->input("phone") ? preg_replace('/[^0-9]/', '', $request->input("phone")) : 0;
        $patient->birthday = $request->input("birthday");
        $patient->sex = $request->input("sex");
        $patient->fp_surname_en = $request->input("fp_surname_en");
        $patient->fp_name_en = $request->input("fp_name_en");
        $patient->fp_number_en = $request->input("fp_number_en");
        $patient->bc_number = $request->input("bc_number");
        $patient->pfc_surname_en = $request->input("pfc_surname_en");
        $patient->pfc_name_en = $request->input("pfc_name_en");
        $patient->pfc_number_en = $request->input("pfc_number_en");
        $patient->save();

        $ticket = new Ticket;
        $ticket->patient_id = $patient->id;
        $ticket->diagnosis = $request->input("diagnosis");
        $ticket->cycle_phase = $request->input("cycle_phase");
        $ticket->pregnancy = $request->input("pregnancy");
        $ticket->height = $request->input("height");
        $ticket->weight = $request->input("weight");
        $ticket->clinic = $request->input("clinic") != '' && count($request->input("clinic")) ? implode(',', $request->input("clinic")) : '';
        $ticket->fence_date = $request->input("fence_date");
        $ticket->fence_type = $request->input("fence_type") != '' && count($request->input("fence_type")) ? implode(',', $request->input("fence_type")) : '';
        $ticket->taking_material_date = $request->input("taking_material_date");
        $ticket->results_transfer_consent = $request->input("results_transfer_consent") ? $request->input("results_transfer_consent") : 0;
        $ticket->partner_id = $request->input("partner_id") ? $request->input("partner_id") : 1;
        $ticket->doctor_id = $request->input("doctor_id") ? $request->input("doctor_id") : 1;
        $ticket->kdl1 = $request->input("kdl1");
        $ticket->discount_cart = $request->input("discount_cart");
        $discount_card = DiscountCard::where('code', $ticket->discount_cart)->first();
        $ticket->discount_percent = $request->input("discount_percent");
        $ticket->discount_note = $request->input("discount_note");
        $ticket->save();

        if (is_array($request->input('selected_bio')) && count($request->input('selected_bio')) > 0) {
            foreach ($request->input('selected_bio') as $key => $selected_bio) {
                $barcode = '';
                if (is_array($request->input('selected_bio_barcode')) && count($request->input('selected_bio')) > 0 && isset($request->input('selected_bio_barcode')[$key]) && $request->input('selected_bio_barcode')[$key] != '1')
                    $barcode = $request->input('selected_bio_barcode')[$key];
                $analysis_biomaterials = AnalysisBiomaterial::where('id', $selected_bio)->first();
                $contracts = Contract::where('partner_id', $request->input("partner_id"))->first();
                $price1 = $contracts->price->analysisBiomaterialPivot($analysis_biomaterials)->price1;
                if ($discount_card && $price1) $discount_card->increasing_amount($price1);
                foreach ($analysis_biomaterials->analysis->parameters as $parameter) {
                    $result = new Result;
                    $result->analysis_id = $analysis_biomaterials->analysis->id;
                    $result->analysis_biomaterial_id = $analysis_biomaterials->id;
                    $result->analysis_parameter_id = $parameter->id;
                    $result->status = 1;
                    $result->result = '';
                    $result->laborant_id = 1;
                    $result->date_result = $request->input("birthday");
                    $result->ticket_id = $ticket->id;
                    $result->price = $price1 ? $price1 : 0;
                    $result->barcode = $barcode;
                    $result->save();
                }
            }
        }

        $users = User::query()->where('type', 5)->orderByDesc('id')->get();
        $partners = Partner::query()->orderByDesc('id')->get();
        $doctors = User::query()->where('type', 6)->orderByDesc('id')->get();
        $complexes = Complex::query()->where('parent_id', null)->orderByDesc('id')->get();
        $discounts = Discount::query()->orderBy('percent')->get();
        return response()->view('laboratory_assistant.ticket.card', [
            'element' => $ticket,
            'users' => $users,
            'partners' => $partners,
            'doctors' => $doctors,
            'complexes' => $complexes,
            'discounts' => $discounts
        ]);
    }

    /**
     * Get AnalysisParams of Complexes
     *
     * @param Request $request
     */
    public function parameters(Request $request)
    {
        $complexes_ids = $request->input('complexes_ids');
        $partner_id = $request->input('partner');
        if (trim($complexes_ids) == '') return json_encode(0);
        if (trim($partner_id) == '') return json_encode(0);
        $complexes_ids = explode(',', $complexes_ids);
        $complexes = Complex::query()->whereIn('id', $complexes_ids)->get();
        if (count($complexes) == 0) return json_encode(0);
        $analyzes = [];
        foreach ($complexes as $complex)
            foreach ($complex->analysisList as $analysis)
                if (!in_array($analysis->id, $analyzes)) $analyzes[] = $analysis->id;

        $analysis_biomaterials = AnalysisBiomaterial::whereIn('analysis_id', $analyzes)->orderByDesc('id')->get();
        $contracts = Contract::where('partner_id', $partner_id)->first();
        if (!$contracts) return json_encode(0);
        $contract_price = $contracts->price;
        $collection = collect();
        foreach ($analysis_biomaterials as $analysis_biomaterial) {
            foreach ($analysis_biomaterial->price as $price) {
                if ($contract_price->id == $price->id) {
                    $collection->push([
                        'id' => $analysis_biomaterial->id,
                        'name' => $analysis_biomaterial->biomaterial->name,
                        'price1' => $price->pivot->price1,
                        'price2' => $price->pivot->price2,
                    ]);
                }
            }
        }

        return $collection->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     */
    public function edit(Ticket $ticket)
    {
        $users = User::query()->where('type', 5)->orderByDesc('id')->get();
        $partners = Partner::query()->orderByDesc('id')->get();
        $doctors = User::query()->where('type', 6)->orderByDesc('id')->get();
        $complexes = Complex::query()->where('parent_id', null)->orderByDesc('id')->get();
        $discounts = Discount::query()->orderBy('percent')->get();
        return response()->view('laboratory_assistant.ticket.card', [
            'element' => $ticket,
            'users' => $users,
            'partners' => $partners,
            'doctors' => $doctors,
            'complexes' => $complexes,
            'discounts' => $discounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketRequest $request
     * @param Ticket $ticket
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
//        dd($request);
        $patient = $ticket->patient;
        $patient->fio = $request->input("surname") . ' ' . $request->input("name") . ($request->input("patronymic") ? ' ' . $request->input("patronymic") : '');
        $patient->passport = $request->input("passport");
        $patient->phone = preg_replace('/[^0-9]/', '', $request->input("phone"));
        $patient->birthday = $request->input("birthday");
        $patient->sex = $request->input("sex");
        $patient->fp_surname_en = $request->input("fp_surname_en");
        $patient->fp_name_en = $request->input("fp_name_en");
        $patient->fp_number_en = $request->input("fp_number_en");
        $patient->bc_number = $request->input("bc_number");
        $patient->pfc_surname_en = $request->input("pfc_surname_en");
        $patient->pfc_name_en = $request->input("pfc_name_en");
        $patient->pfc_number_en = $request->input("pfc_number_en");
        $patient->save();

        $ticket->diagnosis = $request->input("diagnosis");
        $ticket->cycle_phase = $request->input("cycle_phase");
        $ticket->pregnancy = $request->input("pregnancy");
        $ticket->height = $request->input("height");
        $ticket->weight = $request->input("weight");
        $ticket->clinic = $request->input("clinic") != '' && count($request->input("clinic")) ? implode(',', $request->input("clinic")) : '';
        $ticket->fence_date = $request->input("fence_date");
        $ticket->fence_type = $request->input("fence_type") != '' && count($request->input("fence_type")) ? implode(',', $request->input("fence_type")) : '';
        $ticket->taking_material_date = $request->input("taking_material_date");
        $ticket->results_transfer_consent = $request->input("results_transfer_consent") ? $request->input("results_transfer_consent") : 0;
        $ticket->partner_id = $request->input("partner_id") ? $request->input("partner_id") : 1;
        $ticket->doctor_id = $request->input("doctor_id") ? $request->input("doctor_id") : 1;
        $ticket->kdl1 = $request->input("kdl1");
        $ticket->discount_cart = $request->input("discount_cart");
        $discount_card = DiscountCard::where('code', $ticket->discount_cart)->first();
        $ticket->discount_percent = $request->input("discount_percent");
        $ticket->discount_note = $request->input("discount_note");
        $ticket->save();


        $r_collection = collect([]);
        if (count($ticket->result)) {
            foreach ($ticket->result as $result) {
                $id = collect([$result->analysis_id, $result->analysis_biomaterial_id, $result->analysis_parameter_id])->join('.');
                $r_collection->put($id, $result);
            }
        }

        if (is_array($request->input("selected_bio")) && count($request->input("selected_bio"))) {
            foreach ($request->input("selected_bio") as $key => $selected_bio) {
                $barcode = '';
                if (is_array($request->input('selected_bio_barcode')) && count($request->input('selected_bio')) > 0 && isset($request->input('selected_bio_barcode')[$key]) && $request->input('selected_bio_barcode')[$key] != '1')
                    $barcode = $request->input('selected_bio_barcode')[$key];
                $analysis_biomaterials = AnalysisBiomaterial::query()->where('id', $selected_bio)->first();
                $contracts = Contract::where('partner_id', $request->input("partner_id"))->first();
                $price1 = $contracts->price->analysisBiomaterialPivot($analysis_biomaterials)->price1;
                $next_bio = true;
                foreach ($analysis_biomaterials->analysis->parameters as $parameter) {
                    $id = collect([$analysis_biomaterials->analysis->id, $analysis_biomaterials->id, $parameter->id])->join('.');
                    if ($r_collection->has($id)) {
                        $result = $r_collection->get($id);
                        $result->barcode = $barcode != '' ? $barcode : $result->barcode;
                        $result->save();
                        $r_collection->forget($id);
                    } else {
                        $result = new Result;
                        $result->analysis_id = $analysis_biomaterials->analysis->id;
                        $result->analysis_biomaterial_id = $analysis_biomaterials->id;
                        $result->analysis_parameter_id = $parameter->id;
                        $result->status = 1;
                        $result->result = '';
                        $result->laborant_id = 1;
                        $result->date_result = $request->input("birthday");
                        $result->ticket_id = $ticket->id;
                        $result->price = $price1 ? $price1 : 0;
                        $result->barcode = $barcode;
                        $result->save();
                        if ($next_bio && $discount_card && $price1) {
                            $next_bio = false;
                            $discount_card->increasing_amount($price1);
                        }
                    }
                }
            }
        }
        $remaining_result = $r_collection->values();
        $analysis_id = $analysis_biomaterial_id = 0;
        foreach ($remaining_result as $res) {
            if ($res->analysis_id != $analysis_id && $res->analysis_biomaterial_id != $analysis_biomaterial_id && $discount_card) {
                dump($res->price);
                $analysis_id = $res->analysis_id;
                $analysis_biomaterial_id = $res->analysis_biomaterial_id;
                $discount_card->decreasing_amount($res->price);
            }
            $res->delete();
        }
        $ticket->load('result');

        $users = User::query()->where('type', 5)->orderByDesc('id')->get();
        $partners = Partner::query()->orderByDesc('id')->get();
        $doctors = User::query()->where('type', 6)->orderByDesc('id')->get();
        $complexes = Complex::query()->where('parent_id', null)->orderByDesc('id')->get();
        $discounts = Discount::query()->orderBy('percent')->get();
        return response()->view('laboratory_assistant.ticket.card', [
            'element' => $ticket,
            'users' => $users,
            'partners' => $partners,
            'doctors' => $doctors,
            'complexes' => $complexes,
            'discounts' => $discounts
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->result()->delete();
        $ticket->delete();
    }
}

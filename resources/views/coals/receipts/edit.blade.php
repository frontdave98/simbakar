@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF] overflow-auto hide-scrollbar">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Ubah Penerimaan Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.unloadings.index') }}" class="cursor-pointer">Penerimaan Batu Bara</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Data Analisa Kualitas</div>

                 <div class="p-4 bg-white rounded-lg w-full">
                    <form action="{{route('coals.receipts.update-tug',['id' => $receipt->id])}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="lg:flex lg:gap-3">
                            <div class="w-full">
                                <label for="ds" class="font-bold text-[#232D42] text-[16px]">DS</label>
                                    <div class="relative">
                                        <input type="number" name="ds" value="{{$receipt->ds ?? 0}}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bl" class="font-bold text-[#232D42] text-[16px]">BL</label>
                                    <div class="relative">
                                        <input type="number" name="ds" value="{{ $receipt->bl ??  0 }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">   
                                        @error('bl')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bw" class="font-bold text-[#232D42] text-[16px]">BW</label>
                                    <div class="relative">
                                        <input type="number" name="bw" value="0" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bw')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex lg:gap-3 px-4">
                            <div class="w-full">
                                <label for="tug" class="font-bold text-[#232D42] text-[16px]">Yang diterima tug 3</label>
                                    <div class="relative">
                                        <input type="number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="tug_3_accept" value="{{$receipt->tug_3_accept}}">
                                        @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="kind_contract" class="font-bold text-[#232D42] text-[16px]">Jenis Kontrak</label>
                                    <div class="relative">
                                        <select name="kind_contract" id="kind_contract" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3">
                                            <option selected disabled>Pilih Jenis Kontrak</option>
                                            @if ($receipt->contract)
                                                <option {{$receipt->contract->kind_contract == 'FOB' ? 'selected' : ''}}>FOB</option>
                                                <option {{$receipt->contract->kind_contract == 'CIF' ? 'selected' :''}}>CIF</option>
                                            @else    
                                                <option>FOB</option>
                                                <option>CIF</option>
                                            @endif
                                            
                                        </select>
                                        <small>Jenis kontrak akan terisi ,kalau nomor kontrak sudah di pilih    </small>
                                        @error('kind_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 mt-5">
                                <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Tambahan Detail TUG 3</div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="tug_number" class="font-bold text-[#232D42] text-[16px]">No TUG 3</label>
                                        <div class="relative">
                                            <input type="text" name="tug_number" value="{{ $receipt->tug_number }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <label class="inline-flex items-center ps-1 -mt-3">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="check_tug">
                                                <span class="ml-2 text-gray-700 text-sm">Update No TUG 3 berdasarkan tanggal penerimaan</span>
                                            </label>
                                            @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="receipt_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Terima</label>
                                        <div class="relative">
                                            <input required type="date" name="receipt_date" value="{{ $receipt->receipt_date ?? null }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('receipt')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3 mt-3">
                                    <div class="w-full">
                                        <label for="form_part_number" class="font-bold text-[#232D42] text-[16px]">No Form Part</label>
                                        <div class="relative">
                                            <select name="form_part_number" id="form_part_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih No Form Part</option>
                                                <option {{$receipt->form_part_number == '18.01.0009' ? 'selected' : ''}}>18.01.0009</option>
                                                <option {{$receipt->form_part_number == '18.01.0008' ? 'selected' : ''}}>18.01.0008</option>
                                            </select>
                                            @error('form_part_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="unit" class="font-bold text-[#232D42] text-[16px]">Satuan</label>
                                        <div class="relative">
                                            <input type="text" name="unit" value="{{ $receipt->unit }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('unit')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="user_inspection" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                        <div class="relative">
                                            <select name="user_inspection" id="user_inspection" class="select-2-tag select-inspection w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Pemeriksa</option>
                                                @foreach ($inspections as $inspection)
                                                    <option {{$receipt->user_inspection == $inspection->name ? 'selected' :''}}>{{$inspection->name}}</option> 
                                                @endforeach
                                            </select>
                                            @error('user_inspection')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="rob" class="font-bold text-[#232D42] text-[16px]">ROB</label>
                                        <div class="relative">
                                            <input type="text" name="rob" value="{{ $receipt->rob }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('rob')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="head_warehouse" class="font-bold text-[#232D42] text-[16px]">Kepala Gudang</label>
                                        <div class="relative">
                                            <select name="head_warehouse" id="head_warehouse" class="select-2-tag select-warehouse w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Kepala Gudang</option>
                                                @foreach ($heads as $head)
                                                <option {{$receipt->head_warehouse == $head->name ? 'selected' :''}}>{{$head->name}}</option> 
                                            @endforeach
                                            </select>
                                            @error('head_warehouse')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah data TUG 3 ( saja )</button>
                                </div>
                            </div>
                            
                        </form>
                        <div class="bg-white rounded-lg p-6 mt-5">
                            <form action="{{route('coals.receipts.update-detail',['id' => $receipt->id])}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Tambahan Detail TUG 3</div>
                                <div class="w-full">
                                    <label for="load_company_id" class="font-bold text-[#232D42] text-[16px]">Nama PBM</label>
                                    <div class="relative">
                                        <select name="load_company_id" id="load_company_id" class="w-full lg:w-1/2 lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Nama PBM</option>
                                            @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{$receipt->load_company_id == $company->id ? 'selected' :''}}>{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('load_company_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">No BPB</label>
                                    <div class="relative">
                                        <input type="text" name="bpb_number" value="{{ $receipt->bpb_number }}" class="w-full lg:w-1/2 lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bpb_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="contract_id" class="font-bold text-[#232D42] text-[16px]">Nomor Kontrak</label>
                                    <div class="relative">
                                        <select name="contract_id" id="contract_id" class="w-full lg:w-1/2 lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Nomor Kontrak</option>
                                            @foreach ($contracts as $contract)
                                            <option value="{{ $contract->id }}" {{$receipt->contract_id == $contract->id ? 'selected' :''}}>{{ $contract->contract_number }} - {{$contract->spesification->identification_number ?? '[ Identifikasi Kosong ]'}} - {{$contract->kind_contract}}</option>
                                            @endforeach
                                        </select>
                                        @error('contract_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="origin_harbor_id" class="font-bold text-[#232D42] text-[16px]">Pelabuhan Asal</label>
                                        <div class="relative">
                                            <select name="origin_harbor_id" id="origin_harbor_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Pelabuhan</option>
                                                @foreach ($harbors as $harbor)
                                                <option value="{{ $harbor->id }}" {{$receipt->origin_harbor_id == $harbor->id ? 'selected' :''}}>{{ $harbor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('origin_harbor_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="destination_harbor_id" class="font-bold text-[#232D42] text-[16px]">Pelabuhan Tujuan</label>
                                        <div class="relative">
                                            <select name="destination_harbor_id" id="destination_harbor_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Pelabuhan</option>
                                                @foreach ($harbors as $harbor)
                                                <option value="{{ $harbor->id }}" {{$receipt->destination_harbor_id == $harbor->id ? 'selected' :''}}>{{ $harbor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('destination_harbor_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="dock_id" class="font-bold text-[#232D42] text-[16px]">Dermaga</label>
                                        <div class="relative">
                                            <select name="dock_id" id="dock_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Dermaga</option>
                                                @foreach ($docks as $dock)
                                                <option value="{{ $dock->id }}" {{$receipt->dock_id == $dock->id ? 'selected' :''}}>{{ $dock->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dock_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="agent_ship_id" class="font-bold text-[#232D42] text-[16px]">Agent Kapal</label>
                                        <div class="relative">
                                            <select name="agent_ship_id" id="agent_ship_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Agen Kapal</option>
                                                @foreach ($agents as $agent)
                                                <option value="{{ $agent->id }}" {{$receipt->agent_ship_id == $agent->id ? 'selected' :''}}>{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_ship_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="ship_id" class="font-bold text-[#232D42] text-[16px]">Kapal</label>
                                        <div class="relative">
                                            <select name="ship_id" id="ship_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Kapal</option>
                                                @foreach ($ships as $dock)
                                                <option value="{{ $dock->id }}" {{$receipt->ship_id == $dock->id ? 'selected' :''}}>{{ $dock->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('ship_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="captain" class="font-bold text-[#232D42] text-[16px]">Nama Captain</label>
                                        <div class="relative">
                                            <input type="text" name="captain" value="{{ $receipt->captain }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('captain')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="transporter_id" class="font-bold text-[#232D42] text-[16px]">Transportir</label>
                                    <div class="relative">
                                        <select name="transporter_id" id="transporter_id" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Transportir</option>
                                            @foreach ($transporters as $transporter)
                                            <option value="{{ $transporter->id }}" {{$receipt->transporter_id == $transporter->id ? 'selected' :''}}>{{ $transporter->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('transporter_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="analysis_loading_id" class="font-bold text-[#232D42] text-[16px]">Analisa Loading</label>
                                    <div class="relative">
                                        <select name="analysis_loading_id" id="analysis_loading_id" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Analisa Loading</option>
                                            @foreach ($loadings as $loading)
                                            <option value="{{ $loading->id }}" {{$receipt->analysis_loading_id == $loading->id ? 'selected' :''}}>{{ $loading->analysis_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('analysis_loading_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="analysis_unloading_id" class="font-bold text-[#232D42] text-[16px]">Analisa Unloading</label>
                                    <div class="relative">
                                        <select name="analysis_unloading_id" id="analysis_unloading_id" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Analisa Unloading</option>
                                            @foreach ($unloadings as $unloading)
                                            <option value="{{ $unloading->id }}" {{$receipt->analysis_unloading_id == $unloading->id ? 'selected' :''}}>{{ $unloading->analysis_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('analysis_unloading_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="analysis_labor_id" class="font-bold text-[#232D42] text-[16px]">Analisa Labor</label>
                                    <div class="relative">
                                        <select name="analysis_labor_id" id="analysis_labor_id" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Analisa Labor</option>
                                            @foreach ($labors as $labor)
                                            <option value="{{ $labor->id }}" {{$receipt->analysis_labor_id == $labor->id ? 'selected' :''}}>{{ $labor->analysis_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('analysis_labor_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="loading_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Loading</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="loading_date" value="{{ $receipt->loading_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('loading_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="arrived_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Tiba</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="arrived_date" value="{{ $receipt->arrived_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('arrived_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="dock_ship_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Sandar</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="dock_ship_date" value="{{ $receipt->dock_ship_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('dock_ship_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="unloading_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pembongkaran</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="unloading_date" value="{{ $receipt->unloading_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('unloading_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="end_date" value="{{ $receipt->end_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('end_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="departure_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Berangkat</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="departure_date" value="{{ $receipt->departure_date }}" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('departure_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="note" class="font-bold text-[#232D42] text-[16px]">Catatan</label>
                                        <div class="relative">
                                            <textarea name="note" id="" cols="30" rows="3" class="w-full lg:w-46 border rounded-md mt-3 mb-5 px-3">
                                                {{$receipt->note}}
                                            </textarea>
                                            @error('note')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>  
                                    <div class="w-full">
                                        <label for="exchange_rate" class="font-bold text-[#232D42] text-[16px]">Kurs BI</label>
                                        <div class="relative">
                                            <input type="number" name="exchange_rate" value="{{ $receipt->exchange_rate }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('exchange_rate')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH SU 1 Awal</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_su1_start }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH SU 1 Akhir</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_su1_end }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH SU 2 Awal</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_su2_start }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH SU 2 Akhir</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_su2_end }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH Conveyor Awal</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_conveyor_start }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="kwh_su1_start" class="font-bold text-[#232D42] text-[16px]">KWH Conveyor Akhir</label>
                                        <div class="relative">
                                            <input type="number" name="kwh_su1_start" value="{{ $receipt->kwh_conveyor_end }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('kwh_su1_start')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{route('coals.receipts.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                                    <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                        
                 
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

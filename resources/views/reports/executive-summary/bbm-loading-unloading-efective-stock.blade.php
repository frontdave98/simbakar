@extends('layouts.app')
@php
    function formatNumber($val)
    {
        return number_format($val, 0);
    }
@endphp
@section('content')
    <div x-data="{ sidebar: true }" class="w-screen min-h-screen flex bg-[#E9ECEF]">
        @include('components.sidebar')
        <div :class="sidebar ? 'w-10/12' : 'w-full'">
            @include('components.header')
            <div class="w-full py-10 px-8">
                <div class="flex items-end justify-between mb-2">
                    <div>
                        <div class="text-[#135F9C] text-[40px] font-bold">
                            Realisasi Penerimaan, Pemakaian dan Persediaan Efektif Batubara
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center mb-6">
                    <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                        @csrf

                        <div class="flex items-center gap-4">
                            <label for="day" class="flex items-center gap-2">
                                <input id="day" @if ((isset($_GET['type']) && $_GET['type'] == 'day') || !isset($_GET['type'])) checked @endif name="type"
                                    type="radio" value="day">
                                Hari
                            </label>
                            <label for="month" class="flex items-center gap-2">
                                <input id="month" @if (isset($_GET['type']) && $_GET['type'] == 'month') checked @endif name="type"
                                    type="radio" value="month">
                                Bulan
                            </label>
                            <label for="year" class="flex items-center gap-2">
                                <input @if (isset($_GET['type']) && $_GET['type'] == 'year') checked @endif id="year" name="type"
                                    type="radio" value="year">
                                Tahun
                            </label>
                        </div>

                        @if ((isset($_GET['type']) && $_GET['type'] == 'day') || !isset($_GET['type']))
                            <div id="day-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="day-input">Hari:</label>
                                    <input type="date" id="day-input" name="day"
                                        class="border h-[40px] w-full rounded-lg px-3" value="{{ request('day', $day) }}"
                                        min="2000" max="2100">
                                </div>
                            </div>
                        @endif

                        @if (isset($_GET['type']) && $_GET['type'] == 'month')
                            <div id="month-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="month-input">Bulan:</label>
                                    <input type="month" id="month-input" name="month"
                                        class="border h-[40px] w-full rounded-lg px-3"
                                        value="{{ request('month', $month) }}" min="2000" max="2100">
                                </div>
                            </div>
                        @endif

                        @if (isset($_GET['type']) && $_GET['type'] == 'year')
                            <div id="year-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="year-input">Tahun:</label>
                                    <input type="number" id="year-input" name="year"
                                        class="border h-[40px] w-full rounded-lg px-3" value="{{ request('year', $year) }}"
                                        min="2000" max="2100">
                                </div>
                            </div>
                        @endif

                        <div class="w-full flex justify-end gap-2">
                            <button type="button"
                                class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                onclick="handlePrint()">Print</button>
                            <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                type="submit">Filter</button>
                        </div>
                    </form>
                </div>


            </div>
            <div class="px-8 -mt-8 mb-4" id="my-pdf">
                <style>
                    table {
                        width: 100% !important;
                        border-collapse: collapse !important;
                        page-break-inside: auto !important;
                    }

                    tr {
                        page-break-inside: avoid !important;
                        page-break-after: auto !important;
                    }

                    th,
                    td {
                        text-align: center !important;
                        font-size: 12px !important
                    }

                    thead {
                        display: table-header-group !important;
                    }

                    tfoot {
                        display: table-footer-group !important;
                    }
                </style>

                <div class="bg-white display-table rounded-lg p-6">
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">No</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Bulan</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">B/L<br>Kg</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">D/S<br>Kg</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">B/W<br>Kg</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Diterima
                                        [TUG3](Kg)</th>

                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]" colspan="2">DS & BL</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]" colspan="2">BW & DS</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]" colspan="2">BL & BW</th>
                                </tr>
                                <tr>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Selisih</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Persentasi Selisih</th>

                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Selisih</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Persentasi Selisih</th>

                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Selisih</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Persentasi Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($bbm_unloading as $month => $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">{{ $i }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">{{ $month }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bl']) ? formatNumber($item['bl']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['ds']) ? formatNumber($item['ds']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bw']) ? formatNumber($item['bw']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['ds_bl']) ? formatNumber($item['ds_bl']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['ds_bl_percentage']) ? $item['ds_bl_percentage'] : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bw_ds']) ? formatNumber($item['bw_ds']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bw_ds_percentage']) ? $item['bw_ds_percentage'] : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bl_bw']) ? formatNumber($item['bl_bw']) : '-' }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['bl_bw_percentage']) ? $item['bl_bw_percentage'] : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (count($bbm_unloading) > 0)
                                <tfoot>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Rata-rata
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bl')->sum() / collect($bbm_unloading)->pluck('bl')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('ds')->sum() / collect($bbm_unloading)->pluck('ds')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bw')->sum() / collect($bbm_unloading)->pluck('bw')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('ds_bl')->sum() / collect($bbm_unloading)->pluck('ds_bl')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bw_ds')->sum() / collect($bbm_unloading)->pluck('bw_ds')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bl_bw')->sum() / collect($bbm_unloading)->pluck('bl_bw')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Total</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bl')->sum()) }}</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('ds')->sum()) }}</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bw')->sum()) }}</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}</th>

                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('ds_bl')->sum()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bw_ds')->sum()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('bl_bw')->sum()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('[name="type"]').change(function() {
                let val = $(this).val();
                let isChecked = this.checked;
                console.log(isChecked)
                if (isChecked) {
                    let url =
                        `{{ route('reports.executive-summary.bbm-loading-unloading-efective-stock') }}?type=${val}`
                    window.location.href = url;
                }
            })
        })
    </script>
@endsection

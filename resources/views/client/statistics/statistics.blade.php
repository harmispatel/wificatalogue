@extends('client.layouts.client-layout')

@section('title', __('Statistics'))

@section('content')

    <section class="statistics_main">
        <div class="sec_title">
            <h2>{{ __('Statistics')}}</h2>
        </div>
        <div class="chart mb-3">
            <div id="chart"></div>
        </div>
        <div class="most_viewed_sec">
            <div class="sec_title">
                <h3><i class="fa-solid fa-chart-line me-2"></i> {{ __('Most visited')}}</h3>
            </div>
            <div class="row">
                <div class="col-md-6 border-end">
                    <div class="viewed_category">
                        <h4>{{ __('Categories')}}</h4>
                        <ul class="viewed_ul">
                            <li><b>1. </b><p>Σούπες (218)</p></li>
                            <li><b>2. </b><p>Παιδικό (94)</p></li>
                            <li><b>3. </b><p>Ορεκτικά (92)</p></li>
                            <li><b>4. </b><p>Xoρτοφαγικά (59)</p></li>
                            <li><b>5. </b><p>Κρασιά (37)</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="viewed_Items">
                        <h4>{{ __('Items')}}</h4>
                        <ul class="viewed_ul">
                            <li><b>1. </b><p>Ψαρόσουπα (20)</p></li>
                            <li><b>2. </b><p>Demo Product (15)</p></li>
                            <li><b>3. </b><p>Κοτόσουπα (6)</p></li>
                            <li><b>4. </b><p>Μπέργκερ (5)</p></li>
                            <li><b>5. </b><p>Φασολάδα (4)</p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script>
        var options = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'sales',
                data: [30,40,45,50,49,60,70,91,125]
            }],
            xaxis: {
                categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>

@endsection



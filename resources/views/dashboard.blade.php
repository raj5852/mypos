@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Today Summary</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-body bg-dark">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Today Sold
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($todaySummeries['todaySold'], 2) }} </h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body" style="background: #f96197">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Today
                            Sold - Purchase Cost
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($todaySummeries['today_sold_purchase_cost'], 2) }} </h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body" style="background: #48b0f7">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Today
                            Sell Profit</h6>
                        <h4 class="text-white">Tk {{ number_format($todaySummeries['todayPrfit'],2) }} </h4>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Current Month Summary</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-body" style="background: #33cabb">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Sold in
                            {{$currentMonthSummaries['currentMonthDatas']['month']}} {{$currentMonthSummaries['currentMonthDatas']['year']}}
                        </h6>
                        <h4 class="text-white">{{ number_format($currentMonthSummaries['current_month_sold'], 2) }} </h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body" style="background: #8d6658">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Purchased
                            - in   {{$currentMonthSummaries['currentMonthDatas']['month']}} {{$currentMonthSummaries['currentMonthDatas']['year']}}
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($currentMonthSummaries['current_month_purchased'], 2) }}</h4>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card card-body " style="background: #926dde">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Profit  {{$currentMonthSummaries['currentMonthDatas']['month']}} {{$currentMonthSummaries['currentMonthDatas']['year']}}
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($currentMonthSummaries['current_month_profit'], 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Total Summary</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-body bg-dark">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total
                            Sold
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($totalSummeries['total_sold'], 2) }} </h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body" style="background: #15c377">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total
                            Purchased
                        </h6>
                        <h4 class="text-white">Tk {{ number_format($totalSummeries['total_purchasecost'], 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body " style="background: #f96868">
                        <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Profit</h6>
                        <h4 class="text-white">Tk {{ number_format($totalSummeries['total_profit'], 2) }}</h4>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card card-body " style="background: #926dde">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Receivable
                </h6>
                <h4 class="text-white">Tk {{ number_format($totalDatas['total_receivable'], 2) }} </h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body" style="background: #fcc525">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Payable
                </h6>
                <h4 class="text-white">Tk {{ number_format($totalDatas['total_payable'], 2) }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-body " style="background: #15c377">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Banalce
                </h6>
                <h4 class="text-white">Tk {{ number_format($totalDatas['total_balance'], 2) }}</h4>
            </div>
        </div>
    </div>

    {{-- <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-body " style="background: #8d6658">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Stock -
                    Purchase Value
                </h6>
                <h4 class="text-white">Tk 30,000</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body" style="background: #48b0f7">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Stock - Sell
                    Value
                </h6>
                <h4 class="text-white">Tk 30,000</h4>
            </div>
        </div>
    </div> --}}

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card card-body bg-dark">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Customer
                </h6>
                <h4 class="text-white">{{$totalValues['totalCustomers'] }} </h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body" style="background: #8d6658">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Supplier
                </h6>
                <h4 class="text-white">{{$totalValues['totalSuppliers'] }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body " style="background: #f96868">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Invoices
                </h6>
                <h4 class="text-white">{{$totalValues['totalOrders'] }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body " style="background: #926dde">
                <h6 class="text-white text-uppercase" style="font-family: Roboto, Bangla1066, sans-serif;">Total Product
                </h6>
                <h4 class="text-white">{{$totalValues['totalProducts'] }}</h4>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.delete').click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");

            $("#delete-form").attr('action', url);
            $("#confirm-modal").modal('show');
        });
    </script>
@endsection

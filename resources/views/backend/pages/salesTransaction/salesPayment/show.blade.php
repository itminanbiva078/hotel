@extends('backend.layouts.master')
@section('title')
SalesTransaction - {{$title}}
@endsection

@section('styles')
<style>
.bootstrap-switch-large {
    width: 200px;
}
</style>
@endsection

@section('navbar-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                Sales Transaction </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.salePayment.create'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salePayment.create') }}"><i class="fas fa-plus"> Add </i> </a></li>
                    @endif
                    @if(helper::roleAccess('salesTransaction.salePayment.index'))
                    <li class="breadcrumb-item"><a href="{{route('salesTransaction.salePayment.index') }}"><i class="fas fa-list">  List</i> </a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Invoice</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')
<div class="row">
  <div class="col-12">
    <div class="invoice Money-receipt">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="company-logo">
              <img src="https://nextpagetl.com/storage/uploads/nextpage-logo.png" alt="">
            </div>

          </div>
          <div class="col-md-6">
            <div class="company-address">
              <h4> {{helper::companyInfo()->name }} </h4>
              <div class="contact">
                <p> {{helper::companyInfo()->address}} </p>
                <p> Phone :{{helper::companyInfo()->phone}} </p>
                <p> Email : {{helper::companyInfo()->email}} </p>

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="Money-receipt-contant">
              <div class="section-title">
                <h3 style="border-bottom: double;"> Payment Receipt </h3>
              </div>
              <table style="width:100%;">
                <tr> 
                  <td style="width:50%;"> <span> Voucher No:  </span> {{$details->voucher_no ?? ''}} </td>
                  <td style="width:50%;"> <span> Date :  </span>{{helper::get_php_date(date('Y-m-d'))}} </td>
                </tr>
              </table>
              <table style="width:100%;">
                <tr> 
                  <td> <span> Received With Thanks From :  </span> {{$details->customer->name ?? ''}}</td>
                </tr>
              </table>
              <table style="width:100%;">
                <tr> 
                  <td> <span> Amount Of Taka : </span> {{helper::get_bd_amount_in_text($details->credit ?? '')}} </td>
                </tr>
              </table>
              <table style="width:100%;">
                <tr> 
                  <td style="width:33%;"> <span> By  </span> </td>
                  @if($details->payment_type == "Cash")
                  <td style="width:33%;"> Cash </td>
                  @else
                  <td style="width:33%;">  Bank  </td>
                  @endif
                  <td style="width:33%;"> <span> Date </span> : {{helper::get_php_date($details->date ?? '')}} </td>
                </tr>
              </table>
              <table style="width:100%;">
                <tr> 
                  <td style="width:50%;"> <span> for the purpose of </span> : {{$details->sale->voucher_no ?? ''}} </td>
                  <td style="width:50%;"> <span> Contact No:  </span>{{$details->customer->phone }}   </td>
                </tr>
              </table>
              <table style="width:100%;" class="autorization-section">
                <tr> 
                  <td style="width:33%;"> <span> Taka <input type="text" readonly value="{{helper::pricePrint($details->credit ?? '')}}"> </span>  </td>
                  <td style="width:33%; text-align:right; "> <span> <p> Received By </p> </span>  </td>
                  <td style="width:33%; text-align:right; "> <span> <p> authorization signature </p> </span>  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        
        <div class="row no-print">
          <div class="col-12">
          
            <button type="button"  onclick="window.print();" class="btn btn-success float-right"><i class="fas fa-print"></i> Print </button>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

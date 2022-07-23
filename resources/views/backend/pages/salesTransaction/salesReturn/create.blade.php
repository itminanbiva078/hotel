@extends('backend.layouts.master')

@section('title')
SalesTransaction - {{$title}}
@endsection

@section('styles')
<style>
table#show_item tr td {
    padding: 2px !important;
}
</style>
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Sales Transaction</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('salesTransaction.salesReturn.index'))
                    <li class="breadcrumb-item"><a
                            href="{{ route('salesTransaction.salesReturn.index') }}"><i class="fas fa-list"> List</i></a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Sales Return</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    @if(helper::roleAccess('salesTransaction.salesReturn.index'))
                    <a class="btn btn-default" href="{{ route('salesTransaction.salesReturn.index') }}"><i
                            class="fa fa-list"></i>
                        Sales Return List</a>
                    @endif
                    <span id="buttons"></span>

                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body sale-return-create">
                <form class="needs-validation" method="POST"  action="" novalidate>
                    <div class="row">
                        <div class="d-flex gap-20 align-items-center col-md-8 offset-md-2">
                            <form class="" action="simple-results.html">
                                <select name="" id="" class="saleType form-control w-40">
                                    <option value="1"> Pos sell</option>
                                    <option value="2">General sell</option>
                                </select>
                                <div class="input-group w-100">
                                    <input type="search" id="search" class="form-control form-control-lg" placeholder="Type Invoice ID">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <hr>
                    </div>

                </form>
               
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form class="needs-validation" method="POST"  action="{{ route('salesTransaction.salesReturn.store') }}" novalidate>

                    @csrf
                <div class="row">
                    <br>
                    <div class="loadSalesInvoice"></div>
                    <input type="hidden" name="salesType" value="" class="salesType">
                    <button class="btn btn-info sbtn" style="display: none!important" disabled type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#search" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('salesTransaction.salesReturn.autocomplete')}}",
            type: 'get',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term,
               salesType: $('.saleType').val(),
            },
            success: function( data ) {
               response(data.data);
            }
          });
        },
        select: function (event, ui) {
         
           $('#search').val(ui.item.label); // display the selected text
           $('#employeeid').val(ui.item.value); // save selected id to input

           $.ajax({
            url:"{{route('salesTransaction.sales.details')}}",
            type: 'get',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               sale_id: ui.item.value,
               saleType: $('.saleType').val(),
            },
            success: function(data) {
              $('.loadSalesInvoice').html(data.html);
              $('.salesType').val($('.saleType').val());
            }
          });
           return false;
        }
      });

    });
    </script>


@endsection




@extends('backend.layouts.master')
@section('title')
Settings - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">  Settings </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    @if(helper::roleAccess('settings.generalSetup.index'))
                    <li class="breadcrumb-item"><a href="{{route('settings.generalSetup.index')}}">General Setup List</a></li>
                    @endif
                    <li class="breadcrumb-item active"><span>Edit General Setup</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">General Setup List</h3>
                <div class="card-tools">
                @if(helper::roleAccess('settings.generalSetup.create'))
                    <a class="btn btn-default" href="{{ route('settings.generalSetup.create') }}"><i class="fas fa-plus"></i>
                        Add New</a>
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
            <div class="card-body">
           
                    <div class="card card-default card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            @foreach($allCategory as $key => $eachCategory)
                            <li class="nav-item">
                              <a class="nav-link @if($key == 0) active @endif" id="custom-tabs-one-{{$eachCategory}}-tab" data-toggle="pill" href="#custom-tabs-one-{{$eachCategory}}" role="tab" aria-controls="custom-tabs-one-{{$eachCategory}}" aria-selected="true"><br>{{$eachCategory}}</a>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                    <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">
                            @foreach($allCategory as $key => $eachCategory)
                           
                          <div class="tab-pane fade show @if($key == 0) active @endif" id="custom-tabs-one-{{$eachCategory}}" role="tabpanel" aria-labelledby="custom-tabs-one-{{$eachCategory}}-tab">
                               
                          <form class="needs-validation" method="POST"  action="{{ route('settings.generalSetup.update',$editInfo->id) }}" novalidate>
                                @csrf
                                @if(!empty($formInput) && is_array($formInput))

                                <div class="form-row">
                                    @foreach ($formInput as $key => $eachInput)
                                        @if(!empty($eachInput->category) && $eachInput->category == $eachCategory && $eachInput->inputShow == true)
                                           @php htmlform::formfiled($eachInput, $errors, $editInfo) @endphp
                                        @endif
                                       
                                    @endforeach
                                </div>
                                <input type="hidden" name="form_name" value="{{lcfirst($eachCategory)}}"/>
                                <button class="btn btn-info"  type="submit"><i class="fa fa-save"></i> &nbsp;Update</button>
                          
                                @else
                                <div class="alert alert-default">
                                    <strong>Warning!</strong> Sorry you have no form access !!.
                                  </div>
                                @endif
                                </form>
                            </div>
                            @endforeach
                          </div>
                        </div>
                        <!-- /.card -->
                      </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
        </div>
    </div>
    <!-- /.col-->
</div>



@endsection
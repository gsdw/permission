@extends('layouts.default')

@section('content')
<?php use Gsdw\Base\Helpers\Form; ?>
@if(isset($title) && $title)
<h3>{{ $title }}</h3>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="form-wrapper">
            <form class="form-horizontal" action="" method="post">
                {!! csrf_field() !!}
                <div class="box-footer">
                    <input type="submit" class="btn btn-default" name="submit" value="Save" />
                    <input type="submit" class="btn btn-info" name="submit_continue" value="Save And Continue" />
                    <input type="reset" class="btn btn-info" name="reset" value="Reset" />
                    @if(Form::getData('id'))
                        <a href="{{ route('auth.role.group.delete', ['id' => Form::getData('id'), 'token' => csrf_token() ]) }}" class="btn btn-danger delete-confirm" >
                            Delete
                        </a>
                    @endif
                    <a href="{{ route('auth.role.group.list') }}" class="btn btn-info">Back</a>
                </div>
                <div class="box-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#item-general">General</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="item-general" class="tab-pane active">
                            @include('gsdw_permission::role.group.tab.general')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

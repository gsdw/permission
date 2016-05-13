@extends('layouts.default')

@section('content')
<?php
use Gsdw\Base\Helpers\General;
use Gsdw\Base\Helpers\Form;
?>
@if(isset($title) && $title)
<h2>{{ $title }}</h2>
@endif
<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('auth.role.createForm') }}"
                   class="btn btn-info">Add new</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                @include('gsdw_permission::include.pager')
            </div>
        </div>
        <div class="row">
            <form class="form-grid-actions" method="post" action="{{ route('auth.role.massAction') }}">
                {!! csrf_field() !!}
                <div class="col-sm-6 grid-filters">
                    <button type="button" class="btn btn-info btn-search-filter"><span>Search</span></button>
                    <button type="button" class="btn btn-info btn-reset-filter" data-href="{{ Request::url() }}">
                        <span>Reset filter</span>
                    </button>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
                                <th class="sortable {{ General::getDirClassHtml('id') }}" onclick="window.location.href='{{General::getUrlOrder('id')}}';">Id</th>
                                <th class="sortable {{ General::getDirClassHtml('name') }}" onclick="window.location.href='{{General::getUrlOrder('name')}}';">Name</th>
                                <th class="sortable {{ General::getDirClassHtml('group_name') }}" onclick="window.location.href='{{General::getUrlOrder('group_name')}}';">Group Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-filter-grid">
                                <td>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>From</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[role,id][from]" value="{{ Form::pullData('role,id.from') }}" placeholder="From" class="filter-grid" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>To</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[role,id][to]" value="{{ Form::pullData('role,id.to') }}" placeholder="To" class="filter-grid" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[role,name]" value="{{ Form::pullData('role,name') }}" placeholder="Name" class="filter-grid" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[role_group,name]" value="{{ Form::pullData('role_group,name') }}" placeholder="Group Name" class="filter-grid" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if(count($model))
                                @foreach($model as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->group_name }}</td>
                                        <td>
                                            <a href="{{ route('auth.role.editForm', ['id' => $item->id ]) }}" class="button btn-edit">Edit</a>
                                            <span>|</span>
                                            <a href="{{ route('auth.role.delete', ['id' => $item->id, 'token' => csrf_token() ]) }}" class="button btn-delete delete-confirm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


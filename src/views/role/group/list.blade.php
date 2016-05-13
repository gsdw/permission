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
                <a href="{{ route('auth.role.group.createForm') }}"
                   class="btn btn-info">Add new role group</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                @include('gsdw_permission::include.pager')
            </div>
        </div>
        <div class="row">
            <form class="form-grid-actions" method="post" action="{{ route('auth.role.group.massAction') }}">
                {!! csrf_field() !!}
                <div class="col-sm-6 grid-filters">
                    <button type="button" class="btn btn-info btn-search-filter"><span>Search</span></button>
                    <button type="button" class="btn btn-info btn-reset-filter" data-href="{{ Request::url() }}">
                        <span>Reset filter</span>
                    </button>
                </div>
                <div class="col-sm-6 grid-actions">
                    <label>Action 
                        <select name="action" class="form-control input-sm">
                            <option value=""></option>
                            <option value="delete">Delete</option>
                        </select>
                    </label>
                    <input type="submit" class="btn btn-info btn-grid-action-submit" name="submit" value="Submit" />
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
<!--                                <th>
                                    <input type="checkbox" class="input-checkbox mass-selectbox" />
                                </th>-->
                                <th class="sortable {{ General::getDirClassHtml('id') }}" onclick="window.location.href='{{General::getUrlOrder('id')}}';">Id</th>
                                <th class="sortable {{ General::getDirClassHtml('name') }}" onclick="window.location.href='{{General::getUrlOrder('name')}}';">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-filter-grid">
<!--                                <td>&nbsp;</td>-->
                                <td>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>From</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[id][from]" value="{{ Form::pullData('id.from') }}" placeholder="From" class="filter-grid" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>To</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[id][to]" value="{{ Form::pullData('id.to') }}" placeholder="To" class="filter-grid" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="text" name="filter[name]" value="{{ Form::pullData('name') }}" placeholder="Name" class="filter-grid" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if(count($model))
                                @foreach($model as $item)
                                    <tr>
<!--                                        <td>
                                            <input type="checkbox" class="input-checkbox item-id mass-item" name="item[]" value="{{ $item->id }}"
                                        </td>-->
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('auth.role.group.editForm', ['id' => $item->id ]) }}" class="button btn-edit">Edit</a>
                                            <span>|</span>
                                            <a href="{{ route('auth.role.group.delete', ['id' => $item->id, 'token' => csrf_token() ]) }}" class="button btn-delete delete-confirm">Delete</a>
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


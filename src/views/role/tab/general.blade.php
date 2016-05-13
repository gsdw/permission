<?php use Gsdw\Base\Helpers\Form; ?>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-name">Name</label>
    <div class="col-sm-10">
        <input type="text" name="item[name]" id="item-name" 
            class="form-control" placeholder="Name" value="{{ Form::getData('name') }}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-group">Group</label>
    <div class="col-sm-10">
        <select name="item[role_group_id]" id="item-group" class="form-control">
            @foreach (\Gsdw\Permission\Models\RoleGroup::toOption() as $option)
                <option value="{{ $option['value'] }}" <?php
                    if(Form::getData('role_group_id') == $option['value']) {
                        echo ' selected';
                    }
                ?>>{{ $option['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<?php use Gsdw\Base\Helpers\Form; ?>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-name">Name</label>
    <div class="col-sm-10">
        <input type="text" name="item[name]" id="item-name" 
            class="form-control" placeholder="Name" value="{{ Form::getData('name') }}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-email">Email</label>
    <div class="col-sm-10">
        <input type="text" name="item[email]" id="item-email" 
            class="form-control" placeholder="Email" value="{{ Form::getData('email') }}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-group">Role</label>
    <div class="col-sm-10">
        <select name="item[role_id]" id="item-group" class="form-control">
            @foreach (\Gsdw\Permission\Models\Role::toOption() as $option)
                <option value="{{ $option['value'] }}" <?php
                    if(Form::getData('role_id') == $option['value']) {
                        echo ' selected';
                    }
                ?>>{{ $option['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-name">Password</label>
    <div class="col-sm-10">
        <input type="password" name="item[password]" id="item-password" 
            class="form-control" placeholder="Password" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="item-name">Re-Password</label>
    <div class="col-sm-10">
        <input type="password" name="item[repassword]" id="item-repassword" 
            class="form-control" placeholder="Re-Password" />
    </div>
</div>
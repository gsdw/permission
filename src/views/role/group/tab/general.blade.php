<?php use Gsdw\Base\Helpers\Form; ?>

<div class="form-group">
    <label class="col-sm-2 control-label" for="item-name">Name</label>
    <div class="col-sm-10">
        <input type="text" name="item[name]" id="item-name" 
            class="form-control" placeholder="Name" value="{{ Form::getData('name') }}" />
    </div>
</div>


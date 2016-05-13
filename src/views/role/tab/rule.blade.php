<?php
$i = 0;
$rules = \Gsdw\Base\Helpers\Form::getData('rule');
$rules = (array) $rules;
$routeCollection = Gsdw\Permission\Helpers\General::getRouterAs();
?>
<div class="rule-path-list format-tree">
    <div class="form-group rule-all-group">
        <span class="input-box">
            <input type="checkbox" name="rule[]" value="all"
                class="input-checkbox rule-checkbox-item" id="rule-all"
                <?php if(in_array(Gsdw\Permission\Models\RoleScope::RULE_ALL, $rules)): ?> checked<?php endif; ?>/>
        </span>
        <label class="control-label" for="rule-all">All</label>
    </div>
    @if(count($routeCollection))
        <div class="rule-item-group">
            @foreach ($routeCollection as $routeKey => $routeName)
                <?php $i++; ?>
                <div class="form-group">
                    <span class="input-box">
                        <input type="checkbox" name="rule[{{ $i }}]" value="{{ $routeKey }}"
                            class="input-checkbox rule-checkbox-item" id="rule-{{ $i }}"
                            <?php if(key_exists($routeKey, $rules)): ?> checked<?php endif; ?>/>
                    </span>
                    <label class="control-label" for="rule-{{ $i }}">{{ $routeName }}</label>
                    <span class="role-scope-input">
                        <select name="scope[{{ $i }}]" class="input-select form-control">
                            @foreach (\Gsdw\Permission\Models\RoleScope::toOption() as $option)
                                <option value="{{ $option['value'] }}"<?php
                                    if (isset($rules[$routeKey]) && 
                                        $rules[$routeKey]->scope == $option['value']) {
                                        echo ' selected';
                                    }
                                ?>>{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
        
<div class="col-lg-3"  wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8">
    <div class="form-group">
        <label><h5 style="color: gray">{{ !isset($alias[$name]) ? $name : $alias[$name] }}</h5></label>
        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ !isset($formatted[$name]) ? $value :  $formatted[$name]}}</p>
    </div>
</div>

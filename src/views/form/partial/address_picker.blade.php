<?php $uniqId = uniqid(); ?>
@if($showLabel && $showField && !$options['is_child'])
    <div {!! $options['wrapperAttrs'] !!}  >
@endif
@if ($showLabel)
    <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
    {!! Form::label($name, $options['label'], $options['label_attr']) !!}
@endif

<div class="col-md-4">
    @if ($showField)
            <div class="margin-bottom-10">
                @if(isset($noEdit) and $noEdit === true)
                    {!! $options['default_value']['default'] !!}
                @else
                    {!! Form::hidden($name.'[lat]',$options['default_value']['lat']) !!}
                    {!! Form::hidden($name.'[lng]', $options['default_value']['lng']) !!}
                    {!! Form::hidden($name.'[street]', $options['default_value']['street']) !!}
                    {!! Form::hidden($name.'[city]', $options['default_value']['city']) !!}
                    {!! Form::hidden($name.'[state]',$options['default_value']['state']) !!}
                    {!! Form::hidden($name.'[country]',$options['default_value']['country']) !!}
                    {!! Form::input($type, $name.'[default]', $options['default_value']['default'], $options['attr']) !!}
                @endif
            </div>
    @endif

    @if ($showError && isset($errors))
        {!!$errors->first(array_get($options, 'real_name', $name), '<span '.$options['errorAttrs'].'>:message</span>')!!}
    @endif
    <div  id="{!!$uniqId!!} -map" class="" style="height: 300px"></div>

    @if(isset($options['help']))
        <span class="help-block">{!!$options['help']!!} </span>
    @endif
</div>
@if ($showLabel && $showField && !$options['is_child'])
</div>
@endif
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<script>
    jQuery(document).ready(function(){
        jQuery('#{!!$uniqId!!} -map').locationpicker({
            location: {
                latitude: {!!$options['default_value']['lat']!!} ,
                longitude: {!!$options['default_value']['lng']!!}
            },
            radius: 0,
            @if(empty($noEdit))
            inputBinding: {
                latitudeInput: jQuery('input[name="{!!$name.'[lat]'!!}"]'),
                longitudeInput: jQuery('input[name="{!!$name.'[lng]'!!}"]'),
                locationNameInput: jQuery('input[name="{!!$name.'[default]'!!}"]')
            },
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                var addressComponents = $(this).locationpicker('map').location.addressComponents;
                jQuery('input[name="{!!$name.'[street]'!!}"]').val(addressComponents.addressLine1);
                jQuery('input[name="{!!$name.'[city]'!!}"]').val(addressComponents.city);
                jQuery('input[name="{!!$name.'[state]'!!}"]').val(addressComponents.stateOrProvince);
                jQuery('input[name="{!!$name.'[zip]'!!} "]').val(addressComponents.postalCode);
                jQuery('input[name="{!!$name.'[country]'!!}"]').val(addressComponents.country);
            },
            @endif
           enableAutocomplete: true
        });
    })

</script>



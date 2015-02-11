@if($options['attr']['type'] == 'submit')
    <?php $options['label'] .= ' <i class="m-icon-swapright m-icon-white"></i>'; ?>
@endif
{{ Form::button($options['label'], $options['attr']) }}

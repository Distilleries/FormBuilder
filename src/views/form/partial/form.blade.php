@if ($showStart)
    @if($model && $model->exists)
        {!! Form::model($model, $formOptions) !!}
    @else
        {!! Form::open($formOptions) !!}
    @endif
@endif

@if($showFields)
    @foreach ($fields as $field)
        @if(isset($isNotEditable) and $isNotEditable === true)
            @if(method_exists($field,'view') and $field->getType() != 'submit')
                <?php $default = $field->getOptions(); ?>
                @if(empty($default['default_value']))
                    <?php $name = last(explode('[', rtrim($field->getName(), ']'))); ?>
                    {!! $field->view([
                    'default_value'=>($model && $model->exists and isset($model->{$name}))?$model->{$name}:$default['default_value'],
                    'model'=>(!empty($model) and isset($model->{$name}))?$model->{$name}:null
                    ]) !!}
                @else
                    {!! $field->view() !!}
                @endif

            @endif
        @else
            {!!$field->render() !!}
        @endif
    @endforeach
@endif

@if ($showEnd)
    {!! Form::close() !!}
@endif

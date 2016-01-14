<?php $choices = []; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>#</th>
        @foreach($options['choices'] as $header)
            <?php $choices = $header['choices']; ?>
            <th>

            <div class="input-group">
                <div class="icheck-inline">
                    <label>{!! $header['libelle'] !!} </label>
                    <label>
                     {!! Form::radio($header['id'], 1, false, [
                            'class'=>'icheck check-all',
                      ]) !!}  {{trans('form-builder::form.all')}}
                    </label>
                    <label>
                     {!! Form::radio($header['id'], 0, false, [
                            'class'=>'icheck uncheck-all',
                      ]) !!}  {{trans('form-builder::form.none')}}
                    </label>
                </div>
            </div>

            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
        @if(!empty($choices))
            <?php $iterator = 0; ?>
            @foreach($choices as $libelle=>$choice)
                <tr>
                    <td>{!! $libelle !!} </td>
                    @foreach($options['choices'] as $header)
                        <td>
                            <div class="input-group">
                                <div class="icheck-list">
                                    @foreach($choice as $ch)
                                        <label>
                                        {!! Form::checkbox($name.'['.$header['id'].'][]', $ch['id'], in_array($ch['id'],$options['selected'][$header['id']]), [
                                            'class'=>'icheck selectore-choice-area-js',
                                            'data-checkbox'=>(in_array($ch['id'],$options['selected'][$header['id']]))?'icheckbox_line-blue':'icheckbox_line-grey',
                                            'data-label'=>$ch['libelle'],
                                        ]) !!}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </td>
                    @endforeach
                </tr>
                <?php $iterator ++; ?>
            @endforeach
        @endif
    </tbody>
    </table>
</div>
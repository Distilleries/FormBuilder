<?php $lines = $options['lines']; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            @foreach(array_keys($options['cols']) as $header)
                <th>

                    <div class="input-group">
                        <div class="icheck-inline">
                            <label>{!! $header !!} </label>
                        </div>
                    </div>

                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @if(!empty($lines))
            @foreach($lines as $map_id=>$line)
                <tr>
                    <td>{!! $line !!} </td>
                    @foreach($options['cols'] as $iso=>$values)
                        <td>
                            <div class="input-group">
                                @if(isset($values[$map_id]))
                                    {!! Form::textarea($line.'['.$iso.']', $values[$map_id]) !!}
                                @else
                                    {!! Form::textarea($line.'['.$iso.']', '') !!}
                                @endif
                            </div>

                        </td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
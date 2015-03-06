@section('form')
<div class="row">
    <div class="col-md-12">
        <div class="portlet box yellow">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-pencil"></i>{{trans('form-builder::form.detail')}}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body form ">
                <div class="form-horizontal form-bordered">
                {!! form_start($form) !!}
                    <div class="form-actions top">
                        <div class="btn-set pull-right">
                            {!! form_widget($form->back) !!}
                           {!! form_widget($form->submit) !!}
                        </div>
                    </div>
                    <div class="form-body">
                        {!! form_rest($form) !!}
                    </div>
                    <div class="form-actions ">
                        <div class="btn-set pull-right">
                           {!! form_widget($form->back) !!}
                           {!! form_widget($form->submit) !!}
                        </div>
                    </div>
                {!! form_end($form) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
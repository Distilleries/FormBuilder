@section('form')
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-pencil"></i>{{trans('form-builder::form.detail')}}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body form ">
                <div class="form-actions top">
                    <div class="btn-set pull-right">
                       {!! form_widget($form->back) !!}
                           <a href="{{ action($route.'getEdit',$id) }}" class="btn btn-sm yellow filter-submit margin-bottom"><i class="glyphicon glyphicon-edit"></i> {{trans('form-builder::form.edit')}}</a>
                    </div>
                </div>
                <div class="form-horizontal form-bordered">
                    {!! form_rest_view($form) !!}
                </div>
                <div class="form-actions ">
                    <div class="btn-set pull-right">
                       {!! form_widget($form->back) !!}
                          <a href="{{ action($route.'getEdit',$id) }}" class="btn btn-sm yellow filter-submit margin-bottom"><i class="glyphicon glyphicon-edit"></i> {{trans('form-builder::form.edit')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
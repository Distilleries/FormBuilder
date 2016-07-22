@if(is_object($errors) and $errors->has() and !empty($errors->all()))
<div class="alert alert-danger alert-dismissible">
    <button class="close" data-dismiss="alert"></button>
    <ul>
      @foreach ($errors->all() as $error)
          <li>{!! $error !!} </li>
      @endforeach
     </ul>
  </div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible">
    <button class="close" data-dismiss="alert"></button>
    <ul>
        <li>{!! Session::get('error') !!} </li>
     </ul>
  </div>
@endif


@if(Session::has('warnings'))
<div class="alert alert-warning alert-dismissible">
    <button class="close" data-dismiss="alert"></button>
    <ul>
      @foreach (Session::get('warnings') as $warning)
          <li>{!! $warning !!} </li>
      @endforeach
     </ul>
  </div>
@endif

@if(Session::has('messages'))
<div class="alert alert-success alert-dismissible">
    <button class="close" data-dismiss="alert"></button>
    <ul>
      @foreach (Session::get('messages') as $messages)
          <li>{!! $messages !!} </li>
      @endforeach
     </ul>
  </div>
@endif
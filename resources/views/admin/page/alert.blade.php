@if(session('success'))
<div data-notify="container" class="alert alert-success m-alert animated bounce alert-win" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
    <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
    <span data-notify="message">{{session('success')}}!</span>
    <a href="#" target="_blank" data-notify="url"></a>
</div>
@elseif(session('error'))
<div data-notify="container" class="alert alert-success m-alert animated bounce alert-error" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
    <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
    <span data-notify="message">{{session('error')}}!</span>
    <a href="#" target="_blank" data-notify="url"></a>
</div>
@endif
@if ($errors->any())
<div data-notify="container" class="alert alert-success m-alert animated bounce alert-error" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
    <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute
        ; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
    @foreach ($errors->all() as $error)
    <span data-notify="message">{{ $error }} !</span>
    @endforeach
    <a href="#" target="_blank" data-notify="url"></a>
</div>
@endif
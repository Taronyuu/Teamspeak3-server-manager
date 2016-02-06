@if(Session::get('success') || Session::get('error') || $errors->has())
    <div class="content" style="padding: 0px; width: 100%">
        @if(Session::get('success'))
            <div class="alert alert-success" style="">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger" style="">
                {{ Session::get('error') }}
            </div>
        @endif
        @if ($errors->has())
            <div class="alert alert-danger" style="">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
    </div>
@endif
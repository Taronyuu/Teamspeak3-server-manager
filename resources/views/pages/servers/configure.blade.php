@extends('app')

@section('page_title', 'Create server')

@section('content')
    <div class="row">
        @include('partials.messages')
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['action' => ['ServerController@postConfigure', $server], 'method' => 'post']) !!}

                    @foreach($serverData as $key => $line)
                        <div class="form-group">
                            {!! Form::label($key, ucfirst(str_replace('_', ' ', $key))) !!}
                            {!! Form::text($key, $line, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                {!! Form::submit('Update!',['class' => 'btn btn-success', 'style' => 'width: 100%']) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                            <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection
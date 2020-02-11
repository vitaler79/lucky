@extends('layouts.app')

@section('content')
<div class="container shiping-page">
    @include('dashboard')

    <div class="row justify-content-center">
        <div class="col-md-12 text-center">

            @if (isset($bank->id))

                <h2>Your prize -  {!! $raffle->prize !!}$</h2>
                @if ($bank->status==0)
                    <h3>Transfer is waiting for approval</h3>
                @endif
                @if ($bank->status==1)
                    <h3>Transfer has been sent</h3>
                @endif

                <br><br>
                <div class="form-group">
                    <a href="{{ route('home') }}" class="btn btn-primary">Go to home</a>
                </div>

            @else

                <h2>Send your prize to Bank!</h2>

                <div class="form-block">
                    {!! Form::open(['route' => 'bank.query']) !!}
                    {!! Form::hidden('raffle_id', $raffle->id) !!}
                    <div class="form-group">
                        {!! Form::label('Full name') !!}
                        {!! Form::text('full_name', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Bank account') !!}
                        {!! Form::text('account', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::email('email', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Send', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close()!!}
                </div>

            @endif

        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container shiping-page">
    @include('dashboard')

    <div class="row justify-content-center">
        <div class="col-md-12 text-center">

            @if (isset($shipping->id))
                <h2>Your prize -  {!! $shipping->prize_name !!}</h2>
                @if ($shipping->status==0)
                    <h3>Shipping status: waiting for sending</h3>
                @endif
                @if ($shipping->status==1)
                    <h3>Shipping status: has been sent</h3>
                @endif

                <br><br>
                <div class="form-group">
                    <a href="{{ route('home') }}" class="btn btn-primary">Go to home</a>
                </div>
            @else
                <h2>Send your prize!</h2>
                <div class="form-block">
                    {!! Form::open(['route' => 'shipping.query']) !!}
                    {!! Form::hidden('raffle_id', $raffle->id) !!}
                    {!! Form::hidden('prize_name', $prizeName) !!}
                    <div class="form-group">
                        {!! Form::label('Full name') !!}
                        {!! Form::text('full_name', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Country') !!}
                        {!! Form::select('country',['Czech' => 'Czech','Slovakia'=>'Slovakia','Poland'=>'Poland'], null,['class'=>'form-control', 'placeholder'=>'Choose the country', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Zip') !!}
                        {!! Form::text('zip', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Address') !!}
                        {!! Form::text('address', null, ['class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Phone') !!}
                        {!! Form::tel('phone', null, ['class'=>'form-control', 'required']) !!}
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

@extends('layouts.app')

@section('content')
    <div class="container home-page">
        @include('dashboard')

        <div class="row justify-content-center">
            <div class="col-md-12 text-center">

                @if (isset($prize))

                    @if ('money'==$prize->prize_type)
                        <h2>You win - {!! $prize->prize !!}$</h2>

                        {!! Form::open(['route' => 'home.moneyToAccount']) !!}
                        <div class="form-group">
                            {!! Form::submit('Convert money to loyalty account', ['class'=>'btn btn-primary']) !!}
                            {!! Form::hidden('id', $prize->id) !!}
                        </div>
                        {!! Form::close()!!}

                        <div class="form-group">
                            <a href="{{ route('bank', $prize->id) }}" class="btn btn-primary">Send to Bank</a>
                        </div>
                    @endif

                    @if ('bonus'==$prize->prize_type)
                        <h2>You win - {!! $prize->prize !!} bonuses</h2>

                        {!! Form::open(['route' => 'home.bonusToAccount']) !!}
                        <div class="form-group">
                            {!! Form::submit('Convert bonuses to loyalty account', ['class'=>'btn btn-primary']) !!}
                            {!! Form::hidden('id', $prize->id) !!}
                        </div>
                        {!! Form::close()!!}
                    @endif

                    @if ('product'==$prize->prize_type)
                        <h2>You win - {!! $prizeName !!}</h2>
                        <div class="form-group">
                            <a href="{{ route('shipping', $prize->id) }}" class="btn btn-primary">Send prize</a>
                        </div>
                    @endif

                    {!! Form::open(['route' => 'home.refuse']) !!}
                    <div class="form-group">
                        {!! Form::submit('Refuse from prize', ['class'=>'btn btn-primary']) !!}
                        {!! Form::hidden('id', $prize->id) !!}
                    </div>
                    {!! Form::close()!!}

                @else
                    <h2>Get your prize!</h2>
                    {!! Form::open(['route' => 'home.getPrize']) !!}
                    <div class="form-group">
                        {!! Form::submit('Choose prize', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close()!!}
                @endif

            </div>
        </div>

    </div>
@endsection

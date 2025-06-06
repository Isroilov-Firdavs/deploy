@extends('layouts.app')

@section('content')
<form action="{{ route('test.submit') }}" method="POST">
    @csrf
    @foreach($questions as $index => $question)
        <div>
            <p><strong>{{ $index+1 }}. {{ $question->question }}</strong></p>
            @foreach(['a', 'b', 'c', 'd'] as $option)
                <label>
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                    {{ strtoupper($option) }}. {{ $question->{'option_'.$option} }}
                </label><br>
            @endforeach
        </div>
        <hr>
    @endforeach
    <button type="submit">Yuborish</button>
</form>
@endsection

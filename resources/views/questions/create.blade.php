@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('questions.store') }}">
    @csrf
    <input type="text" name="question" placeholder="Savol" required><br>
    <input type="text" name="option_a" placeholder="Variant A" required><br>
    <input type="text" name="option_b" placeholder="Variant B" required><br>
    <input type="text" name="option_c" placeholder="Variant C" required><br>
    <input type="text" name="option_d" placeholder="Variant D" required><br>
    <select name="correct_answer" required>
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
        <option value="d">D</option>
    </select><br>
    <button type="submit">Saqlash</button>
</form>
@endsection

@extends('layout')

@section('title')
{{$page}}
@endsection

@section('header')
<h1>Olá, {{ $username }}</h1>
@endsection

@section('content')
<p>Page Content</p>
<form>
    <label for="teste"></label>
    <input id="teste" type="text" placeholder="'teste" name="name">
    <button type="submit">Enviar</button>
</form>
@endsection

@section('js')
<script>
    const button = document.getElementById('t');
</script>
@endsection


@section('footer')
<p>Page Footer</p>
@endsection

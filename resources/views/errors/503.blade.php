@extends('errors.simples')

@section('title', 'Site em manutenção')
@section('code', 'Em manutenção')
@section('heading', 'Voltamos em instantes')
@section('message', 'O site está passando por uma atualização rápida. Aguarde alguns minutos e recarregue a página.')

@section('actions')
  <a href="{{ url()->current() }}" class="btn btn-primary">Recarregar a página</a>
@endsection
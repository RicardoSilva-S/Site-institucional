@extends('errors.simples')

@section('title', 'Erro no servidor')
@section('code', 'Erro 500')
@section('heading', 'Algo deu errado do nosso lado')
@section('message', 'Tivemos um problema ao carregar esta página. Tente novamente em alguns instantes. Se o problema continuar, fale com o Instituto.')

@section('actions')
  <a href="{{ url()->current() }}" class="btn btn-primary">Tentar novamente</a>
  <a href="{{ url('/') }}" class="btn btn-outline">Voltar para o início</a>
@endsection
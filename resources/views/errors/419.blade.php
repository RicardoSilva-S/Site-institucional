@extends('errors.simples')

@section('title', 'Página expirada')
@section('code', 'Erro 419')
@section('heading', 'A página expirou')
@section('message', 'Esta página ficou aberta por muito tempo e, por segurança, o formulário não foi enviado. Volte, recarregue a página e envie de novo.')

@section('actions')
  <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar e tentar de novo</a>
  <a href="{{ url('/') }}" class="btn btn-outline">Ir para o início</a>
@endsection
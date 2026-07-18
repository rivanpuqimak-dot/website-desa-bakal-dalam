@extends('admin.layouts.app')

@section('title','Dashboard')

@section('content')

@include('admin.components.hero')

@include('admin.components.stats')

@include('admin.components.management')

@include('admin.components.activity')

@endsection
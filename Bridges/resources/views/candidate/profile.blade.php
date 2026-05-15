@extends('layouts.app')

@section('title', 'Profile — CareerPortal')
@section('header-title', 'My Profile')

@section('header-actions-prefix')
<button class="btn-icon">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
</button>
@endsection

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('content')
    @include('shared.profile_content')
@endsection
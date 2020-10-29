@extends('layouts.master')

@section('title', 'Все категории')

@section('content')
    <div class="categories">
        @foreach($categories as $category)
            <div class="category">
                <a href="{{ route('category', $category->code) }}">
                    <img src="{{ Storage::url($category->image) }}" height="100px" width="100px">
                    <h4>{{ $category->name }}</h4>
                </a>
{{--                <p>{{ $category->description }}</p>--}}
            </div>
        @endforeach
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Input Bobot Kriteria</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('criteria-weights.store') }}">
        @csrf

        @foreach($criterias as $criteria)
            <div class="mb-3">
                <label class="form-label">
                    {{ $criteria->name }}
                    ({{ strtoupper($criteria->type) }})
                </label>
                <input
                    type="number"
                    name="weights[{{ $criteria->id }}]"
                    class="form-control"
                    min="1"
                    max="5"
                    required
                >
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">
            Simpan Bobot
        </button>
    </form>
</div>
@endsection

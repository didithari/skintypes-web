@extends('admin.layouts.app')

@section('title', 'Edit Prediction')
@section('header_title', 'Prediction Results')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Edit Prediction</h2>
            <a href="{{ route('admin.predictions.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.predictions.update', $prediction) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="skin_type_id">Skin Type</label>
                <select id="skin_type_id" name="skin_type_id" required>
                    @foreach($skinTypes as $skinType)
                        <option value="{{ $skinType->id }}" @selected(old('skin_type_id', $prediction->skin_type_id) == $skinType->id)>{{ $skinType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="confidence">Confidence (0 - 1)</label>
                <input type="number" step="0.0001" min="0" max="1" id="confidence" name="confidence" value="{{ old('confidence', $prediction->confidence) }}">
            </div>

            <div class="field">
                <label for="predicted_at">Predicted At</label>
                <input type="datetime-local" id="predicted_at" name="predicted_at" value="{{ old('predicted_at', optional($prediction->predicted_at)->format('Y-m-d\\TH:i')) }}">
            </div>

            <div class="field">
                <label for="image_path">Image Path</label>
                <input type="text" id="image_path" name="image_path" value="{{ old('image_path', $prediction->image_path) }}">
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
@endsection

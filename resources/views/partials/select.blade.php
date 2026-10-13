<div class="{{ $col ?? 'col-md-6' }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" class="form-select @error($name) is-invalid @enderror">
        <option value="">-- Select --</option>
        @foreach ($options as $key => $text)
            <option value="{{ $key }}" @selected((string) old($name, $value ?? '') === (string) $key)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

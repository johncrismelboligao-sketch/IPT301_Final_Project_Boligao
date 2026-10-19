<div class="{{ $col ?? 'col-md-6' }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @if (($type ?? 'text') === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="3" class="form-control @error($name) is-invalid @enderror">{{ old($name, $value ?? '') }}</textarea>
    @else
        <input type="{{ $type ?? 'text' }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value ?? '') }}"
            class="form-control @error($name) is-invalid @enderror"
            @if (isset($min)) min="{{ $min }}" @endif
            @if (isset($max)) max="{{ $max }}" @endif
            @if (isset($maxlength)) maxlength="{{ $maxlength }}" @endif
            @if (isset($pattern)) pattern="{{ $pattern }}" @endif>
    @endif
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

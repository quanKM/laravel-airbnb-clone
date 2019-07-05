@if ($errors->has($attr))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first($attr) }}</strong>
    </span>
@endif

<input type="hidden" name="{{ $name }}" value="0">
<input
    type="checkbox" name="{{ $name }}" value="1"
    @if ($value == 1) checked @endif
    id="{{ $name }}">

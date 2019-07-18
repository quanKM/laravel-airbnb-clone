<select
    name="{{ $name }}"
    id="{{ $name }}"
    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">

    <option selected disabled>Select...</option>

    @foreach ($options as $key => $option)
        <option
            value="{{ $option == "4+" ? $key : $option }}"
            @if ($selected == $option) selected @endif
        >{{ $option }}</option>
    @endforeach
</select>

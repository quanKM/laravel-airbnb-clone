<ul class="sidebar list-unstyled">
    <li>
        <a href="{{ route('rooms.listing', $room) }}">Listing</a>
        @includeWhen(true, 'partials/check_done')
    </li>
    <li>
        <a href="{{ route('rooms.pricing', $room) }}">Pricing</a>
        @includeWhen($room->price, 'partials/check_done')
    </li>
    <li>
        <a href="{{ route('rooms.description', $room) }}">Description</a>
        @includeWhen($room->listing_name, 'partials/check_done')
    </li>
    <li>
        <a href="{{ route('rooms.photos', $room) }}">Photos</a>
        @includeWhen($room->photos()->exists(), 'partials/check_done')
    </li>
    <li>
        <a href="{{ route('rooms.amenities', $room) }}">Amenities</a>
        @includeWhen(true, 'partials/check_done')
    </li>
    <li>
        <a href="{{ route('rooms.location', $room) }}">Location</a>
        @includeWhen($room->address, 'partials/check_done')
    </li>
</ul>

<hr>

@if ($room->isReady())
    <form method="POST" action="{{ route('rooms.publish', $room) }}">
        @csrf
        @method('PATCH')

        <button type="submit" class="btn btn-normal btn-block">Publish</button>
    </form>
@else
    <button disabled type="submit" class="btn btn-normal btn-block disabled">Publish</button>
@endif
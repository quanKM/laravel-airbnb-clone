<ul class="sidebar list-unstyled">
    <li>
        <a class="{{ $route == 'rooms.index' ? 'active' : '' }}" href="{{ route('rooms.index') }}">Your Listings</a>
    </li>
    <li>
        <a class="{{ $route == 'your_reservations' ? 'active' : '' }}" href="{{ route('your_reservations') }}">Your Reservations</a>
    </li>
    <li>
        <a class="{{ $route == 'your_trips' ? 'active' : '' }}" href="{{ route('your_trips') }}">Your Trips</a>
    </li>
</ul>
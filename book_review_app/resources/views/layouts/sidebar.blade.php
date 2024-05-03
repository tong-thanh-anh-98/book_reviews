<ul class="nav flex-column">
    @if (Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('books.index') }}">Books</a>                               
        </li>
        <li class="nav-item">
            <a href="#">Reviews</a>                               
        </li>
    @endif
    <li class="nav-item">
        <a href="{{ route('account.profile') }}">Profile</a>                               
    </li>
    <li class="nav-item">
        <a href="#">My Reviews</a>
    </li>
    <li class="nav-item">
        <a href="#">Change Password</a>
    </li> 
    <li class="nav-item">
        <a href="{{ route('account.logout') }}">Logout</a>
    </li>                           
</ul>
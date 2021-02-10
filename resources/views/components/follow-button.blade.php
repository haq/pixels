@props(['user'])

<div>
    @if(auth()->check() && auth()->id() !== $user->id)
        <form method="post" action="{{ route('users.follow', $user->id) }}">
            @csrf
            @if(auth()->user()->isFollowing($user))
                <input type="submit" class="btn btn-danger" value="Unfollow">
            @else
                <input type="submit" class="btn btn-secondary" value="Follow">
            @endif
        </form>
    @endif
</div>

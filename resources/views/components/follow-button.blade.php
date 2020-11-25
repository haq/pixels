<div>
    @if(auth()->check() && auth()->id() !== $user->id)
        @if(auth()->user()->isFollowing($user))
            <form method="post" action="{{ route('users.follow', $user->id) }}">
                @csrf
                <input type="submit" class="btn btn-danger" value="Unfollow">
            </form>
        @else
            <div class="col-auto">
                <form method="post" action="{{ route('users.follow', $user->id) }}">
                    @csrf
                    <input type="submit" class="btn btn-secondary" value="Follow">
                </form>
            </div>
        @endif
    @endif
</div>

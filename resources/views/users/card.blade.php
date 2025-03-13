<div class="card border border-base-300">
    <div class="card-body bg-base-200 text-4xl">
        <h2 class="card-title">{{ $user->users }}</h2>
    </div>
    <figure>
        {{-- ユーザーのメールアドレスをもとにGravatarを非表示 --}}
        <img src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
    </figure>
</div>
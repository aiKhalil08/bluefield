<x-login name='Oversight' role="Admin">
<x-slot:title>Login | Admin</x-slot:title>
{{-- @php
    $random = rand(1, 5);
    $src = '/public_pics/pic_'.$random.'.jpg';
//  $src = '/public_pics/pic_'.$random.'.jpg';
@endphp --}}
<form action="{{route('admin.login')}}" data-title="Login | Admin" class="login-form" data-action="login" data-type="staff" method="POST">
    <img src="{{$src}}" alt="an image">
    <h4 class="header-box">Sign in to your account</h4>
    <article class="form-box">
        <div>
            <label for="username">Username</label><input id="username" type="text" name="username" placeholder="admin username...">
        </div>
        <div>
            <label for="password">Password</label><input id="password" type="password" name="password" placeholder="admin password...">
        </div>
    </article>
    <article class="buttons-box">
        <button id="submit" name="submit" class="button executor"><span>Login</span></button>
    </article>
</form>
</x-login>
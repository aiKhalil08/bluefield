<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login | Admin</title>
</head>
<body class="login-page">
    <section class="login-sidebar">
        @php
         $random = rand(1, 5);
         $src = '/public_pics/pic_'.$random.'.jpg';
        //  $src = '/public_pics/pic_'.$random.'.jpg';
        @endphp
        <figure>
            <img src="{{$src}}" alt="an image">
        </figure>
    </section>
    {{-- {{$slot}} --}}
    <form action="{{route('admin.login')}}" data-title="Login | Admin" class="login-form" data-action="login" data-type="admin" method="POST">
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
    </main>
    {{-- <footer>
        <div>&copy; {{date('Y')}}, Bluefield Clinic. All rights reserved.</div>
    </footer> --}}
</body>
<script>
    // window.addEventListener('load', (ev) => {
    //     let path = "url('/public/public_pics/pic_"+{{$random}}+".jpg')";
    //     let image = document.querySelector('.login-form').style.backgroundImage;
    //     console.log(path, 'image is:'+image);
    //     // document.querySelector('.login-form').style.backgroundColor = 'pink';
    //     // image = "url(/public/public_pics/pic_2.jpg)";
    // });
</script>
</html>
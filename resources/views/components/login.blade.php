<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{$title}}</title>
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
    {{$slot}}
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
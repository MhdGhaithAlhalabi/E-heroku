<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-menu</title>
<!-- BOOTSTRAP -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"> </script>
</head>
<body>
        <div>

 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="180" height="49.9071" viewBox="2.7665583522929467 1.146343352292952 180 49.9071" xml:space="preserve">
     <g transform="matrix(0.98 0 0 0.98 92.77 26.1)" style="" id="BBK5x3EaNMPW0koowuW9Z">
             <text xml:space="preserve" font-family="Open Sans" font-size="51" font-style="italic" font-weight="800" line-height="1" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(215,13,13); fill-rule: nonzero; opacity: 1; white-space: pre;"><tspan x="-91.5" y="19.84">E menu</tspan></text>
     </g>
     </svg>
</div>


@if (Route::has('login'))
<div class="container">
@auth
<a href="{{ url('/home') }}">Home</a>

@else
<a href="{{ route('login') }}" >Log in</a>
<br>

@if (Route::has('register'))
 <a href="{{ route('register') }}" >Register</a>
@endif
@endauth
</div>
@endif
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>

@include('top')

<body id="page-top">

<div id="wrapper">
    @include('left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            @include('header')
            @yield('content')
            @include('footer')
        </div>
    </div>
</div>

@include('script.script1')

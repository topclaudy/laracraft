<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/laracraft/favicon.ico') }}">

    <title>Laracraft</title>

    <!-- Style sheets-->
    <link href="{{ asset(mix('app.css', 'vendor/laracraft')) }}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="laracraft" class="flex flex-wrap w-full" v-cloak>
    {{-- Main navigation --}}
    <nav class="nav-bar @yield('nav-bar-class')">
        <a href="{{ route('laracraft') }}" class="brand flex items-center flex-no-shrink text-primary mr-6 font-semibold text-xl tracking-tight">
            {{--<img src="/img/logo.svg?v=5" width="46" alt="TiMonnen Logo" class="align-bottom"/>--}}
            <span class="font-semibold black align-text-top">Laracraft</span>
        </a>
    </nav>

    @section('toolbar')
        <div class="toolbar" :class="{'closed': !$toolbarVisible}">
            <div class="hamburger-toggle bg-transparent toolbar-item border-0 p-0 mb-6" @click="$toggleToolbar">
                <div class="hamburger hamburger--elastic p-0 pt-1" :class="{'is-active': $toolbarVisible}" >
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </div>

            <div class="content">
                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Themes
                    </div>
                    <router-link to="/themes" class="toolbar-item">@svg('resources.vendor.laracraft.icons.layout', 'icon')</router-link>
                </el-tooltip>

                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Blocks
                    </div>
                    <router-link to="/blocks" class="toolbar-item">@svg('resources.vendor.laracraft.icons.grid', 'icon')</router-link>
                </el-tooltip>

                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Components
                    </div>
                    <router-link to="/components" class="toolbar-item">@svg('resources.vendor.laracraft.icons.package', 'icon')</router-link>
                </el-tooltip>
            </div>
        </div>
    @show



    <div class="content-wrapper @yield('content-wrapper-classes')">
        <router-view></router-view>
    </div>

    @section('footer')
        <footer>
            <span class="mr-1">Laracraft © 2018-{{ date('Y') }}. Crafted with love by </span><a href="http://www.awobaz.com" target="_blank">Awobaz Technologies Inc.</a>
        </footer>
    @show

    <portal-target name="dialogs"></portal-target>
</div>

<!-- Global Laracraft Object -->
<script>
    window.Laracraft = @json($laracraftScriptVariables);
</script>

@routes
<script src="{{asset(mix('app.js', 'vendor/laracraft'))}}"></script>

</body>
</html>

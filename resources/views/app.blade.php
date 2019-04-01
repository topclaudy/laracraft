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

            <div class="content w-full">
                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Themes
                    </div>
                    <router-link to="/themes" class="toolbar-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    </router-link>
                </el-tooltip>

                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Blocks
                    </div>
                    <router-link to="/blocks" class="toolbar-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </router-link>
                </el-tooltip>

                <el-tooltip placement="right" effect="dark" class="my-2">
                    <div slot="content">
                        Components
                    </div>
                    <router-link to="/components" class="toolbar-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"></path><polyline points="2.32 6.16 12 11 21.68 6.16"></polyline><line x1="12" y1="22.76" x2="12" y2="11"></line><line x1="7" y1="3.5" x2="17" y2="8.5"></line></svg>
                    </router-link>
                </el-tooltip>
            </div>
        </div>
    @show



    <div class="content-wrapper @yield('content-wrapper-classes')">
        <router-view></router-view>
    </div>

    @section('footer')
        <footer class="text-grey-dark">
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

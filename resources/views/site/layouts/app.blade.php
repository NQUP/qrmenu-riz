<!DOCTYPE html>
<html lang="id">
@include('site.layouts.head')

<body class="bg-slate-50 text-slate-900">
    <div id="webcrumbs">
        <div class="min-h-screen font-sans relative text-slate-900 bg-[radial-gradient(circle_at_top,_rgba(14,116,144,0.08),_transparent_45%),radial-gradient(circle_at_bottom,_rgba(245,158,11,0.10),_transparent_50%)]">
            @include('site.layouts.header')
            <main class="w-full px-4 pb-20 md:px-6">
                @yield('content')
            </main>
            @include('site.layouts.footer')
        </div>
    </div>
    @include('site.layouts.script')

</body>
</html>

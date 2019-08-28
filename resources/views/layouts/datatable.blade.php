
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">@yield('cardTitle')</h2>
                    @hasSection('buttons')
                        <div class="ml-auto" id="headerButtons">
                            @yield('buttons')
                        </div>
                    @endif
                </div>
            </header>
            @include('partials.errors')


            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    @yield('th')
                </thead>
                <tbody>
                    @yield('tb')
                </tbody>
            </table>
        </div>
    </section>



<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin">
                <img src="{{ asset('images/logos/ggfg_symbol_red.png') }}" alt="logo" width="35px"/>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/admin">Home</a></li>
                <li><a href="/admin/articles">Articles</a></li>
                <li><a href="/admin/issues">Issues</a></li>
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >Gift Lists <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/recommendations/requests">New Requests</a></li>
                        <li><a href="/admin/giftlists">Current Lists</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >Tags and Stuff <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/tags/manager">Tag Manager</a></li>
                        <li><a href="/admin/tags/issues">Tagging and Product Issues</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a target="_blank" href="/">View Site</a></li>
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >{{ Auth::user()->email }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="/admin/logout" method="POST">
                                {!! csrf_field() !!}
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
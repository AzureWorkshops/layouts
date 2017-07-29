    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-md-offset-1">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= $params['base_page'] . $params['index']->getUri(); ?>"><?= $params['title']; ?></a>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <!--
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

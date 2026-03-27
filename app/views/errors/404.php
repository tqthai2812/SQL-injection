<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page") ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center py-3 px-1">
                <h1>Page Not Found</h1>
                <div class="text-muted my-3">
                    Sorry, an error has occured.
                    The page you requested could not be found.
                </div>
                <div class="my-1">
                    <a href="/" class="btn btn-primary btn-lg me-1">
                        <i class="fa fa-home"></i> Take Me Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->stop() ?>
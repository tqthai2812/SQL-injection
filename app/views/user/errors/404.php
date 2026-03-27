<?php $this->layout("layouts/default", ["title" => "Page Not Found"]) ?>

<?php $this->start("page") ?>
<div class="container text-center py-5">
    <h1 class="display-1 text-danger">404</h1>
    <h2 class="mb-4">Page Not Found</h2>
    <p class="lead">Sorry, the page you are looking for could not be found.</p>
    <a href="/" class="btn btn-primary">Go to Homepage</a>
</div>
<?php $this->stop() ?>

<!doctype html>
<html lang="en" ng-app="monuments">
<head>
    <meta charset="UTF-8">
    <title>Monuments</title>
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/bower_components/angular-growl/build/angular-growl.min.css">
    <link rel="stylesheet" href="/bower_components/angular/angular-csp.css">
    <link rel="stylesheet" href="/app.css">
    <script src="/bower_components/jquery/jquery.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/bower_components/angular/angular.js"></script>
    <script src="/bower_components/angular-route/angular-route.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.js"></script>
    <script src="/bower_components/angular-growl/build/angular-growl.js"></script>
    <script src="/monuments/monuments.js"></script>
    <script src="/monuments/monumentsCtrl.js"></script>
    <script src="/monuments/monumentsSessionSvc.js"></script>
    <script src="/monuments/monumentsAuthSvc.js"></script>
    <script src="/monuments/login/login.js"></script>
    <script src="/monuments/login/loginCtrl.js"></script>
    <script src="/monuments/collections/collections.js"></script>
    <script src="/monuments/collections/collectionsSvc.js"></script>
    <script src="/monuments/collections/collectionsCtrl.js"></script>
    <script src="/monuments/monuments/monuments.js"></script>
    <script src="/monuments/monuments/monumentsSvc.js"></script>
    <script src="/monuments/monuments/monumentsCtrl.js"></script>
    <script src="/monuments/pictures/pictures.js"></script>
    <script src="/monuments/pictures/picturesSvc.js"></script>
    <script src="/monuments/pictures/picturesCtrl.js"></script>
    <script src="/monuments/pictures/picturesFileReaderDir.js"></script>
    <script src="/monuments/search/search.js"></script>
    <script src="/monuments/search/searchSvc.js"></script>
    <script src="/monuments/search/searchCtrl.js"></script>
    <script>
        angular.module("monuments").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
    </script>
</head>
<body ng-controller="monumentsCtrl">

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Monuments</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" ng-show="isLoggedIn">
                <li><a href="/collections">Collections</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" ng-show="isLoggedIn">
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="searchQuery" placeholder="Search monuments">
                </div>
                <button type="submit" class="btn btn-default" ng-click="submitSearch()">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li ng-show="isLoggedIn"><a ng-click="logout()" href="">Log Out</a></li>
                <li ng-hide="isLoggedIn"><a href="/login">Log In</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" ng-hide="isSearch()">
                <li><a href="/">Home</a></li>
                <li class="active" ng-hide="currentCollection">Collections</li>
                <li ng-show="currentCollection"><a href="/collections/{{currentCollection.id}}/monuments">{{currentCollection.name}}</a></li>
                <li class="active" ng-show="currentCollection && !currentMonument">Monuments</li>
                <li ng-show="currentCollection && currentMonument"><a href="/collections/{{currentCollection.id}}/monuments/{{currentMonument.id}}/pictures">{{currentMonument.name}}</a></li>
                <li class="active" ng-show="currentCollection && currentMonument">Pictures</li>
            </ol>
            <img src="/img/ajax-loader.gif" class="pull-right" ng-show="loading" />
            <div id="view" ng-view></div>
        </div>
    </div>
</div>

<div growl></div>
</body>
</html>

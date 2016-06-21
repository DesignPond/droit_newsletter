<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="<?php echo e(csrf_token()); ?>">
    <title>Newsletter</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <?php if(isset($isNewsletter)): ?>
        <link rel="stylesheet" href="<?php echo asset('newsletter/css/backend/newsletter.css'); ?>">
        <link rel="stylesheet" href="<?php echo asset('newsletter/css/frontend/newsletter.css'); ?>">
        <?php if(isset($campagne)): ?>
            <style type="text/css">
                #StyleNewsletter h2, #StyleNewsletterCreate h2{
                    color: <?php echo e($campagne->newsletter->color); ?>;
                }
                #StyleNewsletter .contentForm h3,
                #StyleNewsletter .contentForm h4,
                #StyleNewsletterCreate .contentForm h3,
                #StyleNewsletterCreate .contentForm h4
                {
                    color: <?php echo e($campagne->newsletter->color); ?>;
                }
            </style>
        <?php endif; ?>
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="<?php echo asset('js/redactor/redactor.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('js/redactor/alignment.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/jquery-ui.min.css');?>">

</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">Laravel</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="<?php echo e(url('/home')); ?>">Home</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php if(Auth::guest()): ?>
                    <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                    <li><a href="<?php echo e(url('/register')); ?>">Register</a></li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo e(Auth::user()->name); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <!-- messages and errors -->
    <?php echo $__env->make('newsletter::Backend.partials.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.js"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/redactor.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/fr.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/source.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/imagemanager.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/filemanager.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/alignment.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('js/redactor/iconic.js');?>"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<?php if(isset($isNewsletter)): ?>
    <?php echo $__env->make('newsletter::Backend.build.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

</body>
</html>

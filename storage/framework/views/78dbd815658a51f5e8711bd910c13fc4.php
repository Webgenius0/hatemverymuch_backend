<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title><?php echo e(config('app.name', 'Admin')); ?> | Admin Login </title>

    <meta name="author" content="themesflat.com">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/animate.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/animation.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>">



    <!-- Font -->
    <link rel="stylesheet" href="<?php echo e(asset('font/fonts.css')); ?>">

    <!-- Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('icon/style.css')); ?>">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo e(asset('images/favicon.png')); ?>">

</head>

<body class="body">

<!-- #wrapper -->
<div id="wrapper">
    <!-- #page -->
    <div id="page" class="">
        <div class="wrap-login-page">
            <div class="flex-grow flex flex-column justify-center gap30">
                <a href="<?php echo e(asset('index.html')); ?>" id="site-logo-inner">

                </a>
                <div class="login-box">
                    <div>
                        <h3>Login to account</h3>
                        <div class="body-text">Enter your email & password to login</div>
                    </div>

                    <form class="form-login flex flex-column gap24" method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>

                        <fieldset class="email">
                            <div class="body-title mb-10">Email address <span class="tf-color-1">*</span></div>
                            <input id="email" class="flex-grow <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email" placeholder="Enter your email address" name="email" tabindex="0" value="<?php echo e(old('email')); ?>" aria-required="true" required autocomplete="email" autofocus>

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        </fieldset>
                        <fieldset class="password">
                            <div class="body-title mb-10">Password <span class="tf-color-1">*</span></div>
                            <input id="password" class="password-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" placeholder="Enter your password" name="password" tabindex="0" value="" aria-required="true" required autocomplete="current-password">
                            <span class="show-pass">
                                    <i class="icon-eye view"></i>
                                    <i class="icon-eye-off hide"></i>
                                </span>

                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </fieldset>
                        <div class="flex justify-between items-center">
                            <div class="flex gap10">
                                <input class="" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                <label class="body-text" for="signed">Keep me signed in</label>
                            </div>
                        </div>
                        <button type="submit" class="tf-button w-full">Login</button>

                    </form>

                </div>
            </div>
            <div class="text-tiny">Copyright © 2024 SMUTLY, All rights reserved.</div>
        </div>
    </div>
    <!-- /#page -->
</div>
<!-- /#wrapper -->

<!-- Javascript -->
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>

</body>

</html>
<?php /**PATH C:\Users\Ridoan\SoftVence-Projects\wp_monkey\smutly-hatemverymuch_backend\resources\views/auth/login.blade.php ENDPATH**/ ?>
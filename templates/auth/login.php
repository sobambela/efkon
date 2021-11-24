<?php
require_once __DIR__.'/../includes/header.php';
?>
    <section class="wrapper">
        <form class="form-signin" id="login-form" name="registration" method="post" action="/login">
            <h2 class="form-signin-heading">sign in now</h2>
            <div class="login-wrap">
                <?php if(isset($invalid) && $invalid === true){  ?>
                <label for="password" class="col-lg-12 center-text login-response error" >Invalid Credentials</label>
                <?php }  ?>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <input type="hidden" name="redirect" id="redirect">
                <label class="checkbox">
                    <span class="pull-right">
                        <a data-toggle="modal" href="/password_reset"> Forgot Password?</a>
                    </span>
                </label>
                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <img src="img/ajax-loader-2.gif" class="loader" style="display:none;margin-top: -4px;margin-right: 9px;" />
                    Sign in
                </button>
                <div class="registration">
                    Don't have an account yet?
                    <a class="register" href="/register">
                        Create an account
                    </a>
                </div>
            </div>
        </form>
    </section>
<?php
require_once  __DIR__.'/../includes/header.php';
<?php
require_once  __DIR__.'/../includes/header.php';
?>
<section class="wrapper" id="reset-app">
    <form class="form-signin" id="login-form" style="margin: 11% auto 0;">
        <h2 class="form-signin-heading">Forgot Password?</h2>
        <div class="login-wrap">
            <label class="col-lg-12 center-text login-response success" v-if="updateSuccess == true" >{{ responseMessage }}</label>
            <label class="col-lg-12 center-text login-response error" v-if="updateSuccess == false">{{ responseMessage }}</label>
            <label for="email" class="col-lg-12 center-text login-response" v-if="step == 1">Enter email below to reset your password.</label>
            <input type="text" name="email" id="email" class="form-control" v-if="step == 1" placeholder="Email" v-model="email" autofocus>
            <label for="reset-code" class="col-lg-12 center-text login-response" v-if="step == 2">Enter Reset Code.</label>
            <input type="text" name="reset-code" id="reset-code" class="form-control"  v-if="step == 2" placeholder="Reset Code" v-model="resetCode" autofocus>
            <label for="password" class="col-lg-12 center-text login-response" v-if="step == 3">Enter New Password.</label>
            <input type="password" name="email" id="email" class="form-control"  v-if="step == 3" placeholder="New Password" v-model="password" autofocus>
            <input type="hidden" name="redirect" id="redirect">
            <button class="btn btn-lg btn-login btn-block" type="submit">
                <img src="img/ajax-loader-2.gif" class="loader" v-if="loading" />
                Reset Password
            </button>
            <div class="registration">
                Don't have an account yet?
                <a class="" href="/register">
                    Create an account
                </a>
            </div>
        </div>
    </form>
</section>
<?php
require_once __DIR__.'/../includes/footer.php';
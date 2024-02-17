<!DOCTYPE html>
<html>

@include('includes.head')

@section('title', 'Login')
<center>

    <body style="background-image: url('/path/to/background-image.jpg');">

        <div class="loginColumns animated fadeInDown">

            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username"
                                required="">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordField" name="password" placeholder="Password" required="">
                                <span class="input-group-append"> <button type="button" id="togglePasswordButton" class="btn btn-primary"><i class="fa fa-eye icon-eye"></i></button></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        <a href="password/reset">
                            <small>Forgot password?</small>
                        </a>

                        <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="/register">Sign Up</a>
                    </form>
                </div>
            </div>
        </div>
</center>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
      var passwordField = document.getElementById("passwordField");
      var togglePasswordButton = document.getElementById("togglePasswordButton");
    
      togglePasswordButton.addEventListener("click", function() {
        var currentType = passwordField.getAttribute("type");
    
        var newType = currentType === "password" ? "text" : "password";
    
        passwordField.setAttribute("type", newType);
      });
    });
</script>

</html>

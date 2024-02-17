<!DOCTYPE html>
<html>

@include('includes.head')

@section('title', 'Register')
<center>

    <body style="background-image: url('/path/to/background-image.jpg');">

        <div class="loginColumns animated fadeInDown">

            <div class="col-md-6">
                <div class="ibox-content">
                    <h2>Register @if(request()->path() == 'register-driver') Driver @endif</h2>
                    @if(Session::has('alert'))
                        <div class="alert alert-success">
                            {{ Session::get('alert') }}
                            @php
                            Session::forget('alert');
                        @endphp
                    </div>
                    @endif
                    <form class="m-t" role="form" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username"
                                required="">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="email"
                                required="">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordField" name="password" placeholder="Password" required="">
                                <span class="input-group-append"> <button type="button" id="togglePasswordButton" class="btn btn-primary"><i class="fa fa-eye"></i></button></span>
                            </div>
                        </div>
                        @if(request()->path() != 'register-driver')
                            <div class="form-group">
                                <div class="d-flex justify-content-start">
                                    <input type="checkbox" id="seller" name="is_seller" value="true">
                                    <label for="seller" class="mb-0 ml-2"> Register as seller</label><br>
                                </div>
                            </div>
                        @endif
                        @if(request()->path() == 'register-driver')
                        <input type="hidden" name="is_driver" value="true">
                        @endif
                        <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                        <a href="password/reset">
                            <small>Forgot password?</small>
                        </a>

                        <p class="text-muted text-center">
                            <small>Have an account?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="/login">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
        <hr />
</center>
</div>
</div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      var passwordField = document.getElementById("passwordField");
      var togglePasswordButton = document.getElementById("togglePasswordButton");
    
      togglePasswordButton.addEventListener("click", function() {
        // Check the current type attribute
        var currentType = passwordField.getAttribute("type");
    
        // Toggle between "password" and "text"
        var newType = currentType === "password" ? "text" : "password";
    
        // Set the new type attribute
        passwordField.setAttribute("type", newType);
      });
    });
</script>

</html>

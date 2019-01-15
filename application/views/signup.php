
<div class="title text-center">
    <h1>Registration on the site</h1>
</div>
<div class="row justify-content-md-center">
    <div class="table-container col-5 ">
        <form  method="POST" id="user-form">
            <div class="form-group">
                <label for="exampleInputUsername">Username</label>
                <input type="text" name="Signup[username]" class="form-control" id="exampleInputUsername" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="Signup[password]" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Confirm your password</label>
                <input type="password" name="Signup[confirmPassword]" class="form-control" id="confirmPassword" placeholder="Confirm password">
            </div>
            <div id="error" class="text-center text-danger">

            </div>
            <button type="submit" class="btn btn-success">Signup</button>
            <a href="/site/login" class="btn  btn-primary">Login</a>
        </form>
    </div>
</div>

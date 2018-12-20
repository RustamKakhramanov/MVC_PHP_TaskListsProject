<div class="title text-center">
    <h1>Login on the site</h1>
</div>
<div class="row justify-content-md-center">
    <div class="table-container col-5 ">
        <form  method="POST" id="user-form">
            <div class="form-group">
                <label for="exampleInputUsername">Username</label>
                <input type="text" name="Login[username]" class="form-control" id="exampleInputUsername" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="Login[password]" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div id="error" class="text-center text-danger">
            </div>
            <button type="submit" class="btn btn-success">Login</button>
            <a href="/site/signup" class="btn  btn-primary">Signup</a>
        </form>
    </div>
</div>
<script type="text/javascript" src="/assets/js/main.js"></script>
<label style="color:lightgray;">Enter your Login Details
<i style="color:red">required</i> : </label><br>
<div>
<input class="login" required id="email" type="email" autocomplete="username" name="email" placeholder="Email">
<input class="login" required autocomplete="current-password" id="password" type="password" name="password" placeholder="Password"><br>
<input class="login" id="remember" type="checkbox" name="remember"> Remember Me<br>
<button onclick="pipes(this)" ajax="verify.php" headers="method:POST" form-class="login">Login</button><br></div>
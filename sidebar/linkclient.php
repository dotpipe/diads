<div>
	<label style="color:lightgray;">Enter your Store contact information 
	<input class="business-form" id="manager" type="text" name="manager" placeholder="Manager Name" value="' . $_COOKIE['myname'] . '"><br>
	<input class="business-form" id="email" type="email" name="email" placeholder="Manager Email" value="' . $_COOKIE['myemail'] . '"><br>
	<input class="business-form" id="password" type="password" name="password" placeholder="Store Password"><br>
	<input class="business-form" id="addr" style="background:white" name="address" type="text" placeholder="Address"><br>
	<input class="business-form" id="ph" style="background:white" name="phone" type="text" placeholder="Phone Number"><br>
	<input class="business-form" id="biz" type="text" name="business" placeholder="Business Name"><br>
	<input class="business-form" id="no" style="background:white" name="store_no" type="text" placeholder="Store Number"><br>
	<input class="business-form" id="city" style="background:white" name="city" type="text" placeholder="City"><br>
	<input class="business-form" id="state" style="background:white" name="state" type="text" placeholder="State"><br>
	<input class="business-form" id="zip" style="background:white" name="zip" type="text" placeholder="Zip Code"><br>
	<div id="keywrds" style="display:table;width:255px;border-radius:10px;background:white">
	<input id="insWrd" onfocus="this.style.border=0px;" onkeyup="keywordLookup(this,event.keyCode);" style="display:table-cell;width:90%;color:black;border-radius:10px;border:0px;"></div>
	<div id="div-keys" style="display:table;width:75%"></div>
	<button onclick="pipes(this)" form-class="business-form" headers="method:POST" ajax="stores/link.php">List My Store!</button>
</div>
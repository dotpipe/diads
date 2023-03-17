<dyn style="font-size:16;color:red;">Preorder Items <?= echo $_COOKIE['store'] ?></dyn><br>

<input class="form-order" type="number" id="days" alt="Deliver In XX Days"><br>
<div id="preorders">
<input required type="text" class="form-order item" placeholder="Item name">
<h3 style="font-size:12px"> Qu: </h3><input id="qu" type="number" class="quantity" style="display:table-cell;width:24px;" value=1 min=0 required>
<button style="background:red;color:black;border-radius:50%;font-size:18px;border-right:1px solid white;" onclick="pipes(this)" form-class="remove">&times;</button>
</div>
<div style="width:100%;display:table">
<div style="width:50%;display:table-cell;text-align:left;margin-left:20px;"><button style="color:white:1px solid white;background:blue;border-radius:50%;font-size:18px" onclick="pipes(this)" form-class="form-order" onclick="addNewItem()">+</button></div>
<div style="width:50%;display:table-cell;text-align:right;margin-right:20px"><button style="background:black;color:green;border-radius:50%;font-size:18px;border:2px solid white;" onclick="pipes(this)" ajax="orders/preorder.php">&check;</button></div>
</div>
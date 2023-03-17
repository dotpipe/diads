<dyn style="font-size:16;color:red;">Preorder Items <?= $_COOKIE['store'] ?></dyn><br>

<label for="days"> Days Till Due:&nbsp;&nbsp;&nbsp; <input class="form-order" type="number" id="days"></label><br>
<div id="preorders">
<label for="days"> Product's Name: <input required type="text" class="form-order item">
<h3 style="font-size:12px"> Quantity: </h3><input id="qu" type="number" class="quantity" style="display:table-cell;width:100px;" value=1 min=0 required>
<button style="background:red;color:black;border-radius:50%;font-size:18px;border-right:1px solid white;" onclick="pipes(this)" form-class="remove">&times;</button>
</div>
<div style="width:100%;display:table">
<div style="width:50%;display:table-cell;text-align:left;margin-left:20px;"><button style="color:white:1px solid white;background:blue;border-radius:50%;font-size:18px" onclick="pipes(this)" form-class="form-order" onclick="addNewItem()">+</button></div>
<div style="width:50%;display:table-cell;text-align:right;margin-right:20px"><button style="background:black;color:green;border-radius:50%;font-size:18px;border:2px solid white;" onclick="pipes(this)" ajax="orders/preorder.php">&check;</button></div>
</div>
<table style="border:1px solid black;padding:3px;spacing:0px;width:250px;">
<tr><td><select id="chatters" onclick="listConvo()" onchange="getOption()" width="175"><option default value="" label="Click To see chats waiting"></select></td>
<td><button onclick="setConduct(this)" style="border-radius:50%;color:green">&check;</button></td></tr></table>
<div id="chatpane">
<table>
<tr><td><b id="contact" style="font-size:15px;color:red">Cheri</b> : : </td></tr>
<tr><td colspan=2 style="background:black;border:0px;height:300px;width:250px"><div id="in-window" style="border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:300px;width:250px">
</div></td></tr></table>
</div>
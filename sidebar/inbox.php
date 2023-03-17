<table style="border:1px solid black;padding:3px;spacing:0px;width:250px;height:300px">
<tr><td><b style="font-size:15px;color:red">Welcome to your Inbox!</b> : : <br><i style="font-size:10px;">Read who's coming in!</i></td>
<td><button onclick="clearChat();" style="vertical-alignment:bottom;border-radius:50%;color:green">&check;</button></td></tr>
<tr><td colspan=2 style="background:black;border:0px;height:300px;width:250px">
<div id="chatpane" style="border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;height:300px;width:250px">
<br><dyn onclick="getInbox('li')">Click here To Open Inbox</dyn><br>
<br><dyn onclick="getInbox('d',1)">Click here for Delivered</dyn><br>
<br><dyn onclick="getInbox('h',1)">Click here for On Hold</dyn><br>
<br><dyn onclick="getInbox('o',1)">Click here for Ordered</dyn><br>
<br><dyn onclick="getInbox('c',1)">Click here for Canceled</dyn><br>
</div></td></tr></table>
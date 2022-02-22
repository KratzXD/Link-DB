<!DOCTYPE html>
<html>
<body>

<table>
	<tr>
		<td>
			<select required id="combo" onchange="changeType()" name="file_type_id">
			<option value="" hidden >--/--</option>
			<option value="v">visible</option>
			<option value="h">hidden</option>
			</select>
		</td>
		<td>
			<div id="P">This text is going to change</div>
		</td>
		<td>
			<button type="button" onclick="click()" >Show text</button>
		</td>
	</tr>
</table>



<script>
function changeType() {
    var idType = document.getElementById("combo");
    var selectId = idType.value;
    
    if (selectId == "h"){
	  	//  document.getElementById("P").style.visibility = "hidden";
	  	document.getElementById("P") .innerHTML = "<div id='P'></div>"; 
    }else{
		// document.getElementById("P").style.visibility = "visible";
		document.getElementById("P") .innerHTML = "<div id='P'>This text is going to change</div>"; 
	}
}

function click() {
	document.getElementById("P").style.visibility = "visible";
}
</script>

</body>
</html>

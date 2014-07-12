<form method="post">
	<table>
		<th colspan="2">Please fill all fields</th>
		<tr>
			<td><label for="field1">First Name</label></td>
			<td><input type="text" maxlength="40" name="Name" id="field1" placeholder="eg. Fred" required value="<?php if(!empty($_POST['Name'])){htmlout($_POST['Name']);}?>" /></td>
		</tr>
		<tr>
			<td><label for="field2">Address</label></td>
			<td><textarea name="Address" maxlength="200" id="field2" placeholder="eg. 123 Fake St, Springfield" required><?php if(!empty($_POST['Address'])){htmlout($_POST['Address']);}?></textarea></td>
		</tr>
		<tr>
			<td><label for="field3">Email</label></td>
			<td><input type="email" maxlength="100" name="Email" id="field3" placeholder="Name@Sub-Domain.Domain" required value="<?php if(!empty($_POST['Email'])){htmlout($_POST['Email']);}?>"/></td>
		</tr>
		<tr>
			<td><label for="field4">Phone Number</label></td>
			<td><input type="tel" maxlength="14" name="Phone" id="field4" placeholder="## ### ####" required value="<?php if(!empty($_POST['Phone'])){htmlout($_POST['Phone']);}?>"/></td>
		</tr>
		<tr>
			<td><label for="field5">Birth Date</label></td>
			<td><input type="date" max="9999-12-31" name="Birthdate" id="field5" required value="<?php if(!empty($_POST['Birthdate'])){htmlout($_POST['Birthdate']);}?>"/></td>
		</tr>
		<tr>
			<td><label for="field6">Favourite Movie</label></td>
			<td>
				<select name="Movie" id="field6" required>
					<option value="" <?php if(empty($_POST['Movie'])){echo "selected";} ?> disabled>Select One</option>
					<?php foreach ($movies as $movie): ?>
					<option value="<?php echo "$movie"; ?>" <?php if($_POST['Movie'] == $movie){echo "selected";} ?>><?php echo "$movie"; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Gender</td>
			<td rowspan="<?php echo count($genders) ?>">
				<div>
					<input type="radio" value="Unspecified" name="Gender" id="field7" checked>
					<label for="field7">Unspecified</label>
				</div>
				<div>
					<input type="radio" value="Male" name="Gender" id="field8">
					<label for="field8">Male</label>
				</div>
				<div>
					<input value="Female" type="radio" name="Gender" id="field9">
					<label for="field9">Female</label>
				</div>
			</td>
		</tr>
	</table>
	<div class="center">
		<button name="submit">SUBMIT</button>
		<button type="reset">RESET</button>
		<a class="button" href="/">BACK</a>
	</div>
</form>
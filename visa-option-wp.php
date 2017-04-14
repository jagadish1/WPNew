
<?php
$country=$_POST['c'];
$prof=$_POST['p'];
if(isset($_POST['Submit1'])) {
        if(($_POST['c']!==" ") && ($_POST['p']!=="Select profession")){
		header("Location:work-visa-temporary-options/?".$country&$prof);
		}
?>


<form name="frm" action="Visa-Options.asp" method="post" onSubmit="return validateWorkVisa();">
<div class="va-c-cmbo va-c-cmbo-spacere">
					<div class="va-c-cmbo-txt">
						<p>I am a citizen of</p>
						<p><span>or</span></p>
						<p>I am hiring a citizen of</p> 
					</div>
					<div class="va-c-cmbo-box va-c-cmbo-box-padding">
				

						<input type="text" name="c" value="" placeholder="Enter Country"/>
					</div>
				</div>
				<div class="va-c-cmbo visa-down">
					<div class="va-c-cmbo-txt">
						<p>Working as a</p>
					</div>
					<div class="va-c-cmbo-box">
						<!--<select>
							<option> a </option>
						</select>-->
						<select name="p">
						
                                  <option selected>Select Profession</option>
                                  <option value="Accountant">Accountant</option>
                                  <option value="Actor">Actor</option>
                                  <option value="Agricultural Worker">Agricultural 
                                  Worker</option>
                                  <option value="Architect">Architect</option>
                                  <option value="Artist">Artist</option>
                                  <option value="Athlete">Athlete</option>
                                  <option value="Attorney">Attorney</option>
                                  <option value="Businessman">Businessman</option>
                                  <option value="Chef">Chef</option>
                                  <option value="Chemist">Chemist</option>
                                  <option value="Coach">Coach</option>
                                  <option value="Computer Professional">Computer 
                                  Professional</option>
                                  <option value="Cook">Cook</option>
                                  <option value="Dentist">Dentist</option>
                                  <option value="Dietitian">Dietitian</option>
                                  <option value="Doctor">Doctor</option>
                                  <option value="Economist">Economist</option>
                                  <option value="Engineer">Engineer</option>
                                  <option value="Entertainer">Entertainer</option>
                                  <option value="Entrepreneur">Entrepreneur</option>
                                  <option value="Exporter">Exporter</option>
                                  <option value="Fashion Model">Fashion Model</option>
                                  <option value="Football Coach">Football Coach</option>
                                  <option value="Graphic Designer ">Graphic Designer 
                                  </option>
                                  <option value="Hockey Instructor">Hockey Instructor</option>
                                  <option value="Hospitality Worker">Hospitality 
                                  Worker</option>
                                  <option value="Hotel Manager">Hotel Manager</option>
                                  <option value="Importer">Importer</option>
                                  <option value="Industrial Designer">Industrial 
                                  Designer</option>
                                  <option value="Interior Designer">Interior Designer</option>
                                  <option value="Investor">Investor</option>
                                  <option value="Journalist">Journalist</option>
                                  <option value="Lawyer">Lawyer</option>
                                  <option value="Laboratory Technologist">Laboratory 
                                  Technologist</option>
                                  <option value="Librarian">Librarian</option>
                                  <option value="Marketing Professional">Marketing 
                                  Professional</option>
                                  <option value="Management Consultant">Management 
                                  Consultant</option>
                                  <option value="Mathematician">Mathematician</option>
                                  <option value="Medical Doctor">Medical Doctor</option>
                                  <option value="Minister">Minister</option>
                                  <option value="Missionary">Missionary</option>
                                  <option value="Model">Model</option>
                                  <option value="Monk">Monk</option>
                                  <option value="Musician">Musician</option>
                                  <option value="News Editor">News Editor</option>
                                  <option value="Nun">Nun</option>
                                  <option value="Nurse">Nurse</option>
                                  <option value="Nutritionist">Nutritionist</option>
                                  <option value="Occupational Therapist">Occupational 
                                  Therapist</option>
                                  <option value="Pastor">Pastor</option>
                                  <option value="Pharmacist">Pharmacist</option>
                                  <option value="Physical Therapist">Physical 
                                  Therapist</option>
                                  <option value="Physician">Physician</option>
                                  <option value="Priest">Priest</option>
                                  <option value="Psychologist">Psychologist</option>
                                  <option value="Professor">Professor</option>
                                  <option value="Religious Worker">Religious Worker</option>
                                  <option value="Reporter">Reporter</option>
                                  <option value="Researcher">Researcher</option>
                                  <option value="Scientist">Scientist</option>
                                  <option value="Ski Instructor">Ski Instructor</option>
                                  <option value="Social Worker">Social Worker</option>
                                  <option value="Software Engineer">Software Engineer</option>
                                  <option value="Solicitor">Solicitor</option>
                                  <option value="Taxation Consultant">Taxation 
                                  Consultant</option>
                                  <option value="Teacher">Teacher</option>
                                  <option value="Trader">Trader</option>
                                  <option value="Veterinarian">Veterinarian</option>
                                </select>
					</div>
				</div>
				<input type="submit" value="Show My Options" name="Submit1" onClick="return validateWorkVisa();">
				</form>

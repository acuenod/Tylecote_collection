<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Tables</title>
<link rel="stylesheet" href="mystyle.css">
</head>

<script language="JavaScript">
//The toggle function enables to check all the tickboxes that have the same name at once
function toggle(source, name) {
  checkboxes = document.getElementsByName(name);
  for(var i in checkboxes)
    checkboxes[i].checked = source.checked;
}
//The validateForm function verifies that at least one object-related tickbox is checked
//And that at least one search term is entered. Otherwise dispalys an alert.
function validateForm()
{
    checkboxes = document.getElementsByName('object[]');
    var checked=false;
    for(var i in checkboxes)
    {   
        if(checkboxes[i].checked && !isNaN(i))
        {
            checked=true;
        }
    }
    if(!checked)
    {
        alert ("You must select at least one object-related information to be displayed!");
        return false;
    }
    text = document.getElementsByName('search_text[]');
    var has_text=false;
    for(var i in text)
    {   
        if(text[i].value!="" && !isNaN(i))
        {
            has_text=true;
        }
    }
    if(!has_text)
    {
        alert ("You must give at least one search term");
        return false;
    }
}
</script>

<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">
            <h1>Create a table</h1>
            
            This features enables you to search for items and chose the data to display.<br>
            It creates a table of data that can then be exported to an Excel document.<br>
            <br>
            This is an object based search, which means that you need to select at least one 'object-related' feature to be displayed.
            If you are simply after a list of samples or publications answering to certain search criteria please use a simple search.
            <br>
            
            <form method='post' action='tables_result.php'>
                
            <h3>1) Search for items to display.</h3>
            Search for:<br>
            <input type="text" name="search_text[]"> &nbsp; in &nbsp; <select name="search_field[]">
                                                                        <option value="All">All fields</option>
                                                                        <option value="Type">Object Type</option>
                                                                        <option value="Site">Site</option>
                                                                        <option value="Date">Date</option>
                                                                        <option value="Material">Material</option>
                                                                        <option value="Author">Author</option>
                                                                        </select><br>
            <br>
            <select name="operator[]">
            <option value="AND">AND</option>
            <option value="OR">OR</option>
            <option value="AND NOT">AND NOT</option>
            </select><br>
            <br>
            <input type="text" name="search_text[]"> &nbsp; in &nbsp; <select name="search_field[]">
                                                                        <option value="All">All fields</option>
                                                                        <option value="Type">Object Type</option>
                                                                        <option value="Site">Site</option>
                                                                        <option value="Date">Date</option>
                                                                        <option value="Material">Material</option>
                                                                        <option value="Author">Author</option>
                                                                        </select><br>
            <br>
            
            <select name="operator[]">
            <option value="AND">AND</option>
            <option value="OR">OR</option>
            <option value="AND NOT">AND NOT</option>
            </select><br>
            <br>
            <input type="text" name="search_text[]"> &nbsp; in &nbsp; <select name="search_field[]">
                                                                        <option value="All">All fields</option>
                                                                        <option value="Type">Object Type</option>
                                                                        <option value="Site">Site</option>
                                                                        <option value="Date">Date</option>
                                                                        <option value="Material">Material</option>
                                                                        <option value="Author">Author</option>
                                                                        </select><br>
            <br>
            
            <h3>2) Choose the table columns.</h3>
            
            <table  class='fiche'>
            <tr><th>Object related information</th><th><input type="checkbox" onClick="toggle(this, 'object[]')" /> Select All<br/></th></tr>
            <tr><td><input type='checkbox' name='object[]' value='Type' checked/>Object Type</td><td><input type='checkbox' name='object[]' value='Material' />Material</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Site' />Site</td><td><input type='checkbox' name='object[]' value='Date_strati' />Date stratigraphy</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Date_typo' />Date typology</td><td><input type='checkbox' name='object[]' value='Museum' />Museum</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Identification' />Identification no.</td><td><input type='checkbox' name='object[]' value='Image' />Image</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Weight' />Weight</td><td><input type='checkbox' name='object[]' value='Lenght' />Lenght</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Width' />Width</td><td><input type='checkbox' name='object[]' value='Thickness' />Thickness</td></tr>
            <tr><td><input type='checkbox' name='object[]' value='Base_diameter' />Base diameter</td><td><input type='checkbox' name='object[]' value='Max_diameter' />Max diameter</td></tr>
            </table>

            <br>

            <table class='fiche'>
            <tr><th>Sample related information</th><th><input type="checkbox" onClick="toggle(this, 'sample[]')" /> Select All<br/></th></tr>
            <tr><td><input type='checkbox' name='sample[]' value='Sample_type' />Sample Type</td><td><input type='checkbox' name='sample[]' value='Sample_nb' />Code</td></tr>
            <tr><td><input type='checkbox' name='sample[]' value='Collection' />Collection</td><td><input type='checkbox' name='sample[]' value='Location' />Location</td></tr>
            </table>

            <br>
            
            <table class='fiche'>
            <tr><th>Publication related information</th><th><input type="checkbox" onClick="toggle(this, 'publication[]')" /> Select All<br/></th></tr>
            <tr><td><input type='checkbox' name='publication[]' value='Author' />Author</td><td><input type='checkbox' name='publication[]' value='Title' />Title</td></tr>
            <tr><td><input type='checkbox' name='publication[]' value='Date' />Date</td><td><input type='checkbox' name='publication[]' value='Journal' />Journal</td></tr>
            <tr><td><input type='checkbox' name='publication[]' value='Volume' />Volume</td><td><input type='checkbox' name='publication[]' value='Issue' />Issue</td></tr>
            <tr><td><input type='checkbox' name='publication[]' value='Pages' />Pages</td><td></td></tr>
            </table>

            <br>

            <table class='fiche'>
            <tr><th>Metallography</th><th><input type="checkbox" onClick="toggle(this, 'metallography[]')" /> Select All<br/></th></tr>
            <tr><td><input type='checkbox' name='metallography[]' value='Object_part' />Object part</td><td><input type='checkbox' name='metallography[]' value='Technology' />Technology summary</td></tr>
            <tr><td><input type='checkbox' name='metallography[]' value='HV' />Hardness HV</td><td><input type='checkbox' name='metallography[]' value='HB' />Hardness HB</td></tr>
            <tr><td><input type='checkbox' name='metallography[]' value='Micrograph' />Micrograph image</td><td><input type='checkbox' name='metallography[]' value='Micrograph_features' />Micrograph features</td></tr>
            </table>

            <br>
            
            <table class='fiche'>
            <tr><th>Chemical composition</th><th><input type="checkbox" onClick="toggle(this, 'chemistry[]')" /> Select All<br/></th></tr>
            <tr><td><input type='checkbox' name='chemistry[]' value='Technique' />Analytical technique</td><td><input type='checkbox' name='chemistry[]' value='Elements_Cu' />List of standard elements for copper alloys</td></tr>
            <tr><td><input type='checkbox' name='chemistry[]' value='Elements_Fe' />List of standard elements for iron artefacts</td><td><input type='checkbox' name='chemistry[]' value='Oxides' />List of standard oxides</td></tr>
            </table>

            <br>

            <input type="submit" value="Create table" onclick="return validateForm()"/><br>
            <br>
            </div>

            </form>

        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 


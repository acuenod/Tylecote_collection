 <!-- If the the writer has forgotten to enter some text, an alert is displayed -->
<script language="JavaScript">
function validateSearch()
{
    var search_text=document.getElementById('search_text');
    if(search_text.value==null || search_text.value=="")
    {
        alert ("You must enter a search term!");
        return false;
    }
}
</script>

<div id="search">
    <form method="post" action="<?php echo $path?>search_results.php" enctype="multipart/form-data" class="search">
        Search: <input type="text" id="search_text" name="search_text"/>
        <input type="submit" value="Go" onclick="return validateSearch()"/>
    </form>
</div>
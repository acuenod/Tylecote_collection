<html>
<ul class="navbar">
    <?php
     //if(isset($_SESSION["access"]) && $_SESSION["access"]>0)
    //{
    
    //Links accessible to everyone
    echo'
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/index.php\'" class="navbar_normal" ><a href="/Tylecote_collection/index.php">Home</a>
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " class="navbar_normal">Search and export
    <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/search_page.php\' "; class="navbar_normal"><a href="/Tylecote_collection/search_page.php">Simple search</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/tables_choice.php\' "; class="navbar_normal"><a href="/Tylecote_collection/tables_choice.php">Advanced search and export</a>
      </ul>
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/browse_choice.php\' "; class="navbar_normal"><a href="/Tylecote_collection/browse_choice.php">Browse</a>
      <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/browse.php?class=object\' "; class="navbar_normal"><a href="/Tylecote_collection/browse.php?class=object">Objects</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/browse_choice.php?class=sample\' "; class="navbar_normal"><a href="/Tylecote_collection/browse_choice.php?class=sample">Samples</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/browse.php?class=publication\' "; class="navbar_normal"><a href="/Tylecote_collection/browse.php?class=publication">Publications</a>
      </ul>
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/resources_choice.php\' "; class="navbar_normal"><a href="/Tylecote_collection/resources_choice.php">Resources</a>
      <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/notebooks.php\' "; class="navbar_normal"><a href="/Tylecote_collection/notebooks.php">Notebooks</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/glossary.php\' "; class="navbar_normal"><a href="/Tylecote_collection/glossary.php">Glossary</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/links.php\' "; class="navbar_normal"><a href="/Tylecote_collection/links.php">Links</a>
      </ul>
        ';
    //}
    
    if(isset($_SESSION["access"]) && $_SESSION["access"]>1) //Links only accessible to writers and admins
    {
        echo'
        <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_choice.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_choice.php">Insert</a>
      <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_object.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_object.php">Object</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_sample.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_sample.php">Sample</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_publication.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_publication.php">Publication</a>
      </ul>
      <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/link_items.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/link_items.php">Link</a>
      ';
    }
    if(isset($_SESSION["access"]) && $_SESSION["access"]>2) //Links only acesssible to admins
    {
        echo'
        <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " class="navbar_normal">Management</a>
        <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/register_user.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/register_user.php">Users</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/thesauri.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/thesauri.php">Thesauri</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/edit_glossary.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/edit_glossary.php">Glossary</a>
        </ul>
        ';
    }
?>
 </ul>
</html> 
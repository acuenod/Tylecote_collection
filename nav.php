<html>
<div id='cssmenu'>
<ul>
<?php
/*
 * Pure CSS horizontal dropdown menu made using a template found on http://cssmenumaker.com/css-drop-down-menu
 */
     //if(isset($_SESSION["access"]) && $_SESSION["access"]>0)
    //{

    //Links accessible to everyone
    echo'
    <li><a href="/Tylecote_collection/index.php"><span>Home</span></a></li>
    <li class="has-sub"><a><span>Search and export</a></span>
        <ul>
            <li><a href="/Tylecote_collection/search_page.php"><span>Simple search</span></a></li>
            <li class="last"><a href="/Tylecote_collection/tables_choice.php"><span>Advanced search and export</span></a></li>
        </ul>
    </li>
    <li class="has-sub"><a href="/Tylecote_collection/browse_choice.php"><span>Browse</span></a>
        <ul>
            <li><a href="/Tylecote_collection/browse.php?class=object"><span>Objects</span></a></li>
            <li><a href="/Tylecote_collection/browse_choice.php?class=sample"><span>Samples</span></a></li>
            <li class="last"><a href="/Tylecote_collection/browse.php?class=publication"><span>Publications</span></a></li>
        </ul>
    </li>
    <li class="has-sub"><a href="/Tylecote_collection/resources_choice.php"><span>Resources</span></a>
        <ul>
            <li><a href="/Tylecote_collection/notebooks.php"><span>Notebooks</span></a></li>
            <li><a href="/Tylecote_collection/glossary.php"><span>Glossary</span></a></li>
            <li class="last"><a href="/Tylecote_collection/links.php"><span>Links</span></a></li>
        </ul>
    </li>
        ';
    //}
    
    if(isset($_SESSION["access"]) && $_SESSION["access"]>1) //Links only accessible to writers and admins
    {
        echo'
        <li class="has-sub"><a><span>Insert</span></a>
            <ul>
                <li><a href="/Tylecote_collection/writer/insert_object.php"><span>Object</span></a></li>
                <li><a href="/Tylecote_collection/writer/insert_sample.php"><span>Sample</span></a></li>
                <li class="last"><a href="/Tylecote_collection/writer/insert_publication.php"><span>Publication</span></a></li>
            </ul>
        </li>
        <li><a href="/Tylecote_collection/writer/link_items.php"><span>Link</span></a></li>
      ';
    }
    if(isset($_SESSION["access"]) && $_SESSION["access"]>2) //Links only acesssible to admins
    {
        echo'
        <li class="has-sub"><a><span>Management</span></a>
            <ul>
                <li><a href="/Tylecote_collection/admin/register_user.php"><span>Users</span></a></li>
                <li><a href="/Tylecote_collection/admin/thesauri.php"><span>Thesauri</span></a></li>
                <li class="last"><a href="/Tylecote_collection/admin/edit_glossary.php"><span>Glossary</span></a></li>
            </ul>
        </li>
        ';
    }
?>
</ul>
</div>
</html> 
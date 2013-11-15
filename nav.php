<html>
<ul class="navbar">
    <?php
     if(isset($_SESSION["access"]) && $_SESSION["access"]>0)
    {
    echo'
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/index.php\'" class="navbar_normal" ><a href="/Tylecote_collection/index.php">Home</a>
    <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/search_page.php\' "; class="navbar_normal"><a href="/Tylecote_collection/search_page.php">Search</a>
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
    }
    
    if(isset($_SESSION["access"]) && $_SESSION["access"]>1)
    {
        echo'
        <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_choice.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_choice.php">Insert new</a>
      <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_object.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_object.php">Object</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_sample.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_sample.php">Sample</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/insert_publication.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/insert_publication.php">Publication</a>
      </ul>
      <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/writer/link_items.php\' "; class="navbar_normal"><a href="/Tylecote_collection/writer/link_items.php">Link items</a>
      ';
    }
    if(isset($_SESSION["access"]) && $_SESSION["access"]>2)
    {
        echo'
        <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " class="navbar_normal">Management tools</a>
        <ul class="navbar">
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/register_user.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/register_user.php">Users</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/thesauri.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/thesauri.php">Thesauri</a>
            <li onmouseover="this.className=\'navbar_highlighted\' " onmouseout="this.className=\'navbar_normal\' " onclick="document.location.href =\'/Tylecote_collection/admin/edit_glossary.php\' "; class="navbar_normal"><a href="/Tylecote_collection/admin/edit_glossary.php">Glossary</a>
        </ul>
        ';
    }


?>
 <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='/Tylecote_collection/writer/add_group.php' "; class="navbar_normal"><a href="/Tylecote_collection/writer/add_group.php">Insert new group</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='research.html' "; class="navbar_normal"><a href="Research.html">Research</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='tables_choice.php' " class="navbar_normal"><a href="tables_choice.php">Tables</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='tables_saved.php' " class="navbar_normal"><a href="tables_saved.php">Saved tables</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='graphs_create.php' " class="navbar_normal"><a href="graphs_create.php">Create graphs</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='graphs_saved.php' " class="navbar_normal"><a href="graphs_saved.php">Saved graphs</a>-->
  <!-- onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='admin_types.php' " class="navbar_normal"><a href="admin_types.php">Admin of Types</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='admin_regions.php' " class="navbar_normal"><a href="admin_regions.php">Admin of Regions</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='admin_dates.php' " class="navbar_normal"><a href="admin_dates.php">Admin of Dates</a>-->
  <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='predefined_graph_choice.php' " class="navbar_normal"><a href="predefined_graph_choice.php">Graphs</a>-->
 <!-- <li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='table_of_publications.php' " class="navbar_normal"><a href="table_of_publications.php">Sources</a>-->
 <!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='table_of_methods.php' " class="navbar_normal"><a href="table_of_methods.php">Methods</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='patterns_choice.php' " class="navbar_normal"><a href="patterns_choice.php">Patterns</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='group_assignment.php' " class="navbar_normal"><a href="group_assignment.php">Assign  metal groups</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='cluster_choice.php' " class="navbar_normal"><a href="cluster_choice.php">Clusters</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='element_set.php' " class="navbar_normal"><a href="element_set.php">Element Set</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='method_comp_choice.php' " class="navbar_normal"><a href="method_comp_choice.php">Method Comparison</a>-->
<!--<li onmouseover="this.className='navbar_highlighted' " onmouseout="this.className='navbar_normal' " onclick="document.location.href ='summary.php' " class="navbar_normal"><a href="summary.php">Summary</a>-->
</ul>
</html> 
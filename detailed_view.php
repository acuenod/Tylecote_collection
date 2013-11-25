<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Detailed view</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">

            <?php 
            include 'functions/display_details.php'; 
            include 'functions/display_linked.php';

            $id=$_GET["id"];
            $class=$_GET["class"];
            $action=$_GET["action"];
            ?>

            <!-- Alert to confirm deletion if "Delete Item" button has been clicked in detailed_view.php -->
            <script language="JavaScript">
                function confirm_delete(id)
                {
                    var answer = confirm ("Are you sure you want to delete this item?")
                    if (answer)
                    return true;
                    else return false;
                }
            </script>

            <?php

            $db=db_connect();
            
            //Definition of the buttons for previous, next and back navigation
            
            /*If we come from search or browse
             * The previous and next buttons are defined within the results of the search or browse,
             * in the order befined by the user by clicking on the column headers
             * The back button goes back to the search and browse results
             */
            
            if(isset($_GET['interest']))
            {
                $class_nav=$_GET['interest'];
            }
            else $class_nav=$class;
            
            if($action!="link" && $action!="add" && $action!="modify" && $action!="tables")
            {
                //Definition of the previous and next id within a search result
                if(isset($_SESSION['search_results'][$class_nav]))
                {
                    foreach($_SESSION['search_results'][$class_nav] as $key => $id_value)
                    {
                        if ($id_value==$id)
                        {
                            if(isset($_SESSION['search_results'][$class_nav][$key-1]))
                                $previous_id=$_SESSION['search_results'][$class_nav][$key-1];
                            else $previous_id="start";
                            if(isset($_SESSION['search_results'][$class_nav][$key+1]))
                                $next_id=$_SESSION['search_results'][$class_nav][$key+1];
                            else $next_id="end";
                        }
                    }
                }
                
                //Beginning of the HTML for the buttons
                $previous="<input type='button' name='goto_previous' value='<  Previous item' onclick=self.location.href='detailed_view.php?id=".$previous_id."&class=".$class."&action=".$action;
                $next="<input type='button' name='goto_next' value='Next item >' onclick=self.location.href='detailed_view.php?id=".$next_id."&class=".$class."&action=".$action;
                $back="<a href=";
                
                //Definition of the "Back" button URL
                if($action=="browse")
                    $file="browse.php";
                elseif($action=="search")
                    $file="search_results.php";
                $back=$back.$file."?class=".$class."&action=".$action;

                //Adds all the info on the browse set we come from via GET
                if(isset($_GET['sort_column']))
                {
                    $previous=$previous."&sort_column=".$_GET['sort_column'];
                    $next=$next."&sort_column=".$_GET['sort_column'];
                    $back=$back."&sort_column=".$_GET['sort_column'];
                }
                if(isset($_GET['order']))
                {
                    $previous=$previous."&order=".$_GET['order'];
                    $next=$next."&order=".$_GET['order'];
                    $back=$back."&order=".$_GET['order'];
                }
                if(isset($_GET['collection']) && isset($_GET['drawer']))
                {
                    $previous=$previous."&collection=".$_GET['collection']."&drawer=".$_GET['drawer'];
                    $next=$next."&collection=".$_GET['collection']."&drawer=".$_GET['drawer'];
                    $back=$back."&collection=".$_GET['collection']."&drawer=".$_GET['drawer'];
                }
                if(isset($_GET['page']))
                {
                    $previous=$previous."&page=".$_GET['page'];
                    $next=$next."&page=".$_GET['page'];
                    $back=$back."&page=".$_GET['page'];
                }
                if(isset($_GET['search_text']))
                {
                    $previous=$previous."&search_text=".$_GET['search_text'];
                    $next=$next."&search_text=".$_GET['search_text'];
                    $back=$back."&search_text=".$_GET['search_text'];
                }
                if(isset($_GET['interest']))
                {
                    $previous=$previous."&interest=".$_GET['interest'];
                    $next=$next."&interest=".$_GET['interest'];
                    $back=$back."&interest=".$_GET['interest'];
                }
                
                //End of the html for the buttons
                $previous=$previous."'>";
                $next=$next."'>";
                $back=$back.">< Back to ".$action." results</a>";
                
                //If we are on the first or last item of a set, "Previous" resp "Next, is not displayed
                if($previous_id!="start")
                {
                    $previous=$previous;
                }
                else $previous='';
                if($next_id!="end")
                {
                    $next=$next;
                }
                else $next='';
            }
            
            /*If we come from link or tables no previous or next buttons are displayed.
             * Back is defined by the history of the browser. 
             */
            elseif($action=="link" || $action=="tables")
            {
                $previous='';
                $next='';
                $back="<a href= 'javascript:history.go(-1)'>< Back </a>";
            }
            
            /*If we come from add or modify
             *The previous and next buttons refer to the previous and next items in ID order in the entire db.
             *There is no Back button
             */
            else
            {
                //Definition of the previous id in the database, skipping deleted records
                $previous_id=$id-1;
                $sql = "SELECT Is_deleted FROM ".$class." WHERE ID=".$previous_id;
                $result = db_query($db, $sql);
                $deleted = db_fetch_assoc($result);
                while($deleted['Is_deleted']==1)
                {
                    $previous_id=$previous_id-1;
                    $sql = "SELECT Is_deleted FROM ".$class." WHERE ID=".$previous_id;
                    $result = db_query($db, $sql);
                    $deleted = mysql_fetch_assoc($result);
                }
                
                //Definition of the next id in teh database, skipping deleted record
                $next_id=$id+1;
                $sql = "SELECT Is_deleted FROM ".$class." WHERE ID=".$next_id;
                $result = db_query($db, $sql);
                $deleted = db_fetch_assoc($result);
                while($deleted['Is_deleted']==1)
                {
                    $next_id=$next_id+1;
                    $sql = "SELECT Is_deleted FROM ".$class." WHERE ID=".$next_id;
                    $result = db_query($db, $sql);
                    $deleted = mysql_fetch_assoc($result);
                }
                
                //Definition of the html for the buttons
                $previous="<input type='button' name='goto_previous' value='<  Previous item' onclick=self.location.href='detailed_view.php?id=".$previous_id."&class=".$class."&action=".$action."'>";
                $next="<input type='button' name='goto_next' value='Next item >' onclick=self.location.href='detailed_view.php?id=".$next_id."&class=".$class."&action=".$action."'>";
                $back='';
            }   
            ?>
            
            <!--Displays the navigation buttons-->
            <div id="navigation">
                <?php
               echo $previous;
               echo $next;
               ?>     
               <div id="go_back">
                   <?php echo $back ?>
                </div>
            </div>

            <?php
            /*Objects are displayed in a three tabs format: 
             * Description (shows info located in the object table)
             * Metallography (also shows the micrographs)
             * Chemistry
             */
            if ($class=="object")
            {
                echo'<div id="tabContainer">
                <div class="tabs">
                  <ul>
                    <li id="tabHeader_1">Description</li>
                    <li id="tabHeader_2">Metallography</li>
                    <li id="tabHeader_3">Chemistry</li>
                  </ul>
                </div>
                <div class="tabscontent">
                  <div class="tabpage" id="tabpage_1">
                    <h3>Object Description</h3>';
                    display_details($id, $class);
                  echo'</div>
                  <div class="tabpage" id="tabpage_2">
                    <h3>Metallography</h3>';
                    display_details($id, "metallography");
                  echo'</div>
                  <div class="tabpage" id="tabpage_3">
                    <h3>Chemistry</h3>';
                    display_details($id, "chemistry");
                  echo'</div>
                </div>
                </div>
                <script src="functions/tabs.js"></script>';
            }
            
            //Samples and Publications do not have multiple tabs
            else
            {
                display_details($id, $class);
            }

            //Diplays the linked samples, objects or publications
            display_linked($id, $class, false, 0, 0);
            
            //Displays the Add, Modify and Delete buttons if the user is at least a writer (access>1)
            echo '<br><br>';
            if(isset($_SESSION['access']) && $_SESSION['access']>1)
            {
                echo "<input type='button' name='goto_modify' value='Modify this item' onclick='self.location.href=\"writer/modify.php?id=".$id."&class=".$class."\"'><br><br>";

                echo"<form method='post' enctype='multipart/form-data' class='form' action ='writer/delete.php?id=".$id." &class=".$class."' onsubmit='return confirm_delete(".$id.")'>";
                echo"<input type='submit' value='Delete this item from database''/>";
                echo"</form>";

                if($class=="object" )
                {
                    echo "<input type='button' name='add_metallo' value='Add metallography for this object' onclick='self.location.href=\"writer/insert_metallography.php?id=".$id."\"'><br><br>";
                    echo "<input type='button' name='add_chemistry' value='Add chemistry for this object' onclick='self.location.href=\"writer/insert_chemistry.php?id=".$id."\"'><br><br>";
                    echo "<input type='button' name='add_sample' value='Add related sample' onclick='self.location.href=\"writer/insert_sample.php?id_object=".$id."\"'><br><br>";
                }
                if($class=="sample")
                {
                        echo "<input type='button' name='add_object' value='Add related object' onclick='self.location.href=\"writer/insert_object.php?id_sample=".$id."\"'><br><br>";
                }
            }
            
            ?>

        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 
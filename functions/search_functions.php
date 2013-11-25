<?php

/*Search_related terms ($search_text (string))
 * For each one of the entered terms it finds the preferred term (PT) if there is one, 
 * it then finds the narrower terms (NT) for both the original string and the PT and then the NTs of the NTs, etc. until we reach the leaves of the tree
 * it then finds the related terms (RT) for both the original search and its PT
 * If $search_text after cleaning and allowing for plurals/spellings is of the form word1 word2 the function returns the array:
 * Array([word1 word2]=>Array([0]=> word1 word2) 
 *      [word1]=>Array([0]=>word1 [1]=>PT of word1 [2]=>NT [3]=>NT ... [4]=>RT) 
 *      [word2]=>Array([0]=>word2 [1]=>PT of word2 [2]=>NT ... [3]=>RT))
 */

function search_related_terms($search_text)
{
    $db=db_connect();
    
    //Puts the search chain and then each word of this chain seperately in the "$search" array.
    if(count(explode(" ", $search_text))==1)
    {
        $search[0]=$search_text;
    }
    else
    {
        $search=array_merge(array($search_text), explode(" ", $search_text));
    }

    //For each one of these terms, starts an array of this term (cleaned up and allowing for different spelling, plurals, etc.) and related terms 
    $related_terms=array();
    foreach($search as $key=>$search_term)
    {
        $search_term = strtoupper($search_term); //changes string in all upper case 
        $search_term = strip_tags($search_term); //print_r($search_term); echo"<br>";//strips NUL bytes, HTML and PHP tags ex: <p>
        $search_term = trim ($search_term); //whitespaces (blank, tab, return..) stripped from the beginning and end of string
        $pattern=array('/OU?/', '/VES$/', '/IES$/', '/ES$/', '/S$/', '/AE/');
        $replacement=array('OU?', '(VES?|FE)', '(IES?|Y)', 'E?S?', 'S?', 'AE?');
        $search_term = preg_replace($pattern, $replacement, $search_term); // regex. replaces plural endings by singular or plural and o and ou by o or ou (for words like colour)
        $search_term = mysqli_real_escape_string($db, $search_term); //escapes certain characters (ex: ') to make it a valid SQL sring usable in SQL statements.
        $related_terms[$search_term]=array();
        $related_terms[$search_term][]=$search_term;

        //Find the preferred term if the research term isn't one.
        $sql = "SELECT T2.Term 
            FROM thesaurus_term AS T2 
            INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
            INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
            WHERE upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                AND (R.Relationship='Use')";
        $result = db_query($db, $sql);
        $data=db_fetch_assoc($result);
        if(!empty($data))
        {
            $preferred_term[$search_term]=strtoupper($data['Term']);
        }
        else
        {
            $sql = "SELECT T2.Term 
            FROM thesaurus_term AS T2 
            INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
            INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
            WHERE upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                AND (R.Relationship='Use For')";
            $result = db_query($db, $sql) ;
            $data=db_fetch_assoc($result);
            $preferred_term[$search_term]=strtoupper($data['Term']);
        }
        if($preferred_term[$search_term]!="") $related_terms[$search_term][]=$preferred_term[$search_term];

        //Find the narrower terms for the search term and the preferred term and the narrower of these until ther aren't any left.
        $terms[$search_term]=$related_terms[$search_term];
        while(!empty($terms[$search_term]))
        {
            foreach($terms[$search_term] as $key=>$word)
            {
                $terms[$search_term][$key]="upper(T1.Term) REGEXP '[[:<:]]".$word."[[:>:]]'";
            }
            $condition=implode(" OR ", $terms[$search_term]);
            $terms[$search_term] = array();

            $sql = "SELECT T2.Term 
            FROM thesaurus_term AS T2 
            INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
            INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
            WHERE (".$condition.") AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                AND (R.Relationship='NT')";

            $result = db_query($db, $sql) ;
            while($data=db_fetch_assoc($result))
            {
                if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                {
                    $terms[$search_term][]=strtoupper($data['Term']);
                    $related_terms[$search_term][]=strtoupper($data['Term']);
                }
            }

            $sql = "SELECT T2.Term
                FROM thesaurus_term AS T2 
                INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
                INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
                WHERE (".$condition.") AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                    AND (R.Relationship='BT')";

            $result = db_query($db, $sql) ;
            while($data=db_fetch_assoc($result))
            {
                if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                {
                    $terms[$search_term][]=strtoupper($data['Term']);
                    $related_terms[$search_term][]=strtoupper($data['Term']);
                }
            }
        }

        //Find the related terms for the search term and the preferred term.
        $sql = "SELECT T2.Term 
            FROM thesaurus_term AS T2 
            INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
            INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
            WHERE (upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' OR upper(T1.Term) = '".$preferred_term[$search_term]."') AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                AND (R.Relationship='RT')";

        $result = db_query($db, $sql) ;
        while($data=db_fetch_assoc($result))
        {
            if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
            {
                $related_terms[$search_term][]=strtoupper($data['Term']);
            }
        }

        $sql = "SELECT T2.Term
            FROM thesaurus_term AS T2 
            INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
            INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
            WHERE (upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' OR upper(T1.Term) = '".$preferred_term[$search_term]."') AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                AND (R.Relationship='RT')";

        $result = db_query($db, $sql) ;
        while($data=db_fetch_assoc($result))
        {
            if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
            {
                $related_terms[$search_term][]=strtoupper($data['Term']);
            }
        }
    }
    return $related_terms;
}







/* Function write_where_clause
 * Definition of the WHERE clause of the search's SQL request
 * $related_terms: array of the search terms with all their related terms from the thesaurus. Takes the form:
 *      Array([word1 word2]=> array([0]=>[word1 word2])
 *              [word1]=>array(word1, PT NT and RT of word1)
 *              [word2]=>array(word2, PT, NT and RT of word2))
 * $detailed_fields_array: array of the fields in which these terms should be looked for in their detailed form ie: table.Field
 *  example: Array ([0] => object.Type [1] => object.Material [2] => object.Site [3] => object.Date_strati)
 * Returns a clause of the format:
 * (upper(field1) REGEXP (word1 word2) OR upper(field2) REGEXP (word1 word2) or upper (field3) REGEXP(word1 word2)...)
 *  OR
 *  (upper(field1) REGEXP (word1) OR upper(field1) REGEXP (PT of word1) OR upper(field1) REGEXP (NT of word1) OR upper(field1) REGEXP (RT of word1)
 *  OR upper(field2) REGEXP (word1) OR upper(field2) REGEXP (PT of word1) OR upper(field2) REGEXP (NT of word1) OR upper(field2) REGEXP (RT of word1)
 *  OR... with field 3 or more)
 *  AND
 *  (same with word2)
 */
function write_where_clause($related_terms, $detailed_fields_array)
{
    $i=0;
    foreach($related_terms as $search_term=>$array)
    {
       $conditions=array();
       foreach($detailed_fields_array as $field)
       {
            foreach($array as $term)
            {
                $conditions[$search_term][]="upper(".$field.") REGEXP '".$term."'";
            }
        }
        $clause[$i]=implode(" OR ", $conditions[$search_term]);
        $clause[$i]="(".$clause[$i].")";
        $i=$i+1;
    }
    $clause_final=$clause[0];
    unset($clause[0]);
    if(!empty($clause))
    {
        $clause_final=$clause_final." OR ".implode(" AND ", $clause);
    }
    return $clause_final;
}
?>
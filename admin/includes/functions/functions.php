<?php

    /* Title Function v1.0 */
    function getTitle()
    {
        global $pageTitle ;
        if (isset($pageTitle)) {
            echo $pageTitle;
        } else {
            echo 'Default';
        }
    }



    /* Redirect Home Function v2.0
    ** $message = Message to show
    ** $url = Destination Url
    ** $second = Seconds Before Redirecting */
    function redirectHome($message, $url = null, $second = 3)
    {
        if ($url === null) {
            $url = 'index.php';
            $link = 'Homepage';
        } else {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];   
                $link = 'Previous Page'; 
            } else {
                $url = 'index.php';
                $link = 'Homepage';
            }
            
        }
        echo $message;
        echo "<div class='alert alert-info'>You'll be redirected to $link in $second seconds</div>";
        header("refresh:$second;url=$url");
        exit();
    }


    /* Check Item Function v1.0
    ** $table : Tabel to check in.
    ** $column : Column In $table
    ** $item : Value to check. */
    function checkItem($table, $column, $item)
    {
        global $con;
        $statement = $con->prepare("SELECT $column FROM $table WHERE $column = ?");
        $statement->execute(array($item));
        return $statement->rowCount();
    }
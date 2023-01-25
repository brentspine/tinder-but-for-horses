<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/connection.php";
ob_end_clean();

/**
  * Checks if the given mail is valid and does not exist in the user db. Responses automatically if it's not valid
  * Requires json_codes entries
  *
  * @param string   $mail       The mail to check
  * @param object   $con        DB Connection
  *
  * @return boolean True, if the mail is valid. Automatically responses when not
  */
function is_mail_valid($mail, $uid, $con) {
    if(strlen($mail) > 60) {
        echo get_json_answer(true, "mail_to_long", [], [], $con);
        return false;
    }

    if( 
        !str_contains($mail, "@")       || 
        !str_contains($mail, ".")       
    ) {
        echo get_json_answer(true, "invalid_mail_format", [], [], $con);
        return false;
    }
    if(strlen(explode(".", $mail)[1]) < 2 || strlen(explode(".", explode("@", $mail)[1])[0]) < 2 ) {
        echo get_json_answer(true, "invalid_mail_domain", [], [], $con);
        return false;
    }

    $result = prepared_statement_result("SELECT * FROM users WHERE mail = ? AND (NOT id = ?)", $con, true, "ss", $mail, $uid);
    if($result -> num_rows >= 1) {
        echo get_json_answer(true, "mail_taken", [], [], $con);
        return false;
    }
    return true;
}

/**
  * Checks if any of the given values is empty
  *
  * @param mixed    $params     Unlimited parameters ($_GET["test"], $_GET["limit"])
  *
  * @return boolean True if any of the values is empty
  */
function empty_any(...$params) {
    foreach($params as $c) {
        if(empty($c))
            return true;
    }
    return false;
}

/**
  * Checks if any of the given values is set
  *
  * @param  mixed   $params     Unlimited parameters ($_GET["test"], $_GET["limit"])
  *
  * @return boolean True if any of the values is set
  */
function isset_any(...$params)
{
    foreach ($params as $c) {
        if (isset($c)) {
            return true;
        }
    }
    return false;
}

/**
  * Checks if any of the given values is empty
  *
  * @param array    $request_params     $_GET, $_POST or other request array
  * @param mixed    $params             The values to be checked from the array. Unlimited parameters ("test", "limit")
  *
  * @return boolean True if any of the values is empty
  */
function empty_any_params($request_params, ...$params) {
    foreach($params as $c) {
        if(empty($request_params[$c]))
            return true;
    }
    return false;
}

/**
  * Checks if any of the given values is set
  *
  * @param array    $request_params     $_GET, $_POST or other request array
  * @param mixed    $params             The values to be checked from the array. Unlimited parameters ("test", "limit")
  *
  * @return boolean True if any of the values is set
  */
  function isset_any_params($request_params, ...$params) {
    foreach($params as $c) {
        if(isset($request_params[$c]))
            return true;
    }
    return false;
}

/**
  * Checks if every of the given values is set
  *
  * @param array    $request_params     $_GET, $_POST or other request array
  * @param mixed    $params             The values to be checked from the array. Unlimited parameters ("test", "limit")
  *
  * @return boolean True if every value is set
  */
  function isset_every_params($request_params, ...$params) {
    foreach($params as $c) {
        if(!isset($request_params[$c]))
            return false;
    }
    return true;
}


/**
  * Strips a specific GET param from the given url and returns it
  *
  * @param string   $url        URL to be stripped from
  * @param string   $code       The response code stored in the database
  *
  * @return string the param value
  */
function strip_param_from_url($url, $param) {
    $base_url = strtok($url, '?');              // Get the base url
    $parsed_url = parse_url($url);              // Parse it 
    $query = $parsed_url['query'];              // Get the query string
    parse_str( $query, $parameters );           // Convert Parameters into array
    unset( $parameters[$param] );               // Delete the one you want
    $new_query = http_build_query($parameters); // Rebuilt query string
    return $base_url.'?'.$new_query;            // Finally url is ready
}

/** 
 * @return string The current URL of the webpage
 */
function get_current_url() {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
      
    return $url;  
}

/** 
 * @return string The path of the request, excluding the actual website URL and parameters
 */
function get_current_path() {
    return explode("?", $_SERVER["REQUEST_URI"])[0];
}

/** 
 * Strips given parameters from given url
 * 
 * @param string    $url        The URL
 * @param string[]  $hidden     The params that should be hidden
 * 
 * @return string The URL without the parameters in the array
 */
function get_url_without_parameter($url, $hidden) {
    $url = explode("?", $url)[0];
    $first = true;
    foreach($_GET as $key => $value) {
        if(in_array($key, $hidden))
            continue;
        if($first)
            $url .= '?';
        else
            $url .= '&';
        $url .= $key . '=' .$value;
        $first = false;
    }
    return $url;
}

/**
 * Gets the first row from the result
 * 
 * @param object    $result     The result to be taken from
 * @param string    $row        The Row name
 * 
 * @return object The Row
 */
function get_row_result($result, $row) {
    if ($result->num_rows > 0) {
        while($c = $result->fetch_assoc()) {
            return $c[$row];
        }
    } else 
        return -1;
}

/** 
 * 
 * @param object    $result     Result Set
 * @param string    $column     Column to return
 * 
 * @return string   The value of the column in the first row from the resultset
 */
function get_database_entry_result($result, $column) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row[$column];
        }
    }
   return -1;
}

/** 
 * Returns all columns for the query
 * 
 * @param object    $result     Result set
 * @param string    $column     Column to return
 * 
 * @return array    All values for the requetsed column affected in the SELECT query
 */
function get_database_entries_result($result, $column) {
    $r = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $r[] = $row[$column];
        }
    } else 
        return [];
    return $r;
}

/** 
 * Returns all columns for the query
 * 
 * @param object    $result     Result set
 * @param array     $columns    Columns to return as ["column1", "column2"]
 * 
 * @return array    All values for the requested columns affected in the SELECT query Formatted like [[val1, val2], [val3, val4]]
 */
function get_multiple_database_entries_result($result, $columns) {
    $r = [];
    if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
            $r[$i] = [];
            foreach($columns as $column) {
                $r[$i][] = $row[$column]; 
            }
            $i++;
        }
    } else 
        return [];
    return $r;
}

/**
 * @return string   Datetime in Y-m-d H:i:s format
 */
function get_current_datetime() {
    $currentDate = new DateTime();
    return $currentDate->format('Y-m-d H:i:s');
}

/**
 * Prints a page redirect with JavaScript
 * 
 * @param string    $url    The URL to redirect to
 * @param int       $time   Time until redirect in ms (1000ms = 1s)
 */
function redirect_js($url, $time) {
    echo '<script> setInterval(function(){window.location="' .$url. '"},' .$time. '); </script>';
}

/**
 * Clears a cookie
 * @param string    $name   Name of the cookie
 */
function clear_cookie($name) {
    setcookie($name, "", time() + 1, "/");
}

/**
 * Clears a cookie from $path
 * @param string    $name   Name of the cookie
 * @param string    $path   Path name
 */
function clear_cookie_path($name, $path) {
    setcookie($name, "", time() + 1, $path);
}


 /**
  * Gets a JSON response stored in json_codes
  *
  * @param boolean  $error          Is answer an error?
  * @param string   $code           The response code stored in the database
  * @param array    $info           Additional info appended as ["info"]
  * @param array    $replacements   Formatted as ["key", "replacement", "key2", "replacement2"]. Replaces all keys with the next replacement value
  * @param object   $con            DB Connection
  *
  * @return array JSON Answer
  */
function get_json_answer($error, $code, $info, $replacements, $con) {
    $result = prepared_statement_result("SELECT * FROM json_codes WHERE code = ?", $con, true, "s", $code);
    while($row = $result->fetch_assoc()) {
        return get_custom_json_answer($error, $code, $row["status"], $row["message"], $info, $replacements);
    }
    return get_json_answer(true, "unknown_error", [], [], $con);
}

/**
  * Gets a JSON response stored in json_codes with id instead of code
  *
  * @param boolean  $error          Is answer an error?
  * @param int      $id             The response code id stored in the database
  * @param array    $info           Additional info appended as ["info"]
  * @param array    $replacements   Formatted as [["key", "replacement"]]. Replaces all keys with the second value
  * @param mixed    $con            DB Connection
  *
  * @return array JSON Answer
  */
function get_json_answer_by_id($error, $id, $info, $replacements, $con) {
    $result = prepared_statement_result("SELECT * FROM json_codes WHERE id = ?", $con, true, "s", $id);
    while($row = $result->fetch_assoc()) {
        return get_custom_json_answer($error, $row["code"], $row["status"], $row["message"], $info, $replacements);
    }
    return get_json_answer(true, "unknown_error", [], [], $con);
}


/**
  * Gets a custom JSON response with the normal template
  *
  * @param boolean  $error          Is answer an error?
  * @param string   $code           The response code stored in the database
  * @param int      $status         The HTTPS Response Code
  * @param string   $message        The Message usually displayed on the user screen
  * @param array    $info           Additional info appended as ["info"]
  * @param array    $replacements   Formatted as [["key", "replacement"]]. Replaces all keys with the second value
  *
  * @return array JSON Answer
  */
function get_custom_json_answer($error, $code, $status, $message, $info, $replacements) {
    for ($i=0; $i < (sizeof($replacements) / 2); $i++) { 
        $message = str_replace($replacements[$i*2], $replacements[$i*2+1], $message);
    }
    $response = [];
    if($error)
        $response["error"] = $code;
    else
        $response["code"] = $code;
    $response["status"] = $status;
    $response["message"] = $message;
    if(!empty($info))
        $response["info"] = $info;
    return json_encode($response);
}


/**
 * Performs a HTTP get request
 * 
 * @param   $url            The url to send the request to
 * @param   $header_array   Custom get headers
 * 
 */
function http_get($url, $header_array) {
    $header = "";
    foreach (array_keys($header_array) as $c)
        $header .= $c . ": ".$header_array[$c]."\r\n";
    $opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>$header
    ));
    $context = stream_context_create($opts);
    $contents = file_get_contents($url, false, $context);
    return $contents;
}

/**
 * Performs a HTTP post request
 * 
 * @param   $url    The url to send the request to
 * @param   $body   Request parameters
 * 
 */
function http_post($url, $body) {
    $sPD = http_build_query(
        $body
    ); 
    $aHTTP = array(
    'http' =>
        array(
        'method'  => 'POST', // Request Method
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $sPD
    )
    );
    set_error_handler(function() { /* ignore errors */ });
    $context = stream_context_create($aHTTP);
    $contents = file_get_contents($url, false, $context);
    restore_error_handler();

    if($contents === FALSE) {
        return null;
    }
    return $contents;
}

/**
 * Runs a prepared statement and returns it
 * 
 * @param string    $sql        The SQL code to be prepared and run containing
 * @param object    $con        DB Connection Object
 * @param boolean   $bind_params    True, if bind_params should be executed
 * @param string    $s          The first parameter of the bind_param() function --> "sss"
 * @param string    ...$params  Parameters passed in the second part of the bind_param() function
 * 
 * @return object   The prepared statement
 */
function prepared_statement($sql, $con, $bind_params, $s, ...$params) {
    $ps = $con -> prepare($sql);
    if($bind_params)
        $ps -> bind_param($s, ...$params);
    $ps -> execute();
    return $ps;
}

/**
 * Runs a prepared statement and returns the result
 * 
 * @param string    $sql            The SQL code to be prepared and run containing
 * @param object    $con            DB Connection Object
 * @param boolean   $bind_params    True, if bind_params should be executed
 * @param string    $s              The first parameter of the bind_param() function --> "sss"
 * @param string    ...$params      Parameters passed in the second part of the bind_param() function
 * 
 * @return object  The Result
 */
function prepared_statement_result($sql, $con, $bind_params, $s, ...$params) {
    return prepared_statement($sql, $con, $bind_params, $s, ...$params) -> get_result();
}

?>

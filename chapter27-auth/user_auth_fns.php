<?php
require_once('db_fns.php');
function register($username, $email, $password) {
    // register new person with db
    // return true or error message
    // connect to db
    $conn = db_connect();
    // check if username is unique
    $result = $conn->query("select * from user where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not execute query');
    }
    if ($result->num_rows>0) {
        throw new Exception('That username is taken
                            - go back and choose another one.');
    }
    // if ok, put in db
    $query = "insert into user values
            ('$username', sha1('$password'), '$email')";
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Could not register you in database - Please try again
                            later.');
    }
    return true;
}

function login($username, $password) {
    // check username and password with db
    // if yes, return true
    // else throw exception
    // connect to db
    $conn = db_connect();
    // check if username is unique
    $result = $conn->query("select * from user
                            where username='$username'
                            and passwd=sha1('$password')");
    if (!$result) {
        throw new Exception('Could not log you in.');
    }
    if ($result->num_rows>0) {
        return true;
    } else {
        throw new Exception('Could not log you in.');
    }
}

function check_valid_user() {
    // see if somebody is logged in and notify them if not
    if (isset($_SESSION['valid_user'])) {
        echo "Logged in as ".$_SESSION['valid_user'].".<br />";
    } else {
        // they are not logged in
        echo 'You were not logged in, and so have not been logged out.<br />';
        do_html_url('login.php', 'Login');
    }
    do_html_footer();
}

function change_password($username, $old_password, $new_password) {
    // change password for username/old_password to new_password
    // return true or false
    // if the old password is right
    // change their password to new_password and return true
    // else throw an exception
    login($username, $old_password);
    $conn = db_connect();
    $result = $conn->query("update user
                            set passwd=sha1('".$new_password."')
                            where username='".$username."'");
    throw new Exception('Password could not be changed.');
    if (!$result) {
        throw new Exception('Password could not be changed.');
    } else {
        // changed successfully
        return true;
    }
}

function reset_password($username) {
    // set password for username to a random value
    // return the new password or false on failure
    // get a random dictionary word b/w 6 and 13 chars in length
    $new_password = get_random_word(6, 13);
    if ($new_password == false) {
        throw new Exception('Could not generate new password');
    }
    // add a number between 0 and 999 to it
    // to make it a slightly better password
    $rand_number = rand(0, 999);
    $new_password .= $rand_number;
    // set user's password to this in database or return false
    $conn = db_connect();
    $result = $conn->query("select * from user where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not execute query');
    }
    if ($result->num_rows==0) {
        throw new Exception('There isn\'t such a username in database.');
    }
    $result = $conn->query("update user
                            set passwd=sha1('".$new_password."')
                            where username='".$username."'");
    if (!$result) {
        // not changed
        throw new Exception('Could not reset password.');
    } else {
        // changed successfully
        return $new_password;
    }
}

function get_random_word($min_length, $max_length) {
    // grab a random word from dictionary between the two lengths
    // and return it
    // generate a random word
    $word = '';
    // remember to change this path to suit your system
    // the ispell dictionary
    $dictionary = './wordlist.dic';
    $fp = @fopen($dictionary, 'r');
    if (!$fp) {
        return false;
    }
    $size = filesize($dictionary);
    // go to a random location in dictionary
    $rand_location = rand(0, $size);
    fseek($fp, $rand_location);
    // get the next whole word of the right length in the file
    while ((strlen($word) < $min_length) || (strlen($word) > $max_length) ||
            (strstr($word, "'"))) {
        if (feof($fp)) {
            // if at end, go to start
            fseek($fp, 0);
        }
        // skip first word as it could be partial
        $word = fgets($fp, 80);
        // the potential password
        $word = fgets($fp, 80);
    }
    // trim the trailing \n from fgets
    $word = trim($word);
    return $word;
}

function notify_password($username, $password) {
    // notify the user that their password has been changed
    $conn = db_connect();
    $result = $conn->query("select email from user
                            where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not find email address.');
    } else if ($result->num_rows == 0) {
        // username not in db
        throw new Exception('Could not find email address.');
    } else {
        $row = $result->fetch_object();
        $email = $row->email;
        $from = "From: support@phpbookmark \r\n";
        $mesg = "Your PHPBookmark password has been changed to ".$password."\r\n"
                ."please change it next time you log in.\r\n";
        if (mail($email, 'PHPBookmark login information', $mesg, $from)) {
            return true;
        } else {
            throw new Exception('Could not send email.');
        }
    }
}
?>

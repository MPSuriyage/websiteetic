<?php
session_start();

require_once(dirname(__FILE__) . '/config/config.php');
require_once(dirname(__FILE__) . '/lib/class.dbQuery.php');
//require_once(dirname(__FILE__) . '/lib/log4php/Logger.php');
require_once(dirname(__FILE__) . '/lib/class.auditLogger.php');
require_once(dirname(__FILE__) . '/lib/enum.php');
require_once(dirname(__FILE__) . '/lib/class.permission.php');

Logger::configure(dirname(__FILE__) . '/config/log4php.xml');
LoggerMDC::put("ip", $_SERVER['REMOTE_ADDR']);

$coreReplaceWords = array();
$javascript_files = array();

function getCurrentUrl()
{
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function getCurrentTime()
{
    return date("Y-m-d H:i:s");
}

function getCurrentDate()
{
    return date("Y-m-d");
}

function getCurrentTimeWithoutDate()
{
    return date("H:i:s");
}

function getCurrentUserIp()
{
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }else{
        return $_SERVER['REMOTE_ADDR'];    
    }
}

function getConfiguration($key)
{
    global $config;
    return $config[$key];
}

function addCoreReplaceWord($keyword, $value)
{
    global $coreReplaceWords;
    $coreReplaceWords[$keyword] = $value;
}

function getCoreReplaceWords()
{
    global $coreReplaceWords;
    return $coreReplaceWords;
}

addCoreReplaceWord("%site_url%", getConfiguration('site_url'));

//replace null with N/A
function replaceNull($value)
{
    if (empty($value)) {
        return "N/A";
    } else return $value;
}

function setCoreReplaceWord($key, $value)
{
    global $coreReplaceWords;
    $coreReplaceWords[$key] = $value;

}

function getPaginationLinks($total_records, $records_per_page, $current_page, $parameters = null)
{
    $links = 1;
    $last = ceil($total_records / $records_per_page);
    $start = (($current_page - $links) > 0) ? $current_page - $links : 1;
    $end = (($current_page + $links) < $last) ? $current_page + $links : $last;
    $parameters = !empty($parameters) ? '&' . $parameters : '';

    //Desktop view
    $html = '<div class="desktop-pagination"><nav aria-label="pagination">';
    $html .= '<ul class="pagination">';


    //previous link
    if ($current_page == 1) {
        $html .= '<li class="disabled"><a href="#" aria-label="Previous"><i class="fa fa-angle-left"></i></a></li>';
    } else {
        $html .= '<li><a href="?page=' . ($current_page - 1) . $parameters . '" aria-label="Previous"><i class="fa fa-angle-left"></i></a></li>';
    }


    if ($start > 1) {
        //beginning page separator
        $html .= '<li><a href="?page=1' . $parameters . '" aria-label="1">1</a></li>';
        $html .= '<li class="disabled"><a href="#">...</a></li>';
    }

    //page links
    for ($i = $start; $i <= $end; $i++) {
        $class = ($current_page == $i) ? "active" : "";
        $html .= '<li class="' . $class . '"><a href="?page=' . $i . $parameters . '">' . $i . '</a></li>';
    }

    if ($end < $last) {
        //end page separator
        $html .= '<li class="disabled"><a href="#">...</a></li>';
        //last page
        $html .= '<li><a href="?page=' . $last . $parameters . '" aria-label="' . $last . '">' . $last . '</a></li>';
    }

    //next link
    if ($current_page == $last) {
        $html .= '<li class="disabled"><a href="#" aria-label="Next"><i class="fa fa-angle-right"></i></a></li>';
    } else {
        $html .= '<li><a href="?page=' . ($current_page + 1) . $parameters . '" aria-label="Next"><i class="fa fa-angle-right"></i></a></li>';
    }
    $html .= '</ul>';
    $html .= '</nav></div>';

    //Mobile view
    $html .= '<!--mobile pagination start--><div class="mobile-pagination">';
    //first page
    if ($current_page > 2) {
        $html .= '<a class="btn btn-default" href="?page=1' . $parameters . '" aria-label="First Page"><i class="fa fa-angle-double-left"></i></a>';
    }
    //previous link
    if ($current_page > 1) {
        $html .= '<a class="btn btn-default" href="?page=' . ($current_page - 1) . $parameters . '" aria-label="Previous"><i class="fa fa-angle-left"></i></a>';
    }
    $html .= 'Page ' . $current_page . ' of ' . $last;

    //next link
    if ($current_page != $last) {
        $html .= '<a class="btn btn-default" href="?page=' . ($current_page + 1) . $parameters . '" aria-label="Next"><i class="fa fa-angle-right"></i></a>';
    }

    //last page
    if ($end < $last) {
        $html .= '<a class="btn btn-default" href="?page=' . $last . $parameters . '" aria-label="' . $last . '"><i class="fa fa-angle-double-right"></i></a>';
    }

    $html .= '</div><!--mobile pagination end-->';
    return $html;

}

function setSuccessMessage($message)
{
    $_SESSION["success_message"] = $message;
}

function setErrorMessage($message)
{
    $_SESSION["error_message"] = $message;
}

function displayMessages()
{
    if (!empty($_SESSION["error_message"])) {
        ?>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" style="float: right" aria-hidden="true">×</button>
            <?php echo($_SESSION["error_message"]); ?>
        </div>
        <?php
        unset($_SESSION["error_message"]);
    }
    if (!empty($_SESSION["success_message"])) {
        ?>
        <div id="form-success-alert" class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" style="float: right" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <?php echo($_SESSION["success_message"]); ?>
        </div>
        <?php
        unset($_SESSION["success_message"]);
    }
}

function generateNonce($user_id, $key, $expireDays = 7)
{
    $code = md5($user_id . $key . time() . rand());
    $expireTime = date("Y/m/d H:i:s", strtotime(getCurrentTime() . ' + ' . $expireDays . ' days'));

    $dbQuery = new DbQuery();
    $dbQuery->addCondition("type", $key);
    $dbQuery->addCondition("user_id", $user_id);

    $current_code = $dbQuery->retrieve("user_codes");
    if (!empty($current_code)) {
        $dbQuery->addParam("code", $code);
        $dbQuery->addParam("requested_time", getCurrentTime());
        $dbQuery->addParam("expire_time", $expireTime);
        $dbQuery->addParam("status", "ACTIVE");
        $dbQuery->addParam("type", $key);
        $result = $dbQuery->update("user_codes");
    } else {
        $dbQuery = new DbQuery();
        $dbQuery->addParam("code", $code);
        $dbQuery->addParam("requested_time", getCurrentTime());
        $dbQuery->addParam("expire_time", $expireTime);
        $dbQuery->addParam("status", "ACTIVE");
        $dbQuery->addParam("type", $key);
        $dbQuery->addParam("user_id", $user_id);

        $result = $dbQuery->insert("user_codes");
    }

    if ($result == true) {
        return $code;
    } else {
        return false;
    }
}


function validateNonce($userId, $key, $code)
{
    $dbQuery = new DbQuery();
    $dbQuery->addCondition("user_id", $userId);
    $dbQuery->addCondition("type", $key);
    $dbQuery->addCondition("code", $code);
    $dbQuery->addCondition("expire_time", getCurrentTime(), PDO::PARAM_STR, ">");
    $dbQuery->addCondition("user_codes.status", "ACTIVE");
    $dbQuery->addParam("id");

    $result = $dbQuery->retrieve("user_codes");
    if (!empty($result)) {
        $dbQuery->reset();
        $dbQuery->addParam("status", "USED");
        $dbQuery->addCondition("id", $result[0]["id"]);
        return $dbQuery->update("user_codes");
    } else {
        return false;
    }
}

// validate the nonce. but not going to update its status
function validateNonceWithoutUpdate($userId, $key, $code)
{
    $dbQuery = new DbQuery();
    $dbQuery->addCondition("user_id", $userId);
    $dbQuery->addCondition("type", $key);
    $dbQuery->addCondition("code", $code);
    $dbQuery->addCondition("expire_time", getCurrentTime(), PDO::PARAM_STR, ">");
    $dbQuery->addCondition("status", "ACTIVE");
    $dbQuery->addParam("id");

    $result = $dbQuery->retrieve("user_codes");
    if (!empty($result)) {
        return true;
    } else {
        return false;
    }
}

function updateNonceStatus($nonceId, $status)
{
    $dbQuery = new DbQuery();
    $dbQuery->addParam("status", $status);
    $dbQuery->addCondition("id", $nonceId);
    return $dbQuery->update("user_codes");
}

function updateAllNonce($userId, array $nonceTypes, $status)
{
    $dbQuery = new DbQuery();
    $dbQuery->addParam("status", $status);
    $dbQuery->addCondition("user_id", $userId);
    foreach ($nonceTypes as $nonceType) {
        $dbQuery->addCondition("type", $nonceType, PDO::PARAM_STR, "=", "OR");
    }
    return $dbQuery->update("user_codes");
}

function getCurrentMerchantId()
{
    return !empty($_SESSION["merchant"]["id"]) ? $_SESSION["merchant"]["id"] : null;
}

function getCurrentMerchantName()
{
    return $_SESSION["merchant"]["first_name"] . " " . $_SESSION["merchant"]["last_name"];
}

function isMerchantLoggedIn()
{
    return !empty($_SESSION["merchant"]["id"]);
}

function getCurrentMerchantRegistrationId()
{
    return $_SESSION["merchant"]["registration_id"];
}

function getCurrentMerchantEmail()
{
    return $_SESSION["merchant"]["email"];
}

function getCurrentMerchantLoginSource()
{
    return !empty($_SESSION["merchant"]["login_source"]) ? $_SESSION["merchant"]["login_source"] : null;
}

function authenticateMerchant()
{
    if (!isset($_SESSION["merchant"]["id"])) {
        setErrorMessage("Please log in to proceed");
        header("location:" . getConfiguration("site_url") . "/merchant/login.php?redirect=" . getCurrentUrl());
        die();
    }
}

function formatSeoDescription($description)
{
    if (empty($description)) {
        return "";
    }
    $description = strip_tags($description);
    $description = substr($description, 0, 160);

    return $description;
}

function validateFileManagerAccess()
{
    if (!isset($_SESSION["user"]["id"]) && !isset($_SESSION["merchant"]["id"])) {
        error_log("Non logged in user tried to access file manager");
        header("HTTP/1.1 403 Forbidden");
        die("Access denied");
    }

    $user_id = isset($_SESSION["user"]["id"]) ? $_SESSION["user"]["id"] : $_SESSION["merchant"]["id"];

    if (!isset($_SESSION['RF']['subfolder'])) {
        error_log("Logged in user(" . $user_id . ") tried to access file manager from a not allowed page");
        header("HTTP/1.1 403 Forbidden");
        die("Access denied");
    }
}

function validateRecaptcha($gRecaptchaResponse)
{
    $logger = Logger::getLogger('info');

    if (empty($gRecaptchaResponse)) {
        setErrorMessage("Please complete the captcha");
        $logger->info("Missing recaptcha");
        return false;
    }
    $secret = getConfiguration("recaptcha")["secret"];
    //get verify response data
    try {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secret,
            'response' => $gRecaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response);
        if (!$result->success) {
            setErrorMessage("Invalid captcha");
            $logger->info("Invalid recaptcha");
            return false;
        }
        return true;
    } catch (Exception $e) {
        setErrorMessage("Failed to validate captcha. Please try again");
        error_log("Exception occurred in recaptcha: " . $e->getTraceAsString());
        return false;
    }
}

function addJavascriptFile($file_name)
{
    global $javascript_files;
    array_push($javascript_files, $file_name);
    $javascript_files = array_unique($javascript_files);
}

function isUsrWithNoPwd($userId)
{
    $dbQuery = new DbQuery();
    $dbQuery->addCondition("id", $userId);
    $dbQuery->addParam("password");

    $result = $dbQuery->retrieve("user");

    if (empty($result[0]['password'])) {
        return "true";
    } else {
        return "false";
    }
}

function checkMaintenanceMode()
{
    if (!empty (MAINTENANCE_MODE) && MAINTENANCE_MODE == true) {
        if (!isset($_SESSION["user"]["id"])) {
            include("maintenance.php");
            exit();
        } else {
            static $messageDisplayed = false;
            if (!$messageDisplayed) {
                echo('<div class="maintenance-mode">Site is in maintenance mode for visitors</div>');
                $messageDisplayed = true;
            }

        }
    }
}

function get404Page(){
    include("404.php");
    exit();
}

?>
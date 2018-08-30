<?php

$WORKING_LOCALLY = substr($_SERVER['DOCUMENT_ROOT'], 0, 3) == "C:/";
include($_SERVER['DOCUMENT_ROOT'].'/php/secret_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/patreon/patreon/src/patreon.php');
use Patreon\API;
use Patreon\OAuth;

function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function get_patreon(){

    // Some users request name change
    $name_replacements = [
        "Matt Outlaw" => "3dOutlaw",
        "Athanasios Pozantzis" => "Noseman",
        ];
    $remove_names = [
        "Miro Pavic",
    ];

    // Get dummy data if working locally
    if ($GLOBALS['WORKING_LOCALLY']){
        // $dummies = ["a", "b", "c", "d", "e", "f"];
        $dummies = ["Testy Mctestface", "Test", "Tester", "Testy Mcgoo", "Also a Test", "Not Test", "Matt Outlaw", "Miro Pavic"];
        $patron_list = [];
        for ($i=0; $i<240; $i++){
            $pledge_rank_weights = [1,1,1,1, 2,2,2,2,2,2,2,2,2,2,2,2, 3,3,3, 4,4, 5];
            $pledge_rank = $pledge_rank_weights[array_rand($pledge_rank_weights)];
            $patron_full_name = $dummies[array_rand($dummies)];
            if (array_key_exists($patron_full_name, $name_replacements)){
                $patron_full_name = $name_replacements[$patron_full_name];
            }

            if (!in_array($patron_full_name, $remove_names)){
                array_push($patron_list, [$patron_full_name, $pledge_rank]);
            }
        }
        $goals = [
            [
            "amount_cents" => 50000,
            "completed_percentage" => 13,
            "description" => "<strong>Vault #1 unlocked</strong> <br><br>20 old (previously for-sale on the old site) HDRIs added, now available for free like everything else.<br><br><a href=\"https://hdrihaven.com/p/vaults.php\">Read more here</a>.<br><br><em>Money used for: server hard drive space, higher bandwidth costs.</em>"
            ],
            [
            "amount_cents" => 10000,
            "completed_percentage" => 53,
            "description" => "<strong>Enable 16K downloads<br><br></strong>Right now you can only download up to 8K resolution (to keep server costs affordable), but 99% of my HDRIs are actually 16K. It would be just a push of a button to make 16K available, but I need to make sure I can afford it first.<br><br><em>Money used for: server upgrade and higher bandwidth costs.</em>"
            ],
            [
            "amount_cents" => 90000,
            "completed_percentage" => 7,
            "description" => "<strong>Vault #2 unlocked</strong> <br><br>40 old (previously for-sale) HDRIs added to the site, now available for free like everything else.<br><br><a href=\"https://hdrihaven.com/p/vaults.php\">Read more here</a>.<br><br><em>Money used for: server hard drive space, higher bandwidth costs.</em>"
            ],
            [
            "amount_cents" => 120000,
            "completed_percentage" => 5,
            "description" => "<strong>Vault #3 unlocked</strong> <br><br>60 old (previously for-sale) HDRIs added to the site, now available for free like everything else.<br><br><a href=\"https://hdrihaven.com/p/vaults.php\">Read more here</a>.<br><br><em>Money used for: server hard drive space, higher bandwidth costs.</em>"
            ],
        ];

        $goals = array_sort($goals, "amount_cents", SORT_ASC);

        $data = [$patron_list, 66, $goals];

        return $data;
    }

    $access_token = $GLOBALS['ACCESS_TOKEN'];
    $refresh_token = $GLOBALS['REFRESH_TOKEN'];
    $api_client = new Patreon\API($access_token);
    // Get your campaign data
    $campaign_response = $api_client->fetch_campaign();
    // If the token doesn't work, get a newer one
    if ($campaign_response['errors']) {
        // Make an OAuth client
        $client_id = $GLOBALS['CLIENT_ID'];
        $client_secret = $GLOBALS['CLIENT_SECRET'];
        $oauth_client = new Patreon\OAuth($client_id, $client_secret);
        // Get a fresher access token
        $tokens = $oauth_client->refresh_token($refresh_token, null);
        if ($tokens['access_token']) {
            $access_token = $tokens['access_token'];
            echo "<!-- Got a new access_token! Please overwrite the old one in this script with: " . $access_token . " and try again. -->";
        } else {
            echo "<!-- Can't recover from access failure\n";
            print_r($tokens);
            echo " -->";
        }
        return [[["[Error getting data from Patreon :( try again later]", 0]],
                0,
                [[
                    "amount_cents" => 100,
                    "completed_percentage" => 0,
                    "description" => "<strong>[Error getting data from Patreon :( try again later]</strong>"
                ]]];
    }
    // get page after page of pledge data
    $campaign_id = $campaign_response['data'][0]['id'];
    $cursor = null;
    $patron_list = [];
    $total_earnings_c = 0;
    while (true) {
        $pledges_response = $api_client->fetch_page_of_pledges($campaign_id, 25, $cursor);
        // get all the users in an easy-to-lookup way
        $user_data = [];
        foreach ($pledges_response['included'] as $included_data) {
            if ($included_data['type'] == 'user') {
                $user_data[$included_data['id']] = $included_data;
            }
        }
        // loop over the pledges to get e.g. their amount and user name
        foreach ($pledges_response['data'] as $pledge_data) {
            $declined = $pledge_data['attributes']['declined_since'];
            if (!$declined){
                $pledge_amount = $pledge_data['attributes']['amount_cents'];
                $total_earnings_c += $pledge_amount;
                $pledge_rank = 1;
                if ($pledge_amount >= 2000) {
                    $pledge_rank = 5;
                }else if ($pledge_amount >= 1000){
                    $pledge_rank = 4;
                }else if ($pledge_amount >= 500){
                    $pledge_rank = 3;
                }else if ($pledge_amount >= 300){
                    $pledge_rank = 2;
                }
                
                $patron_id = $pledge_data['relationships']['patron']['data']['id'];
                $patron_full_name = $user_data[$patron_id]['attributes']['full_name'];

                if (array_key_exists($patron_full_name, $name_replacements)){
                    $patron_full_name = $name_replacements[$patron_full_name];
                }

                if (!in_array($patron_full_name, $remove_names)){
                    array_push($patron_list, [$patron_full_name, $pledge_rank]);
                }

                echo $patron_full_name.": ";
                echo $declined;
                echo "  -  ";
                echo $pledge_amount;
                echo "  -  ";
                if ($declined){
                    echo "Declined";
                }else{
                    echo "Good";
                }
                echo "<br>";
            }
        }
        // get the link to the next page of pledges
        $next_link = $pledges_response['links']['next'];
        if (!$next_link) {
            // if there's no next page, we're done!
            break;
        }
        // otherwise, parse out the cursor param
        $next_query_params = explode("?", $next_link)[1];
        parse_str($next_query_params, $parsed_next_query_params);
        $cursor = $parsed_next_query_params['page']['cursor'];
    }
    echo "<br>";
    echo "<br>";
    echo $total_earnings_c;

    $tmp = $campaign_response['included'];
    $goals = [];
    foreach ($tmp as $x){
        if ($x['type'] == 'goal'){
            array_push($goals, $x['attributes']);
        }
    }

    $goals = array_sort($goals, "amount_cents", SORT_ASC);

    $data = [$patron_list, $total_earnings_c/100, $goals];

    return $data;
}


echo "<pre>";
$patreon = get_patreon();
echo "</pre>";

?>

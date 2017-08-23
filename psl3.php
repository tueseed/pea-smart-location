<?php
//pea smart location 4
$access_token = 'eCINsyF7OevTRLIYYn6Kj4qp11t865x+eR24qpD/owE+pKGrfJeBAo122VKnwSfPLjwLpSS0LudpXBhfUdg5Q0XYNme97lnUcB/wtewmoYQtE+75UrP2uyL0Sj3rnj4qhRVvwkLxitgO5AHocW11BAdB04t89/1O/w1cDnyilFU=';
 
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];
            // Get replyToken
            $replyToken = $event['replyToken'];
             
            $csv = array_map('str_getcsv', file('latlong.csv'));
            $findName = $text;
            $findName = strtoupper($findName);
            foreach($csv as $values)
            {
             if($values[0]==$findName) {  // index 0 contains the name
                 $latlong = $values[1];
                 $KVA = $values[2];      // index 1 contains the googlemap link 
             }
             }
             if ($latlong=="")
                 $latlong = "ไม่พบข้อมูล";
                 
         
            // Build message to reply back
            $messages = [
              'type' => 'text',
               'text' => $text.":".$latlong    //."  [".$KVA." KVA]"
             //'type' => 'image',
            //'originalContentUrl'=> "http://peas1.pea.co.th/photaram/images/images/554-1.jpg"
            ];
 
            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
 
            echo $result . "\r\n";
        }
    }
}
echo "OKJAA";

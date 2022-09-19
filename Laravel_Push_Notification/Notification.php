<?php
function sendnotificationDoctor(Request $request)
    {

        $notification_title = $request->title;
        $notification_desc = $request->body;
        $data1 = DB::table('doctor')->where('id', (int)$request->id)
            ->count();

        if ($request->title != '' && $request->body != '')
        {
            if ($data1 == 1)
            {
                $device_id1 = DB::table('doctor')->select('device_id')
                    ->where('id', $request->id)
                    ->get();
                $title = $notification_title;
                $content = $notification_desc;
                $type = "New Notification";
                $notification_id = rand(0000, 9999);
                //print_r(DB::table('user')->select('device_id')->where('id', $request->id)->get()->first());
                $device_id = $device_id1[0]->device_id;
                //echo $device_id;
                $FCMS = array();
                array_push($FCMS, $device_id);
                $field = array(
                    'registration_ids' => array(
                        $device_id
                    ) ,
                    'data' => array(
                        "message" => $title,
                        "title" => $title,
                        "body" => $content,
                        "content" => $content,
                        "notification_id" => $notification_id,
                        "type" => $type,
                        "id" => $request->id
                    )
                );
                $fields = json_encode($field);
                $headers = array(
                    'Authorization: key=AAAAI_eNM18:APA91bHTtp5qh8gaMkhqMl3_3eIdOKRhkWdlTGhavmFWdvRfzWHHuyOGIYD5eNddG7Z4UfAZm2ZWS1w_B_MNEBA5TAz_INlpxIL0hfS_VkE3WvrmF-LBPoOf2Sa3LwK_LSYYPSU-cWsv',
                    'Content-Type: application/json'
                );
                $url = 'https://fcm.googleapis.com/fcm/send';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                $result_notification = curl_exec($ch);
                $decoded = json_decode($result_notification);
                curl_close($ch);
                //die();
                if ($decoded->success == 1)
                {
                    $arrayNotification['user_id'] = (int)$request->id;
                    $arrayNotification['title'] = $request->title;
                    $arrayNotification['body'] = $request->body;
                    $arrayNotification['device_id'] = $device_id;
                    $arrayNotification['user_type'] = 2;
                    Str::thineselfInsert('notification', $arrayNotification);
                }
                else
                {
                    session()->flash('error', 'Some error occured while sending the notification...!!!');
                    return redirect()
                        ->back();
                }
                session()
                    ->flash('success', 'Notification sent successfully...!!!');
                return redirect()
                    ->back();
            }
            else
            {
                session()
                    ->flash('error', 'Doctor Id Not Found...!!!');
                return redirect()
                    ->back();
            }
        }
        else
        {
            session()
                ->flash('error', 'Fill the form to send the notification...!!!');
            return redirect()
                ->back();
        }
    }

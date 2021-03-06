<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Master;

/**
 * Description of Test
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Util\PasswordLib\TripoinCrypt;
use app\Util\PHPMail\PHPMailer;
use app\Util\RestClient;
use app\Util\TCaptcha\TCaptcha;

class Test {

    public function index() {
//        error_reporting(E_ALL);
//        ini_set('display_errors', "On");
        $im = imagecreatetruecolor(120, 20);
//        $im = imagecreate(100, 100) or die("Cannot Initialize new GD image stream");
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 1, 5, 5, 'A Simple Text String', $text_color);

//        print_r($im->getMessage);



// Set the content type header - in this case image/jpeg
//        header('Content-Type: image/jpg');
//        header("Content-Length: " . filesize($imagepath));
// Output the image
//        imagejpeg($im,  FILE_PATH('/captcha/captcha.jpg'));

// Free up memory
//        imagedestroy($im);
    }

    //put your code here
    public function test() {
        echo 'welcome';
    }

    public function migration() {
        $dbNew = new Database();
        $dbNew->connect();
//        $dbNew->sql("SELECT * FROM security_user WHERE LOWER(user_email) = 'sfandrianah2@gmail.com' AND (user_password = SHA1(CONCAT(user_salt, SHA1(CONCAT(user_salt, SHA1('fandrianah2'))))) OR user_password = '".md5('fandrianah2')."') AND status = '1' AND user_approved = '1'");
//        $rsPostNew = $dbNew->getResult();
//        print_r($rsPostNew);
//        echo '<p>';
        $dbOld = new Database();
        /*
         * $dbOld->setDb_host('192.168.1.9');
          $dbOld->setDb_name('ticketing_ecommerce');
          $dbOld->setDb_user('eth');
          $dbOld->setDb_pass('3thS1gm42016.');
         * 
         */
        $dbOld->setDb_host('localhost');
        $dbOld->setDb_name('talaind1_web');
        $dbOld->setDb_user('talaind1_dbuser');
        $dbOld->setDb_pass('galaxys6.');
//        echo $dbOld->getDb_host();
        $dbOld->connect();
        /* for ($no = 1; $no <= 34; $no++) {
          $dbOld->insert('sec_function_assignment', array(
          "id" => $no,
          "status" => 1,
          "created_by" => "admin",
          "created_ip" => "0.0.0.0",
          "created_time" =>  date(DATE_FORMAT_PHP_DEFAULT),
          "group_id" => 1,
          "function_id" => $no,
          "assignment_order" => 0,
          "action_type" => "view"
          ));
          }


          $rsPostOld = $dbOld->getResult();
         */

//        print_r($rsPostOld);
        $rsPostOld = $dbOld->getResult();
        foreach ($rsPostOld as $value) {
//            echo $publishDate.'<br/>';

            /* MIGRATION TABLE USER */
//            if($value['email'] != )
            $code = explode("@", $value['email']);
            $dbNew->insert('security_user', array(
//          'user_id' => $value['customer_id'],
                'user_code' => $code[0],
                'user_email' => $value['email'],
                'user_password' => $value['password'],
                'user_salt' => $value['salt'],
                'user_newsletter' => $value['newsletter'],
                'created_by_ip' => $value['ip'],
                'created_on' => $value['date_added'],
                'status' => $value['status'],
                'user_approved' => $value['approved'],
                'group_id' => 2,
            ));



            /* MIGRATION TABLE USER PROFILE */

            $code = explode("@", $value['email']);
            $dbNew->insert('security_user_profile', array(
//          'user_id' => $value['customer_id'],
                'user_code' => $code[0],
                'user_fullname' => $value['firstname'] . " " . $value['lastname'],
                'user_email' => $value['email'],
                'user_telp' => $value['telephone'],
            ));
        }

        /*
         * MIGRATION MANY TO MANY TABLE POST CATEGORIES
         * $dbNew->insert('mst_post_function', array(
          'post_id' => $value['post_id'],
          'function_id' => $value['category_id']
          ));
         */


        /* $dbNew->sql("select COUNT(post_code) as countCode FROM mst_post WHERE post_code='" . $value['slug'] . "'");
          $rsCountCode = $dbNew->getResult();
          if ($rsCountCode[0]['countCode'] == 0) {
          $publishDate = date("Y-m-d H:i:s", $value['publish_date']);
          $createdOn = date("Y-m-d H:i:s", $value['created_on']);
          $dbNew->insert('mst_post', array(
          'post_id' => $value['id'],
          'post_code' => $value['slug'],
          'author_code' => $value['author_slug'],
          'author_name' => $value['author'],
          'post_title' => $value['title'],
          'post_subtitle' => $value['subtitle'],
          'post_content' => $value['content'],
          'post_status' => $value['status'],
          'publish_on' => $publishDate,
          'created_on' => $createdOn,
          'created_by' => $value['created_by'],
          'modified_on' => $value['updated_on'],
          'modified_by' => $value['updated_by'],
          'post_featured' => $value['featured'],
          'post_type' => $value['type'],
          'post_url_img' => $value['image'],
          'post_url_thumbnail' => $value['thumbnail'],
          'post_template' => $value['template'],
          'post_comment_enable' => $value['comment_enable'],
          'read_count' => $value['read_count'],
          'post_extra_flag' => $value['extra_flag'],
          'status' => 1,
          ));
          }
         * 
         */
//            echo $rsCountCode[0]['countCode'];
//        }
    }

    public function hashing() {
        $tripoinCrypt = new TripoinCrypt();
//        echo $tripoinCrypt->encrypt('tripoin:Moodle123!');
//        $tripoinRestClient = new TripoinRestClient();
//        $tripoinRestClient->
//        $restClient = new RestClient();
//        $postData = array('username' => 'tripoin', 'password' => 'Moodle123!');
        echo password_hash('sigma123', PASSWORD_BCRYPT);
//
////        $resp = $restClient->to('http://54.251.168.102/e-learning/login/index.php')
////                ->setBody($postData)
////                ->setHeader(array('Content-Type: application/x-www-form-urlencoded'))
////                ->post();
////        print_r($resp);
////        $resp = $tripoinRestClient->doPOST('http://54.251.168.102/e-learning/login/index.php', array(), array(), $postData);
////        print_r($resp);
//        $dbOld = new Database();
//
//        $ch = curl_init();
////    echo rb_json_config;
//        curl_setopt($ch, CURLOPT_URL, 'http://54.251.168.102/e-learning/login/index.php');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=tripoin&password=Moodle123!');
////        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
//
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
////        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
////        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
////        curl_setopt_array($ch, $options);
//
//
//        $response = curl_exec($ch);
//        $header = curl_getinfo($ch);
//        print_r($header);
//        print_r($response);
//        curl_close($ch);

        /* $ch = curl_init();
          //    echo rb_json_config;
          curl_setopt($ch, CURLOPT_URL, 'http://54.251.168.102/e-learning/login/index.php');
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          //        curl_setopt($ch, CURLOPT_POST, 1);
          //        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=tripoin&password=Moodle123!');
          //        curl_setopt($ch, CURLOPT_COOKIE, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $response = curl_exec($ch);

          print_r($response);
          curl_close($ch);

          print_r($_COOKIE);
          //         $cookie_name = "MoodleSession";
          //        $cookie_value = 'fff900ggga21gp2lcp7q7o9h94';
          //        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
          /*
         * $dbOld->setDb_host('192.168.1.9');
          $dbOld->setDb_name('ticketing_ecommerce');
          $dbOld->setDb_user('eth');
          $dbOld->setDb_pass('3thS1gm42016.');
         * 
         */
        /*     $dbOld->setDb_host('54.251.168.102');
          $dbOld->setDb_name('e_learning');
          $dbOld->setDb_user('bkn');
          $dbOld->setDb_pass('bknP@ssw0rd123');
          $dbOld->connect();
          $encode = json_decode($resp->getHeader, true);
          //        print_r($encode);
          $str = 'Set-Cookie';
          $ex_s = explode("=", $encode[$str]);
          $ex_s2 = explode(";", $ex_s[1]);
          //        echo $ex_s2[0];
          $dbOld->insert('mdl_sessions', array(
          'sid' => $ex_s2[0],
          'userid' => '2',
          ));
          //        print_r($dbOld->getResult());
          $cookie_name = "MoodleSession";
          $cookie_value = $ex_s2[0];
          setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
         * 
         */

//        $restClient = new RestClient();
//        $resp2 = $restClient->to('http://54.251.168.102/e-learning/login/index.php')
//                ->setParam(array('testsession' => '2'))
//                ->setHeader(
//                        array('MoodleSession: ' . $ex_s2[0], 'Content-Type: application/x-www-form-urlencoded', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'))
//                ->get();
//        $encode2 = json_decode($resp2->getHeader, true);
//        print_r($encode2);
//        echo '<iframe src="http://54.251.168.102/e-learning"  height="1200" width="1200"></iframe>';
//        echo password_hash('trijep3t3', PASSWORD_BCRYPT);
//        $tripoinCrypt = new TripoinCrypt();
//        $user = array("code" => "12345", "password" => "admin123");
////        print_r($tripoinCrypt->encrypt('admin:admin'));
//        for ($i = 1; $i <= 10; $i++) {
//            $j = $i * 2;
////            echo $j . ' ';
//        }

        /*
         * Input deret yang akan di eksekusi
         * $input : adalah variabel input dengan type aray untuk membuat deret, dan mempunyai key parent array nya yaitu
         * length : panjang untuk deret nya,
         * Pada Array Key Data mempunyai 3 key yang harus di isi untuk membuat deret aritmatika atau deret geometri
         * 1. (Integer) firstValue : Nilai Pertama pada Deret
         * 2. (String) type : type deret , jika (+)=>Penambahan/Deret Aritmatika,(*)=>Perkalian/Deret Geometri
         * 3. (Integer) calculate : Penjumlahan untuk nilai selanjut nya
         * Result Example 
         * Jika kita membuat data input seperti ini :
         * $input = array(
         *    "length" => 4,
         *    "data" => [
         *        array("firstValue" => 4, "type" => "+", "calculate" => 3),
         *        array("firstValue" => 2, "type" => "*", "calculate" => 3)
         *    ],
         * );
         * maka resultnya
         * [0]=>4 7 10 13,
         * [1]=>2 6 18 54,
         */
        /*
          $input = array(
          "length" => 4,
          "data" => [
          array("firstValue" => 4, "type" => "+", "calculate" => 3),
          array("firstValue" => 2, "type" => "*", "calculate" => 3)
          ],
          );

          $hitungValue = 0;
          $result = array();
          $result_deret = array();
          foreach ($input['data'] as $value) {
          for ($no = 0; $no < $input['length']; $no++) {
          if ($no == 0) {
          $hitungValue = $value['firstValue'];
          } else {
          if ($value['type'] == "*") {
          $hitungValue = $hitungValue * $value['calculate'];
          } else if ($value['type'] == "+") {
          $hitungValue = $hitungValue + $value['calculate'];
          } else if ($value['type'] == "-") {
          $hitungValue = $hitungValue - $value['calculate'];
          } else if ($value['type'] == "/") {
          $hitungValue = $hitungValue / $value['calculate'];
          }
          }
          $result_deret[] = $hitungValue;
          }
          $result[] = $result_deret;
          $result_deret = array();
          }
          echo 'Mencetak semua Deret<br/>';
          foreach ($result as $value) {
          echo implode(' ',$value)."<br/>";
          }

          echo '<br/>Output<br/>';
          echo "AP " . end($result[0]).'<br/>';
          echo "GP " . end($result[1]);

          $data = array(
          array(4, 7, 10),
          array(2, 6, 18),
          );
          $no = 0;
          foreach ($data as $value) {
          $no++;
          }
         * 
         */
    }

    public function testMail() {
        $pic_name = "Syahrial Fandrianah";
        $pic_email = "sfandrianah2@gmail.com";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();

            $mail->Debugoutput = 'html';
            $mail->SMTPDebug = 4;
            $mail->Host = MAIL_HOST;
//            $mail->MessageID = "<721c8cc0-d7f9-419d-a833-8e24ca5fbce8@email.android.com>";
//            $mail->ContentType = "multipart/mixed; boundary=\"----OT8XXE9JORYX4R6QORCCRKUESJGIU4";
//            $mail->Mim
//        $mail->SMTPDebug  = 2;

            /*       $mail->Port = 465;
              $mail->SMTPSecure = 'ssl';
              $mail->SMTPAuth = true;

              $mail->Username = "talaindonesia2@gmail.com";
              $mail->Password = "t4l4indonesia";
             */
            $mail->Port = MAIL_SMTP_PORT;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = false;
//        $mail->SMTPAutoTLS = ['ssl'=> ['allow_self_signed' => true]];

            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;


            $mail->isHTML(true);

//Set who the message is to be sent from
            $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
            $mail->addReplyTo($pic_email, $pic_name);

//Set who the message is to be sent to
            $mail->addAddress($pic_email, $pic_name);
            $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
            $mail->Subject = 'Validasi Reset Password';
            $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="70" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Halo ' . $pic_name . ',
                        <br/><br/>
                       ' . lang('general.message_register_member') . '
                        
                        <br/>
                        <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
            if ($mail->smtpConnect()) {
                $mail->smtpClose();
                if (!$mail->send()) {
                    echo $mail->ErrorInfo;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    public function testParam($param) {
        echo 'masuk-s' . $param;
    }

}

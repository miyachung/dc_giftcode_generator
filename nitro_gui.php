<?php
@error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
@set_time_limit(0);
@ini_set('max_execution_time',0);
@ini_set('memory_limit','2096M');
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miyachung's Discord Nitro Generator</title>

    <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
      * {
            margin:0;
            padding:0;
            outline:0;
            box-sizing:border-box;
            list-style:none;
            font-family:Poppins, sans-serif;

      }
      body{
            width:100%;
            height:100vh;
            background: #edf0ee;
            display:flex;
            align-items:center;
            justify-content:center;
      }
      .box{
            width:80%;
            height:700px;
            border-radius:10px;
            background:#fff;
            display:flex;
            flex-direction:column;
            flex-wrap:wrap;
            box-shadow: 0 5px 10px rgba(0,0,0, 0.15);
      }
      .box .container{
            width:95%;
            margin: 20px auto;
      }
      .box .container .title{
            width:100%;
            display:block;
            margin-bottom:10px;
      }
      .box .container .title::after{
            content:'';
            width:100%;
            margin-top:5px;
            background:#eee;
            height:1px;
            display:block;
      }
      .box .container .title h3{
            font-size:24px;
            font-weight:500;
      
      }
      
      .box .container .form_area{
            width:500px;
      }
      .box .container .form_area form input{
            margin-bottom:5px;
      }
      .box .container .form_area form input[type="text"]:focus,
      .box .container .form_area form input[type="text"]:hover,
      .box .container .form_area form select:hover,
      .box .container .form_area form input[type="text"]:valid{
            border:1px solid rgba(0,0,0, 0.7);
      }
      .box .container .form_area form input[type="text"],.box .container .form_area form select{
            width:100%;
            height:35px;
            border-radius:5px;
            border:1px solid #eee;
            padding:0 10px;
            margin-bottom:10px;
      }
      .box .container .form_area form select{
            cursor:pointer;
      }
      .box .container .form_area form input[type="checkbox"]{
            height:12px;
            margin-right:7px;
      
      }
      .box .container .form_area form label{
            font-size:14px;
            cursor:pointer;
      }

      .box .container .form_area button{
            display:block;
            margin-top:25px;
            background:#348ceb;
            opacity:80%;
            color:#fff;
            border-radius:5px;
            width:250px;
            padding:5px 15px;
            height:45px;
            border:none;
            font-size:16px;
            cursor:pointer;
            transition:200ms all;
            box-shadow:0 5px 8px rgba(0,0,0, 0.15);
      }
      .box .container .form_area button:hover{
            opacity:100%;
            transform: scale(1.01);
      }

      #proxy:checked ~ #proxycheck{
            pointer-events:none;
      }

      .box .container .results{
            width:100%;
            display:inline-block;
            height:430px;
            overflow:auto;
            margin-top:15px;
            font-size:13px;
            position:relative;
      }

      .results textarea{
            width:50%;
            height:150px;
            resize:none;
            border-radius:5px;
            border:1px solid #eee;
            padding:10px;
      }

      .alert{
            width:100%;
            height:35px;
            background: #fa2a42;
            padding:20px 10px;
            color:#fff;
            font-size:16px;
            display:flex;
            align-items:center;
      }

      .info{
            width:100%;
            height:35px;
            background: #347ff7;
            padding:20px 10px;
            color:#fff;
            font-size:16px;
            display:flex;
            align-items:center;
      }
      
      .success{
            width:100%;
            height:35px;
            background: lightgreen;
            padding:20px 10px;
            color:#fff;
            font-size:16px;
            display:flex;
            align-items:center;
      }
      .success a{
            color:#fff;
            margin-left:5px;
      }

      .labels{
            margin-top:15px;
            display:flex;
            align-items:center;
      }
      .lab {
            margin-left:3px;
            display:flex;
            align-items:center;
      }
      .lab p{
            margin-left:4px;
            font-size:12px;
      }
      .lab input{
      display:none;
      }

      .lab .incb{
      width:36px;
      height:16px;
      display:inline-block;
      background:#ddd;
      border-radius:16px;
      position:relative;
      }
      .lab .incb span{
      box-shadow:0 5px 10px rgba(0,0,0,0.15);
      position:absolute;
      width:20px;
      height:20px;
      background:#eee;
      border-radius:50%;
      top:-2px;
      left:0;
      transition:200ms left;
      }
      .lab input:checked + .incb {
      background:rgba(3, 127, 252,.7);
      }
      .lab input:checked + .incb span{
      background:rgba(3, 127, 252);
      left:17px;
      }

      @media screen and (max-width:648px){
            .box .container .form_area {
                  width: 100%;
            }
            .labels {
            flex-direction: column;
            display: inline-flex;
            width: 100%;
            align-items: start;
            }
            .box .container .form_area button{
                  width:170px;
            }
            .box .container .title h3{
                  font-size:18px;
                  width:100%;
            }
      }
      @media screen and (max-height:504px){
            .box .container .title h3 {
            font-size: 18px;
            width: 100%;
            margin-top: 85px;
            }
      }
            
    </style>
</head>
<body>


<div class="box">
      <div class="container">

             <div class="title"><h3>Miyachung's Discord Nitro Generator</h3></div>

             <div class="form_area">
                  <form method="post" action="">
                        <?php if(!empty($_POST['amount'])){
                        ?>
                        <input type="text" name="amount" value="<?=$_POST['amount'];?>" required autocomplete="off" />

                        <?php }else{ ?>
                        <input type="text" name="amount" placeholder="How many codes would you like to generate?" required autocomplete="off" />
                        <?php } ?>
                        <select name="nitro_type">
                              <option value="chars16" <?php if($_POST['nitro_type'] == "chars16") print "selected";?>>Discord Nitro 16 chars</option>
                              <option value="chars19" <?php if($_POST['nitro_type'] == "chars19") print "selected";?>>Discord Nitro 19 chars</option>
                              <option value="chars24" <?php if($_POST['nitro_type'] == "chars24") print "selected";?>>Discord Nitro 24 chars</option>
                        </select>
                        <div class="labels">
                        <label for="checkcodes" class="lab">
                        <input type="checkbox" name="checkcodes" id="checkcodes" checked/>
                        <span class="incb">
                        <span></span>
                        </span>
                        <p>Check Codes</p>
                        </label>
                        <label for="proxy" class="lab">
                        <input type="checkbox" name="proxy" id="proxy" checked/>
                        <span class="incb">
                        <span></span>
                        </span>
                        <p>Use Proxy</p>
                        </label>
                        <label for="proxycheck" class="lab">
                        <input type="checkbox" name="proxycheck" id="proxycheck" disabled/>
                        <span class="incb">
                        <span></span>
                        </span>
                        <p>Check Proxies</p>
                        </label>
                        <label for="proxyscrape" class="lab">
                        <input type="checkbox" name="proxyscrape" id="proxyscrape" disabled/>
                        <span class="incb">
                        <span></span>
                        </span>
                        <p>Auto Proxy Scrape</p>
                        </label>
                        </div>
                        <button type="submit">Generate Codes</button>
                  </form>

             </div>

             <div class="results">
                  <?php
                        start();
                  ?>
             </div>

      </div>
</div>
    
</body>
</html>

<?php
/*
        .__                      .__                          
  _____ |__|___.__._____    ____ |  |__  __ __  ____    ____  
 /     \|  <   |  |\__  \ _/ ___\|  |  \|  |  \/    \  / ___\ 
|  Y Y  \  |\___  | / __ \\  \___|   Y  \  |  /   |  \/ /_/  >
|__|_|  /__|/ ____|(____  /\___  >___|  /____/|___|  /\___  / 
      \/    \/          \/     \/     \/           \//_____/ 

    
      * Miyachung's discord nitro generator
      * Coding by miyachung
*/



function start(){

      if($_POST){
            $amount      = $_POST['amount'];
            $nitro_type  = $_POST['nitro_type'];
            $checkcodes  = $_POST['checkcodes'];
            $proxy       = $_POST['proxy'];

            if(empty($amount)) die('<div class="alert">You have to give an amount to generate codes</div>');
            if(!is_numeric($amount)) die('<div class="alert">You have to give a number</div>');
            print '<div class="info">Generating codes..</div>';
            ob_end_flush();
            flush();
            ob_flush();
            usleep(10000);
            $codes = generate_codes($amount,$nitro_type);
            if($checkcodes){
                  @file_put_contents("codes.txt",implode(PHP_EOL,$codes));
                  print '<div class="success">Generated '.count($codes).' unique codes,saved in to file : <a href="codes.txt" target="_blank">codes.txt</a></div>';
                  ob_end_flush();
                  flush();
                  ob_flush();

                  if($proxy){
                        print '<div class="info">Scraping proxies..</div>';
                        ob_end_flush();
                        flush();
                        ob_flush();
                        usleep(10000);
                        $proxies = scrape_proxies();
                        $proxies = array_filter($proxies);
                        $proxies = array_unique($proxies);

                        if($proxies){
                              @file_put_contents("proxies.txt",implode(PHP_EOL,$proxies));
                              print '<div class="success">Total collected proxies : '.count($proxies).', saved in to file : <a href="proxies.txt" target="_blank">proxies.txt</a></div>';
                              ob_end_flush();
                              flush();
                              ob_flush();
                              print '<div class="info">Checking codes & proxies..</div>';
                              ob_end_flush();
                              flush();
                              ob_flush();
                              
                              check_codes($proxies,$codes);                              

                        }else{
                              print '<div class="alert">Error ! Could not scrape proxy</div>';
                        }

                  }else{
                        print '<div class="alert">You have to enable proxy because discord bans around 4-5 requests :)</div>'; 
                  }
         

            



            }else{
                  print '<div class="title"><h3>Generated Codes</h3></div>';
                  print '<textarea>'.implode("\r\n",$codes).'</textarea>';
            }


      }
}

function check_codes($proxies,$codes){
      if(empty($proxies) || !$proxies){
            print '<div class="alert">There are no proxies in the list,scraping new proxies..</a></div>';
            follow_scroll();
            ob_end_flush();
            flush();
            ob_flush();
            $proxies = scrape_proxies();
            $proxies = array_filter($proxies);
            $proxies = array_unique($proxies);
      }
      $proxy_count = count($proxies);
      if(count($codes) == 1){
            exit('<div class="info">Miyachung\'s Discord Nitro Generator has completed the scan</div>');
      }
      foreach($proxies as $key => $proxy){
            foreach($codes as $code_key => $code){
            $url = 'https://discord.com/api/v8/entitlements/gift-codes/'.$code.'?with_application=true&with_subscription_plan=true';
            
            
            $req =  request($url,$proxy);

            if($req == "code_valid"){
                  echo '<div class="success">Discord Nitro gift code found ! <a href="https://discord.gift/'.$code.'" target="_blank">https://discord.gift/'.$code.'</a></div>';
                  follow_scroll();
                  ob_end_flush();
                  flush();
                  ob_flush();
                  save("valid_codes.txt","https://discord.gift/$code");
            }elseif($req == "proxy_switch"){
                  echo '<div class="info">You are being rate limited , Proxy: '.$proxy.' , switching proxy.. [ CURRENT PROXIES IN THE LIST : '.$proxy_count.' ]</div>';
                  follow_scroll();
                  ob_end_flush();
                  flush();
                  ob_flush();    
                  unset($proxies[$key]);
                  $new     = $proxies;
                  $new2    = array_slice($codes,$code_key);     
                  $proxies = null;
                  $codes   = null;   
                  check_codes($new,$new2);
            }elseif($req == "invalid_code"){
                  echo '<div class="alert">Unknown Gift Code: '.$code.'</div>';
                  follow_scroll();
                  ob_end_flush();
                  flush();
                  ob_flush();      
                  save("invalid_codes.txt",$code);
            }else{
                  echo '<div class="info">Proxy failed : '.$proxy.',switching.. [ CURRENT PROXIES IN THE LIST : '.$proxy_count.' ]</div>';
                  follow_scroll();
                  ob_end_flush();
                  flush();
                  ob_flush();
                  unset($proxies[$key]);
                  $new     = $proxies;
                  $new2    = array_slice($codes,$code_key);     
                  $proxies = null;
                  $codes   = null;     
                  check_codes($new,$new2);
            }
               
            }
      }
}
function request($url , $proxy){
      $curl = curl_init();
      curl_setopt_array($curl,[CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url,
      CURLOPT_NOBODY => 1,
      CURLOPT_PROXY => $proxy,
      CURLOPT_TIMEOUT => 10, 
      CURLOPT_CONNECTTIMEOUT => 10]);

      curl_exec($curl);
      $info = curl_getinfo($curl);

      $response_code  = $info['http_code'];
      if($response_code == 200){
            return "code_valid";
      }elseif($response_code == 429){
            return "proxy_switch";
      }elseif($response_code == 404){
            return "invalid_code";
      }else{
            return "unknown_error_code_$response_code";
      }

}
function generate_codes($amount,$type){

      $codes = [];
      $codes = array_flip($codes);
      $dict  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
      $length = strlen($dict);


      if($type == "chars16"){
            // Discord Nitro Code 16 chars

            for($x = 0; $x < $amount; $x++){
                  $code = "";
                  while(strlen($code) < 16){
                        $code .= $dict[rand(0,$length)];
                  }
                  if(! $codes[$code]){
                        array_push($codes,$code);
                  }
            }
      

      }elseif($type == "chars19"){
            // Discord Nitro Code 19 chars
        
            for($x = 0; $x < $amount; $x++){
                  $code = "";
                  while(strlen($code) < 19){
                        $code .= $dict[rand(0,$length)];
                  }
                  if(! $codes[$code]){
                        array_push($codes,$code);
                  }
            }
      }elseif($type == "chars24"){
            // Discord Nitro Code 24 chars
      
            for($x = 0; $x < $amount; $x++){
                  $code = "";
                  while(strlen($code) < 24){
                        $code .= $dict[rand(0,$length)];
                  }
                  if(! $codes[$code]){
                        array_push($codes,$code);
                  }
            } 
      }

      return $codes;
}

function scrape_proxies(){

      $collect = [];
      array_flip($collect);
      $links = ['https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=250&country=all&ssl=all&anonymity=all',
                'https://www.free-proxy-list.net/',
                'https://spys.me/proxy.txt'
            ];
      foreach($links as $link){
            $read = @file_get_contents($link);
            if($read){
                  
                  if(stristr($link,"free-proxy")){
                        preg_match_all('/<td>(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})<\/td>/',$read,$ips);
                        preg_match_all('/<td>(\d{2,5})<\/td>/',$read,$ports);


                        array_map('trim',array_filter($ips[1]));
                        array_map('trim',array_filter($ports[1]));

                        foreach($ips[1] as $key => $ip)
                        {
                              if(!$collect[$ip.':'.$ports[1][$key]]){
                                    $collect[] = $ip.':'.$ports[1][$key];
                              }
                        }
                  }elseif(stristr($link,"spys.me")){
                        preg_match_all('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})/',$read,$proxiez);

                        foreach($proxiez[0] as $proxy){
                              $proxy = trim($proxy);

                              if(!$collect[$proxy]){
                                    $collect[] = $proxy;
                              }
                        }
                        
                  }else{
                        $explode = explode(PHP_EOL,$read);
                        $c = 0;
                        foreach($explode as $r){
                              if(!$collect[$r]){
                                    array_push($collect,$r);
                                    ++$c;
                              }
                        }      
                  }


            }else{
                  print "<div class='alert'>$link could not read the proxy url!</div>";
            }
      }
      return $collect;
}

function save($file,$content){
      $fopen = @fopen($file,'ab');
      fwrite($fopen,$content.PHP_EOL);
      fclose($fopen);
}
function follow_scroll(){
      print "
      <script>
            var current_height = document.querySelector('.results').scrollHeight;
            document.querySelector('.results').scrollTo(0,current_height);
      </script>
      ";
}
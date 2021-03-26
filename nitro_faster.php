<?php
/*
        .__                      .__                          
  _____ |__|___.__._____    ____ |  |__  __ __  ____    ____  
 /     \|  <   |  |\__  \ _/ ___\|  |  \|  |  \/    \  / ___\ 
|  Y Y  \  |\___  | / __ \\  \___|   Y  \  |  /   |  \/ /_/  >
|__|_|  /__|/ ____|(____  /\___  >___|  /____/|___|  /\___  / 
      \/    \/          \/     \/     \/           \//_____/ 

    
      * Miyachung's discord nitro generator
      * Features ;
        -> Code Checker (Fast http requests with multi curl)
        -> Proxy Scraper
        -> Proxy Checker
      * Coding by miyachung


      Usage ( Command Line ); 

        -> Code Lengths : 16 , 19 , 24

      php [SCRIPT.PHP] [CODE_LENGTH] [CODE_AMOUNT] [THREAD]
*/

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
@ini_set('max_execution_time',0);
@ini_set('memory_limit','2094M');
@set_time_limit(0);

$code_length = is_numeric($argv[1]) ? $argv[1] : die("Give code length to argument 1!");
$code_amount = is_numeric($argv[2]) ? $argv[2] : die("Give code number which is going to be generated randomly to argument 2!");
$thread      = is_numeric($argv[3]) ? $argv[3] : die("Give thread number argument 3!");

while(true){
$codes       = generate_codes($code_length,$code_amount);
//@file_put_contents("codes.txt",implode(PHP_EOL,$codes));
@unlink("invalid_codes.txt");
$code_count  = count($codes);
printf('[INFO] Generated %s random codes to check..'.PHP_EOL, $code_count);
printf('[INFO] %s requests are going to work simultaneously on %s codes....'.PHP_EOL,$thread,$code_count);


worker($codes);
}

function worker($codes){
    global $thread,$code_length;
    $proxies     = scrape_proxies();
    @file_put_contents("proxies.txt",implode(PHP_EOL,$proxies));
    $proxy_count = count($proxies);

    printf('[INFO] Grabbed %s proxies from the urls..'.PHP_EOL, $proxy_count);
    print '[INFO] Setting up proxies to codes'.PHP_EOL;


    $merge      = list_merger($codes,$proxies);
    $chunk      = array_chunk($merge,$thread);
    $multi      = curl_multi_init(); 
    $retry_list = array();


    foreach($chunk as $chunked){
        $curl = array();
        foreach($chunked as $x => $code_and_proxy){

            list($code,$proxy) = explode('|',$code_and_proxy);
            $code = generate_single($code_length);
            $url = 'https://discord.com/api/v6/entitlements/gift-codes/'.$code.'?with_application=true&with_subscription_plan=true';

            $curl[$x] = curl_init();

            curl_setopt_array($curl[$x],[CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_PROXY =>  $proxy,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 10, 
            CURLOPT_PRIVATE => $code]);
            curl_multi_add_handle($multi,$curl[$x]);
        }

        do{

            while (($execrun = curl_multi_exec ($multi, $active)) == CURLM_CALL_MULTI_PERFORM);            if(curl_multi_select($multi) == -1) usleep(100);
            if ($execrun != CURLM_OK) break;

            if(curl_multi_select($multi) == -1) usleep(100);

            while($read = curl_multi_info_read($multi)){
                $info1   = curl_getinfo($read['handle']);
                $info_key= curl_getinfo($read['handle'],CURLINFO_PRIVATE);
                $content = curl_multi_getcontent($read['handle']);
                $json = json_decode($content);

                $http_code = $info1['http_code'];

                if($http_code == 200){
                    printf('%s %s %s', $info_key,$json->message,PHP_EOL);
                    save("valid_codes.txt","https://discord.gift/".$info_key." ".$json->message);
                }elseif($http_code == 429){
                    //printf('%s %s %s', $curl['proxy'][$info2],$json->message,PHP_EOL);
                    $retry_list[] = $info_key;
                }elseif($http_code == 404){
                    printf('%s %s %s', $info_key,$json->message,PHP_EOL);
                    save("invalid_codes.txt",$info_key." ".$json->message);
                }else{
                   // printf('%s proxy failed%s', $curl['proxy'][$info2],PHP_EOL);
                    $retry_list[] = $info_key;
                }

                curl_multi_remove_handle($multi,$read['handle']);
            }

        }while($active > 0);

        foreach($curl as $ch){
            @curl_close($ch);
            unset($ch);
        }
    }
    curl_multi_close($multi);

    $count_retry = count($retry_list);

    if(!empty($retry_list) && $count_retry > 100){
        printf('There are %s codes in retry list,checking will continue..%s',$count_retry,PHP_EOL);
        worker($retry_list);
    }else{
        print 'All codes have been checked'.PHP_EOL;
    }

}

function list_merger($codes,$proxies){

    $merged_list = [];
    shuffle($proxies);
    foreach($codes as $code){
        $merged_list[]  = $code.'|'.$proxies[array_rand($proxies)];
    }
    return array_unique($merged_list);
}

function scrape_proxies(){

    $collect = [];
    array_flip($collect);
    $links = ['https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=50&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=all&timeout=500&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=100&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=150&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=250&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=https&timeout=50&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=https&timeout=100&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=https&timeout=150&country=all&ssl=all&anonymity=all',
              'https://api.proxyscrape.com/?request=getproxies&proxytype=https&timeout=250&country=all&ssl=all&anonymity=all',
              'https://www.proxy-list.download/api/v1/get?type=http',
              'https://www.proxy-list.download/api/v1/get?type=https',
              'https://www.proxy-list.download/api/v1/get?type=socks4',
              'https://www.proxy-list.download/api/v1/get?type=socks5',
              'https://www.free-proxy-list.net/',
              'https://www.us-proxy.org/',
              'https://raw.githubusercontent.com/fate0/proxylist/master/proxy.list',
              'https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list.txt',
              'https://raw.githubusercontent.com/scidam/proxy-list/master/proxy.json',
              'https://raw.githubusercontent.com/sunny9577/proxy-scraper/master/proxies.json',
              'https://raw.githubusercontent.com/ShiftyTR/Proxy-List/master/proxy.txt',
              'https://raw.githubusercontent.com/TheSpeedX/SOCKS-List/master/http.txt',
              'https://www.hide-my-ip.com/proxylist.shtml',
              'https://proxylist.icu/proxy/1',
              'https://proxylist.icu/proxy/2',
              'https://proxylist.icu/proxy/3',
              'https://proxylist.icu/proxy/4',
              'https://proxylist.icu/proxy/5',
              'https://www.sslproxies.org/',
              'http://www.httptunnel.ge/ProxyListForFree.aspx',
              'https://spys.me/proxy.txt'
          ];
    foreach($links as $link){
        $curl = curl_init();
        curl_setopt_array($curl,[CURLOPT_RETURNTRANSFER => 1,CURLOPT_URL => $link]);
        $read = curl_exec($curl);
        curl_close($curl);

          if($read){
            
            if(stristr($link,"sunny9577/proxy-scraper/master/proxies.json")){

                $decode = json_decode($read);
                foreach($decode->proxynova as $p){
                    $ip_and_port = $p->ip.":".$p->port;
                    if(!$collect[$ip_and_port]){
                        $collect[] = $ip_and_port;
                    } 
                }
            }elseif(stristr($link,"fate0/proxylist/master/proxy.list")){

                preg_match_all('@"host": "(.*?)", "type": "(.*?)", "port": (.*?), @',$read,$fate0);
                foreach($fate0[3] as $key => $fateip){
                    $ip_port = $fateip.":".$fate0[1][$key];
                    if(!$collect[$ip_port]){
                        $collect[] = $ip_port;
                    } 
                }
            }elseif(stristr($link,"clarketm/proxy-list/master/proxy-list.txt")){
                preg_match_all('@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})@si',$read,$clarketm);

                $clarketm[1] = array_unique($clarketm[1]);

                foreach($clarketm[1] as $clark){
                    if(!$collect[$clark]){
                        $collect[] = $clark;
                    } 
                }
            }elseif(stristr($link,"proxy-list.download")){
                $explode = array_filter(array_unique(explode("\n",$read)));
                foreach($explode as $e){
                    if(!$collect[$e]){
                        $collect[] = $e;
                    } 
                }
            }elseif(stristr($link,"TheSpeedX/SOCKS-List/master/http.txt")){
                preg_match_all('@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})@si',$read,$speedx);

                $speedx[1] = array_unique($speedx[1]);

                foreach($speedx[1] as $speed){
                    if(!$collect[$speed]){
                        $collect[] = $speed;
                    } 
                }
            }elseif(stristr($link,"ShiftyTR/Proxy-List/master/proxy.txt")){

                $explode = array_filter(array_unique(explode("\n",$read)));
                foreach($explode as $e){
                    if(!$collect[$e]){
                        $collect[] = $e;
                    } 
                }
            }elseif(stristr($link,"scidam/proxy-list/master/proxy.json")){

                $decode = json_decode($read);
                foreach($decode->proxies as $p){
                    $ip_and_port = $p->ip.":".$p->port;
                    if(!$collect[$ip_and_port]){
                        $collect[] = $ip_and_port;
                    } 
                }

            }elseif(stristr($link,"httptunnel")){

                preg_match_all('@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})@si',$read,$httptunnel);

                $httptunnel[1] = array_unique($httptunnel[1]);

                foreach($httptunnel[1] as $tunnel){
                    if(!$collect[$tunnel]){
                        $collect[] = $tunnel;
                    } 
                }

            }elseif(stristr($link,"us-proxy")){

                preg_match_all('@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})@si',$read,$usproxy);
                    
                foreach($usproxy[1] as $us){
                    if(!$collect[$us]){
                        $collect[] = $us;
                    } 
                }

            }elseif(stristr($link,"sslproxies")){

                    preg_match_all('@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})@si',$read,$sslproxies);
                    
                    foreach($sslproxies[1] as $ssl){
                        if(!$collect[$ssl]){
                            $collect[] = $ssl;
                        } 
                    }

                }elseif(stristr($link,"proxylist")){

                    preg_match_all('@<td>(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{2,5})</td>@si',$read,$proxylist);

                    foreach($proxylist[1] as $proxy){
                        if(!$collect[$proxy]){
                            $collect[] = $proxy;
                        } 
                    }
                }elseif(stristr($link,"hide-my-ip")){
                    
                    preg_match_all('@{"i":"(.*?)","p":"(.*?)",@si',$read,$hidemyip);

                    if(!empty($hidemyip[1])){
                        foreach($hidemyip[1] as $x => $prox){
                            if(!$collect[$prox.":".$hidemyip[2][$x]]){
                                $collect[] = $prox.":".$hidemyip[2][$x];
                            } 
                        }
                    }

                }elseif(stristr($link,"free-proxy")){
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
                print "[INFO] $link could not read the proxy url!".PHP_EOL;
          }
    }
    $collect = array_filter($collect);
    $collect = array_unique($collect);
    return $collect;
}

function generate_codes($len,$amount){

    $codes = [];
    $codes = array_flip($codes);
    $dict  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
    $length = strlen($dict);

        for($x = 0; $x < $amount; $x++){
            $code = "";
            while(strlen($code) < $len){
                    $code .= $dict[rand(0,$length)];
            }
            if(! $codes[$code]){
                    array_push($codes,$code);
            }
        }
    return array_unique($codes);
}

function generate_single($len){

    $dict  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
    $length = strlen($dict);
    $code = "";
    while(strlen($code) < $len){
            $code .= $dict[rand(0,$length)];
    }
    return $code;
}

function save($file,$content){
    $fopen = fopen($file,'ab');
    if(flock($fopen,LOCK_EX)){
        fwrite($fopen,$content.PHP_EOL);
        flock($fopen,LOCK_UN);
    }
    fclose($fopen);
}
<html>

<head>
    <title>JWT Encode/Decode</title>
    
    <style>
        body{
            background-color: #808080;
        }
        h1 { 
            color: black; 
            font-family: 'Lato', sans-serif; 
            font-size: 45px; 
            font-weight: 300; 
            line-height: 58px; 
            margin: 0 0 58px; 
        }

        #encoded{
            position: absolute;
            top: 15%;
            left: 1%;
            background-color: #E6E6E6;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 10px;
            width: auto;
            height: auto;
        }
        #encoded h3{
            background-color: #9F9FFF;
            padding-top: 15px;
            margin-top: 5px;
            height: 40px;
            border-radius: 10px; 
        }
       
        #decoded{
            position: absolute;
            top: 14%;
            left: 55%;
            background-color: #E6E6E6;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 10px;
            width: auto;
            height: auto;
        }
        #decoded h3{
            background-color: #9F9FFF;
            padding-top: 15px;
            margin-top: 5px;
            height: 40px;
            border-radius: 10px;
        }
        
        #decoded p{
            padding: 0px;
            margin-top: 5px;
        }
         #form2{
            padding-top: 0; 
        }
        #formAlgorithm{
            position: absolute;
            left: 44%;
            top: 10%;
            padding: 5px;
            width: auto;
            height: auto;
            background-color: #CCCCCC;
            border-radius: 10px;
        }
        #chiavi{
            display: none;
        }
        #counter{
            position: absolute;
            bottom: 0;
            left: 0%;
            width: 100%;
            height: auto;
            background-color: darkgrey;
            text-align: center;
            
        }
        #counter p{
            color: black;
            font-size: 20;
            font-style: italic;
        }
    
    </style>
    
    <script>
        
        function show(){
            
            if(document.getElementById("select").value == "RS256"){
                document.getElementById("chiavi").style.display = "block";
            }
            else{
                document.getElementById("chiavi").style.display = "none"; 
            }
        }
       
        function clickCounter() {
            if(typeof(Storage) !== "undefined") {

                if (localStorage.clickcount) {
                    localStorage.clickcount = Number(localStorage.clickcount)+1;
                } else {
                    localStorage.clickcount = 1;
                }
            } else {
                document.getElementById("numberD_E").innerHTML = "Sorry, your browser does not support web storage...";
            }
        }
        function printCounter(){
            document.getElementById("numberD_E").innerHTML = "You have encoded/decoded " + Number(localStorage.clickcount) + " time(s).";
        }
    </script>
</head>
    
        <?php
        
        require_once 'php-jwt/src/JWT.php';
        require_once 'php-jwt/src/BeforeValidException.php';
        require_once 'php-jwt/src/SignatureInvalidException.php';
        require_once 'php-jwt/src/ExpiredException.php';
		use Firebase\JWT\JWT;

        $infoJSON = "";
        $key = "";
        $publicKey = "";
        $privateKey = "";
        $jwt = "";
        $decoded = "";

        if(!empty($_POST['infoJWT'])){
            $infoJWT = $_POST['infoJWT'];
            
            $key = $infoJWT["jwtKey"];

            if($key == ''){
                $key = "example_key";
            }


            $tks = explode('.', $infoJWT["jwtString"]);
            list($headb64, $payload, $cryptob64) = $tks;
            $algoritmo = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64));
            $decoded = JWT::urlsafeB64Decode($payload);

            try{
                $valid = JWT::verify("$headb64.$payload",JWT::urlsafeB64Decode($cryptob64),$key,$algoritmo->alg);
            }catch (Exception $e){
                $valid = false;
            }
            $jwt = $infoJWT["jwtString"];
        }
        
        if(!empty($_POST['jwtJSON'])){
            
            $infoJSON = $_POST['jwtJSON'];
            if(($infoJSON['publicKey'] == '')&&($infoJSON['privateKey'] == '')){
                $key = "example_key";
                $jwt = JWT::encode($infoJSON['payload'], $key);
                
                $decoded = JWT::decode($jwt, $key, array('HS256'));
                
                $publicKey = "";
                $privateKey = "";
            }
            else{
                try{
                    $publicKey = $infoJSON['publicKey'];
                    $privateKey = $infoJSON['privateKey'];
                
                    $jwt = JWT::encode($infoJSON['payload'], $privateKey, 'RS256');

                    $decoded = JWT::decode($jwt, $publicKey, array('RS256'));
                 }catch(Exception $e){
                    echo 'Invalid Signature!';
                }
            }
            /*$url='http://travistidwell.com/blog/2013/09/06/an-online-rsa-public-and-private-key-generator/';
            // using file() function to get content
            $lines_array=file($url);
            // turn array into one variable
            $lines_string=implode('',$lines_array);
            //output, you can also save it locally on the server
            echo $lines_string;*/
            /*$publicKey = <<<EOD
            -----BEGIN PUBLIC KEY-----
            MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
            4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
            0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
            ehde/zUxo6UvS7UrBQIDAQAB
            -----END PUBLIC KEY-----
            EOD;*/
            /*
            $pieces = explode(",", $infoJSON);
            var_dump($pieces);
            
            $res = openssl_pkey_new($pieces);
            var_dump($res);
            $key = openssl_get_publickey($res);
            */
        }
    
    ?>
<body onload="printCounter()">
    <?php
        
        echo '<center><h1>jwt Decode/Encode</h1></center>';
        echo '<div id="formAlgorithm">';
            echo '<h3>Scegli algoritmo</h3>';
    
            echo '<form>';
                echo 'Scegli';
                echo '<select id="select" onchange="show()">';
                    echo '<option value="HS256">HS256</option>';
                    echo '<option value="RS256">RS256</option>';
                echo '</select>';
            echo '</form>';
        echo '</div>';
        echo '<div id="encoded">';
            echo '<center><h3>Encoded</h3></center>';
            echo '<form id="form1"  method="post" >';
                echo '<textarea rows="12" cols="77" name="infoJWT[jwtString]">'.$jwt.'</textarea><br>';
                echo '<p>Inserisci Public Key</p>';
                echo '<textarea rows="8" cols="77" name="infoJWT[jwtKey]">'.$key.'</textarea><br>';
                echo '<input type="submit" value="Decode" onclick="clickCounter()">';
                echo '<p>'.($valid? "Valid": "Signature Invalid").'</p>';
            echo '</form>';
        echo '</div>';
        echo '<div id="decoded">';
            echo '<center><h3>Decoded</h3></center>';
            echo '<form id="form2"  method="post" onload="clickCounter()">';
                echo '<p>HEADER:ALGORITHM &#38; TOKEN TYPE</p>';
                echo '<textarea readonly rows="4" cols="77" ></textarea><br>';
                echo '<p>PAYLOAD:DATA</p>';
                echo '<textarea rows="8" cols="77" name="jwtJSON[payload]">'.$decoded.'</textarea><br>';
                echo '<p>VERIFY SIGNATURE</p>';
                echo '<textarea readonly rows="4" cols="77" ></textarea><br>';
                echo '<input type="submit" value="Encode" onclick="clickCounter()">';
                echo '<div id="chiavi">';
                    echo '<p>Inserisci chiave pubblica</p>';
                    echo '<textarea rows="4" cols="77" name="jwtJSON[publicKey]">'.$publicKey.'</textarea><br>';
                    echo '<p>Inserisci chiave privata</p>';
                    echo '<textarea rows="4" cols="77" name="jwtJSON[privateKey]">'.$privateKey.'</textarea><br>';
                echo '</div>';
            echo '</form>';
        echo '</div>';
        echo '<div id="counter">';
        echo '<p id="numberD_E"></p>';
        echo '</div>';
    
        
    
    ?>
</body>

    
    
</html>
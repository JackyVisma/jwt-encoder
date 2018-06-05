<html>

<head>
    <title>JWT Encode/Decode</title>
    
    <style>
        body{
            background-color: lightcyan;
        }
        #encoded{
            position: absolute;
            top: 40%;
            left: 5%;
            background-color: bisque;
            padding-left: 10px;
            padding-right: 10px;

        }
        
        #decoded{
            position: absolute;
            top: 40%;
            left: 60%;
            background-color: bisque;
            padding-left: 10px;
            padding-right: 10px;
        }
        #jwtJSON3{
            background-color: #F0F0F0;
            color: #00b9f1;
        }
        #formAlgorithm{
            position: absolute;
            left: 45%;
            top: 10%;
            background-color: bisque;
        }
        #chiavi{
            display: none;
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
    </script>
</head>
    
        <?php
        
        require_once 'php-jwt/src/JWT.php';
        require_once 'php-jwt/src/BeforeValidException.php';
        require_once 'php-jwt/src/SignatureInvalidException.php';
        require_once 'php-jwt/src/ExpiredException.php';
		use Firebase\JWT\JWT;
    
        if(!empty($_POST['infoJWT'])){
            $infoJWT = $_POST['infoJWT'];
            
            $key = $infoJWT["jwtKey"];
            var_dump($key);
            if($key == ''){
                $key = "example_key";
            }
            var_dump($key);
            
            $prova = base64_decode($infoJWT["jwtString"]);
            var_dump($prova);
            $algorithm = substr($prova, 8,5);
            var_dump($algorithm);
            /*$tks = explode('.', $infoJWT);
            list($headb64, $payload, $cryptob64) = $tks;
            $decoded = JWT::jsonDecode(JWT::urlsafeB64Decode($payload));*/
            try{
                
                $decoded = JWT::decode($infoJWT["jwtString"], $key, array($algorithm));

                print_r($decoded);
                $jwt = JWT::encode($decoded, $key);
            }
            catch(Exception $e) {
                var_dump($e);
                echo 'Signature Verification Failed';
                
            }
            
        }
        else{
          $infoJWT = "";
          $key = "";
          $jwt = "";
          $decoded = "";
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
        else{
            $infoJSON = "";
            $key = "";
            $publicKey = "";
            $privateKey = "";
            $jwt = "";
            $decoded = "";
        }
    
    ?>
<body>
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
            echo '<form id="form1" action="http://localhost:8081/jwt-encoder/" method="post">';
                echo '<textarea rows="20" cols="77" name="infoJWT[jwtString]">'.$jwt.'</textarea><br>';
                echo '<p>Inserisci Public Key</p>';
                echo '<textarea rows="8" cols="77" name="infoJWT[jwtKey]">'.$key.'</textarea><br>';
                echo '<input type="submit" value="Decode">';
            echo '</form>';
        echo '</div>';
        echo '<div id="decoded">';
            echo '<center><h3>Decoded</h3></center>';
            echo '<form id="form2" action="http://localhost:8081/jwt-encoder/" method="post">';
                echo '<p>HEADER:ALGORITHM &#38; TOKEN TYPE</p>';
                echo '<textarea readonly rows="4" cols="77" ></textarea><br>';
                echo '<p>PAYLOAD:DATA</p>';
                echo '<textarea rows="8" cols="77" name="jwtJSON[payload]">'.$decoded.'</textarea><br>';
                echo '<p>VERIFY SIGNATURE</p>';
                echo '<textarea readonly rows="4" cols="77" ></textarea><br>';
                echo '<input type="submit" value="Encode">';
                echo '<div id="chiavi">';
                    echo '<p>Inserisci chiave pubblica</p>';
                    echo '<textarea rows="4" cols="77" name="jwtJSON[publicKey]">'.$publicKey.'</textarea><br>';
                    echo '<p>Inserisci chiave privata</p>';
                    echo '<textarea rows="4" cols="77" name="jwtJSON[privateKey]">'.$privateKey.'</textarea><br>';
                echo '</div>';
            echo '</form>';
        echo '</div>';
            
    ?>
    
    <!--<center><h1>jwt Decode/Encode</h1></center>
    <div id="encoded">
        <center><h3>Encoded</h3></center>
        <form id="form1" >
            <textarea rows="20" cols="77" id="jwtString"></textarea><br>
            <input type="submit" value="Invia">
        </form>
    </div>
    <div id="decoded">
        <center><h3>Decoded</h3></center>
        <form id="form2">
            <p>HEADER:ALGORITHM &#38; TOKEN TYPE</p>
            <textarea rows="8" cols="77" id="jwtJSON1"></textarea><br>
            <p>PAYLOAD:DATA</p>
            <textarea rows="8" cols="77" id="jwtJSON2"></textarea><br>
            <p>VERIFY SIGNATURE</p>
            <textarea rows="8" cols="77" id="jwtJSON3"></textarea><br>
        </form>
    </div>
    -->
    

    
    
</body>

    
    
</html>
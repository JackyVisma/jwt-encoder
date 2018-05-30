<html>

<head>
    <title>JWT Encode/Decode</title>
    
    <style>
        
        #encoded{
            position: absolute;
            top: 50%;
            background-color: antiquewhite;
            padding-left: 10px;
            padding-right: 10px;

        }
        
        #decoded{
            position: absolute;
            top: 30%;
            left: 60%;
            background-color: bisque;
            padding-left: 10px;
            padding-right: 10px;
        }
        #jwtJSON3{
            background-color: #F0F0F0;
            color: #00b9f1;
        }
    
    </style>
</head>
    
        <?php
        
        require_once 'php-jwt/src/JWT.php';
        require_once 'php-jwt/src/BeforeValidException.php';
        require_once 'php-jwt/src/SignatureInvalidException.php';
        require_once 'php-jwt/src/ExpiredException.php';
		use Firebase\JWT\JWT;
    
        $key = "example_key";
        if(!empty($_POST['jwtString'])){
            $infoJWT = $_POST['jwtString'];
            //var_dump($infoJWT);
            
            $decoded = JWT::decode($infoJWT, $key, array('HS256'));

            print_r($decoded);
            $decoded_array = (array) $decoded;
            var_dump($decoded_array);
            var_dump($jwt);
        }
        else{
          $infoJWT = "";  
        }
        
        if(!empty($_POST['jwtJSON'])){
            $infoJSON = $_POST['jwtJSON'];
            $jwt = JWT::encode($infoJSON, $key);
            
        }
        else{
            $infoJSON = "";
        }
    
    ?>
<body>
    <?php
        
        echo '<center><h1>jwt Decode/Encode</h1></center>';
        echo '<div id="encoded">';
            echo '<center><h3>Encoded</h3></center>';
            echo '<form id="form1" action="http://localhost:8081/jwt-encoder/" method="post">';
                echo '<textarea rows="20" cols="77" name="jwtString">'.$infoJWT.'</textarea><br>';
                echo '<input type="submit" value="Decode">';
            echo '</form>';
        echo '</div>';
        echo '<div id="decoded">';
            echo '<center><h3>Decoded</h3></center>';
            echo '<form id="form2" action="http://localhost:8081/jwt-encoder/" method="post">';
                echo '<p>HEADER:ALGORITHM &#38; TOKEN TYPE</p>';
                echo '<textarea readonly rows="8" cols="77" ></textarea><br>';
                echo '<p>PAYLOAD:DATA</p>';
                echo '<textarea rows="8" cols="77" name="jwtJSON"></textarea><br>';
                echo '<p>VERIFY SIGNATURE</p>';
                echo '<textarea readonly rows="8" cols="77" ></textarea><br>';
                echo '<input type="submit" value="Encode">';
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
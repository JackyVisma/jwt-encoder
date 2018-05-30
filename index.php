<html>

<head>
    <title>JWT Encode/Decode</title>
    
    <style>
        
        #encoded{
            position: absolute;
            top: 10%;
            background-color: antiquewhite;
            
            padding-left: 10px;
            padding-right: 10px;

        }
        
        #decoded{
            position: absolute;
            top: 10%;
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
    
    
<body>
    <center><h1>jwt Decode/Encode</h1></center>
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
            <p>HEADER:ALGORITHM & TOKEN TYPE</p>
            <textarea rows="8" cols="77" id="jwtJSON1"></textarea><br>
            <p>PAYLOAD:DATA</p>
            <textarea rows="8" cols="77" id="jwtJSON2"></textarea><br>
            <p>VERIFY SIGNATURE</p>
            <textarea rows="8" cols="77" id="jwtJSON3"></textarea><br>
        </form>
    </div>
</body>

</html>

<!DOCTYPE html>
<head>
<title>≥ÈΩ±”Œœ∑</title>
<style type = "text/CSS">
*{margin:0;padding:0;font-size:12px;}
body{background-color:#2C1914;font-family:"ÀŒÃÂ";}
a img;ul,li{list-style:none;}
a{text-decoration:none;outline:none;font-size:12px;}
input,textarea,select,button{font-size:100%;}
.abs{position:absolute;}
.rel{position:relative;}
.warp{min-height:1000px;}
.main{height:718px;}
.con980{width:980px;margin:0 auto;}
.header{width:100%;height:50px;}
.play{background:url() no-repeat;width:980px;height:625px;padding:22px 0 0 21px;}
td{width:187px;height:115px;font-family:"Œ¢»Ì∫⁄ÃÂ";background-color:#666;text-align:center;line-height:115px;font-size:80px;}
.playcurr{background-color:#F60;}
.playnormal{background-color:#666;}
.play_btn{width:480px;height:115px;display:block;background-color:#F60;border:0;
           cursor:pointer;font-family:"Œ¢»Ì∫⁄ÃÂ";font-size:40px;}
.play_btn:hover{background-position:0 -115px;}
.btn_arr{left:255px;top:255px;}
</style>
</head>
<body>
<div class="wrap">
      <div class="header"></div>
	  <div class="main">
	     <div class="com980">
		    <div class="play rel">
			  <p class ="btn_arr abs"><input value="µ•ª˜¡ÏΩ±"id="btn1" type="button"
			     onclick="startgame()"class="play_btn"></p>
<table class="playtab"id="tb"cellpadding="0"cellspacing="1">
<tr>
   <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>
</tr>
<tr>
   <td>16</td><td></td><td></td><td></td><td>6</td>
</tr>
<tr>
   <td>15</td><td></td><td></td><td></td><td>7</td>
</tr>
<tr>
   <td>14</td><td></td><td></td><td></td><td>8</td>
</tr>
<tr>
   <td>13</td><td>12</td><td>11</td><td>10</td><td>9</td>
</tr>
</table>
         </div>
	   </div>
	  </div>
</div>
<script type="text/javascaript">
function Trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g"");
}

function GetSide(m,n)
{
    var arr=[];
	for(var i=0;i<m;i++)
	{
	    arr.push([]);
		for(var j=0;j<n;j++)
		{
		    arr[i][j]=i*n+j;
		}
	}
	var resultArr=[];
	var tempX=0,
	    tempY=0,
		direction="Along",
		count=0;
	while(tempX>=0&&tempX<n&&tempY>=0&&tempY<m&&count<m*n)
	{
	    count++;
		resultArr.push([tempX,tempY]);
		if(direction=="Along")
		{   
		    if(tempX==n-1)
		        tempY++;
			else
			   tempX++;
			if(tempX==n-1&&tempY==m-1)
			    direction="Inverse"
		}
		else
		{
		    if(tempx==0)
			    tempY--;
			else
			    tempX--;
			if(tempX==0&&tempY==0)
			    break;
		}		 		  
	}
	return resultArr;
}
var index=0,prevIndex=0,Speed=300,Time,arr=GetSide(5,5),EndIndex=0,
     tb=document.getElementById("tb"),cycle=0,EndCycle=0,flag=false,quick=0,
	 btn=document.getElementById("btn1");
	 
function StartGame()
{
   clearInterval(time);
   cycle=0;
   flag=false;
   EndIndex=Math.floor(Math.Random()*16);
   EndCycle=1;
   Time = setInterval(Star,Speed);
}

function Star(num)
{
    if(flag==false)
	 {
	    if(quick==5)
		{
		   clearInterval(Time);
		   Speed=50;
		   Time=setInterval(Star,Speed);
		}
		if(cycle==EndCycle+1&&index==parseInt(EndIndex))
		{
		    clearInterval(Time);
			Speed=300;
			flag=true;
			Time=setInterval(Star,Speed);
		}
	 }
	 if(index>=arr.length)
	 {
	    index=0;
		cycle++;
	 }
	 if(flag==true&&index==parseInt(Trim('5'))-1)
	 {
	     quick=0;
		 clearInterval(Time);
	 }
	 tb.rows[arr[index][0]].cells[arr[index][1]].className="playcurr";
	 if(index>0)
	 {
	     prevIndex=index-1;
	 }
	 else
	 {
	     prevIndex=arr.length-1;
	 }
	 tb.rows[arr[index][0]].cells[arr[index][1]].className="playnormal";
	 index++;
	 quick++;
}
</script>
	 
</body>
</html>













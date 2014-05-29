<!DOCTYPE HTML>
<html>
  <head>
     <meta charset ="utf-8">
	 <title>tachishe</title>
	 <script>
	    var AsphyreNode = function(x,y,w,h)
		{
		    this.x=x;
			this.y=y;
			this.w=w;
			this.h=h;
			this.equals=function(node){
			   if(this.x==node.x&&this.y==node.y)
			       return true;
				else
				   return false;
			}
		};
		function Asphyre(farm,x,y,speed,initNodes)
		{
		    var self =this;
			this.perform = null;
			this.speed=speed;
			this.speedParam=speed*initNodes;
			this.nodeSize=10;
			this.nodes=[];
			this.initNodes=initNodes;
			this.farm=farm;
			this.x=x;
			this.y=y;
			this.direction=10;
			this.left=-10,this.right=10;
			this.down=1,this.up=-1;
			document.onkeypress = function(event){
			    event =event||window.event;
				var code = event.keyCode||event.charCode();
				var isException = false;
				switch(code){
				    case 37:
					    if(self.direction + self.left){
						    self.direction=self.left;
						}else isException = true;
						break;
					case 38:
					    if(self.direction + self.up){
						    self.direction=self.up;
						}else isException = true;
						break;
					case 39:
					    if(self.direction + self.right){
						    self.direction=self.right;
						}else isException = true;
						break;
					case 40:
					    if(self.direction + self.down){
						    self.direction=self.down;
						}else isException = true;
						break;
				}
				if(isException){
				    alert("方向异常，不能倒退！");
				}
			}
		};
		Asphyre.prototype={
		    init:function(){
			   var self = this,farm=this.farm,x=this.x,y=this.y;
			   this.nodes=[];
			   for(var i=0;i<this.initNodes;i++)
			   {
			       this.nodes[i] = new AsphyreNode(this.x-i*10,this.y,this.nodeSize,this.nodeSize);
			   }
			   this.farm.food=this.farm.newFood(this);
			   this.farm.repaint(this);
			},
			drawNodes:function(context){
			    var self=this;
				context.fillStyle="#000000";
				context.strokeStyle="#FFFFFFF";
				for(var i=0;i<this.node.length;i++)
				{
				    context.fillRect(this.nodes[i].x,this.nodes[i].y,this.nodeSize,this.nodeSize);
					context.strokeRect(this.nodes[i].x,this.nodes[i].y,this.nodeSize,this.nodeSize);
				}
			},
			eatFood:function(){
			    var self = this;
				self.nodes.unshift(self.farm.food);
				self.farm.food=self.farm.newFood(self);
				self.refreshSpeed();
			},
			start:function(){
			    var self=this;
				self.init();
				if(!self.perform)
				     self.perform=setInterval(self.go,self.speed,this);
			},
			continueRun:function(){
			    var self=this;
				if(!self.perform)
				     self.perform=setInterval(self.go,self.speed,this);
			},
			stop:function(){
			   var self=this;
			   if(!self.perform)
			        clearInterval(self.perform);
				self.perform=null;
				self.farm.clear();
			},
			pause:function(){
			   var self=this;
			   if(!self.perform)
			        clearInterval(self.perform);
				self.perform=null;
			},
			go:function(param){
			    var self=param;
				switch(self.direction){
				   case -1:
						if(self.nodes[0].equals(self.farm.food))
						{
							self.farm.food.y-=self.nodeSize;
							self.eatFood();
							self.farm.repaint(self);
						    return;
						}
						var varluable = self.nodes[0].y-self.nodeSize;
						if(varluable<0)
						{
							varluable=self.farm.farmElem.height-self.nodeSize;
						}
						self.nodes.unshift(new AsphyreNode(self.nodes[0].x,varluable,self.nodeSize,self.nodeSize));
						self.nodes.pop();
						break;	
					case 1:
						if(self.nodes[0].equals(self.farm.food))
						{
							self.farm.food.y+=self.nodeSize;
							self.eatFood();
							self.farm.repaint(self);
						    return;
						}
						var varluable = self.nodes[0].y+self.nodeSize;
						if(varluable>self.farm.farmElem.height-self.nodeSize)
						{
							varluable=0;
						}
						self.nodes.unshift(new AsphyreNode(self.nodes[0].x,varluable,self.nodeSize,self.nodeSize));
						self.nodes.pop();
						break;	
					case -10:
						if(self.nodes[0].equals(self.farm.food))
						{
							self.farm.food.x-=self.nodeSize;
							self.eatFood();
							self.farm.repaint(self);
						    return;
						}
						var varluable = self.nodes[0].x-self.nodeSize;
						if(varluable<0)
						{
							varluable=self.farm.farmElem.width-self.nodeSize;
						}
						self.nodes.unshift(new AsphyreNode(varluable,self.nodes[0].y,self.nodeSize,self.nodeSize));
						self.nodes.pop();
						break;	
					case 10:
						if(self.nodes[0].equals(self.farm.food))
						{
							self.farm.food.x+=self.nodeSize;
							self.eatFood();
							self.farm.repaint(self);
						    return;
						}
						var varluable = self.nodes[0].x+self.nodeSize;
						if(varluable>self.farm.farmElem.width-self.nodeSize)
						{
							varluable=0;
						}
						self.nodes.unshift(new AsphyreNode(varluable,self.nodes[0].y,self.nodeSize,self.nodeSize));
						self.nodes.pop();
						break;		
				}
				self.farm.repaint(self);
				for(var i=1;i<self.nodes.length;i++)
				{
				    if(self.nodes[0].equals(self.nodes[1]))
					{
					    self.die();
						break;
					}
				}
				
			},
			refreshSpeed:function(){
			    var self = this;
				this.speed = Math.round(this.speedParam);
				self.stop();
				self.continueRun();
			},
			die:function(){
			    var self = this,context=this.farm.context;
				self.pause();
				document.getElementById("pause").disabled=true;
				document.getElementById("continue").disabled=true;
				document.getElementById("stop").disabled=true;
				self.drawOver(context);
			},
			drawOver:function(){
			    context.save();
				context.font="60px impact";
				context.fillStyle="#000000";
				context.textAlign="center";
				context.fillText("GAME OVER!",250,250);
			},
		};
		var farm = function(farmId){
		    this.farmElem=document.getElementById(farmId);
			this.context=this.farmElem.getContext("2d");
			this.food=null;
			this.init();
		};
		Farm.prototype={
		    init:function(){
			    var self =this,farm=this.farmElem,context=this.context;
				var w = farm.width,h=farm.height;
				context.fillStyle="#E8FFFF";
				context.strokeStyle="#000000";
				context.fillRect(0,0,w,h);
				context.strokeRect(0,0,w,h);
			},
			clear:function(){
			    var self =this,farm=this.farmElem,context=this.context;
				var w = farm.width,h=farm.height;
				context.fillStyle="#E8FFFF";
				context.strokeStyle="#000000";
				context.fillRect(0,0,w,h);
				context.strokeRect(0,0,w,h);
			},
			repaint:function(snake){
			    var self=this;
				self.clear();
				self.drowFood(snake);
				snake.drawNodes(snake.farm.context);
			},
			newFood:function(snake){
			    var x,y;
				var flag = true;
				k:
				while(flag){
				    x=Math.round(Math.random()*(this.farmElem.width-10)/10)*10;
					y=Math.round(Math.random()*(this.farmElem.height-10)/10)*10;
					for(var i=0;i<snake.nodes.length;i++)
					{
						if(snake.nodes[i].x==x&&snake.nodes[i].y==y)
						{
							break k;
						}
					}
					flag=false;
				}
				return new AsphyreNode(x,y,snake.nodeSize,snake.nodeSize);
			},
			drowFood:function(){
				this.context.filetype="#FEF045";
				this.context.strokeStyle="#FFFFFF";
				this.context.fillRect(this.food.x,this.food.y,this.food.w,this.food.h);
				this.context.strokeRect(this.food.x,this.food.y,this.food.w,this.food.h);
			},
		};
		var Game = function(){
		    this.snake=new Asphyre(new Farm("canvas"),200,200,500,5);
		};
		Game.prototype={
			start:function(){
				this.snake.start();
			},
			stop:function(){
				this.snake.stop();
			},
			pause:function(){
				this.snake.pause();
			},
			continueRun:function(){
				this.snake.continueRun();
			},
		};
			
	 </script>
  </head>
  <body>
	<div id="wrapper"style="text-align:center;">
		<canvas id="canvas"width="500"height="500"></canvas><br/>
		<input type="button"value="NEW GAME"id="start"/>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button"value="GO ON"id="continue"disabled="true"/>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button"value="THE END"id="stop"disabled="true"/>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button"value="PAUSE"id="pause"disabled="true"/>&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	<script>
	    var game = new Game();
		    document.getElementById("start").onclick=function(){
				game.start();
				document.getElementById("continue").disabled=true;
				document.getElementById("pause").disabled=false;
				document.getElementById("stop").disabled=false;
				this.disabled=true;
			};
			document.getElementById("stop").onclick=function(){
				game.stop();
				document.getElementById("start").disabled=false;
				document.getElementById("pause").disabled=true;
				document.getElementById("continue").disabled=true;
			};
			document.getElementById("pause").onclick=function(){
				game.pause();
				document.getElementById("stop").disabled=true;
				document.getElementById("continue").disabled=false;
				document.getElementById("start").disabled=false;
				this.disabled=true;
			};
			document.getElementById("continue").onclick=function(){
				game.continueRun();
				this.disabled=true;
				document.getElementById("stop").disabled=false;
				document.getElementById("start").disabled=false;
				document.getElementById("pause").disabled=false;
			};
	</script>
	
  </body>
</html>











